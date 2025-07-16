<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

require_once "../db_connect.php"; // this should define $conn as a MySQLi connection

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Get JSON input
$input = json_decode(file_get_contents("php://input"));

// Check required fields
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

// Optional fields (use null if not provided)
$facebook = $input->customer_socialmedia_facebook ?? null;
$instagram = $input->customer_socialmedia_instagram ?? null;
$email = $input->customer_email ?? null;

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
    (employee_id, service_id, customer_name, customer_phone, appointment_date, facebook_username, instagram_username, customer_email) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

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
    echo json_encode([
        "success" => true,
        "appointmentID" => $stmt->insert_id,
        "message" => "Appointment created successfully."
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
