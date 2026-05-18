<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

require_once "../db_connect.php"; 

ini_set('display_errors', 1);
error_reporting(E_ALL);

$input = json_decode(file_get_contents("php://input"));

if (
    !isset($input->service_id) ||
    !isset($input->employee_id) ||
    !isset($input->customer_name) ||
    !isset($input->customer_phone) ||
    !isset($input->appointment_date)
) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Missing required fields."]);
    exit;
}

// Optional fields
$facebook = $input->facebook_username ?? null;
$instagram = $input->instagram_username ?? null;
$email = $input->customer_email ?? null;
$branch_id = $input->branch_id ?? null;

// Check if service exists
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM service WHERE service_id = ?");
$checkStmt->bind_param("i", $input->service_id);
$checkStmt->execute();
$checkStmt->bind_result($exists);
$checkStmt->fetch();
$checkStmt->close();

if (!$exists) {
    http_response_code(404);
    echo json_encode(["success" => false, "message" => "Service ID not found."]);
    exit;
}

// Insert appointment 
$stmt = $conn->prepare("
    INSERT INTO appointments 
    (employee_id, service_id, customer_name, customer_phone, appointment_date, facebook_username, instagram_username, email) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param(
    "iissssss",
    $input->employee_id,
    $input->service_id,
    $input->customer_name,
    $input->customer_phone,
    $input->appointment_date,
    $facebook,
    $instagram,
    $email
);

if ($stmt->execute()) {
    $appointment_id = $stmt->insert_id;
    $details_query = "
        SELECT 
            s.service_name,
            b.address as branch_address
        FROM appointments a
        JOIN service s ON a.service_id = s.service_id
        JOIN employee e ON a.employee_id = e.employee_id
        JOIN branch b ON e.branch_id = b.branch_id
        WHERE a.appointment_id = ?
    ";
    
    $details_stmt = $conn->prepare($details_query);
    $details_stmt->bind_param("i", $appointment_id);
    $details_stmt->execute();
    $details_result = $details_stmt->get_result();
    $details = $details_result->fetch_assoc();
    $details_stmt->close();
    
    // --- SEND EMAIL IF CUSTOMER PROVIDED EMAIL ---
    if (!empty($email)) {
        $email_data = [
            'to' => $email,
            'customerName' => $input->customer_name,
            'appointmentDate' => date('F j, Y \a\t g:i A', strtotime($input->appointment_date)),
            'serviceName' => $details['service_name'] ?? 'Beauty Service',
            'branch' => $details['branch_address'] ?? 'PinkLush Branch',
            'appointmentId' => $appointment_id
        ];
        
        // Call Spring Boot email API
        $ch = curl_init('http://localhost:8080/api/email/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($email_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $email_response = curl_exec($ch);
        curl_close($ch);
        
        // Log for debugging
        error_log("Email sent for appointment #$appointment_id to $email");
    }
    
    echo json_encode([
        "success" => true,
        "appointmentID" => $appointment_id,
        "message" => "Appointment created successfully" . (!empty($email) ? ". Confirmation email sent." : "")
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>