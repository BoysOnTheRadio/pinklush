<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

require_once "../db_connect.php"; 

$input = json_decode(file_get_contents("php://input"));

// checks if required fields are present
if (
    !isset($input->service_id) ||
    !isset($input->customer_name) ||
    !isset($input->customer_phone) ||
    !isset($input->customer_address) ||
    !isset($input->appointment_date)
) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Missing required fields."]);
    exit;
}

try {
    // checks if the service_id exists in the services table
    $check = $pdo->prepare("SELECT COUNT(*) FROM services WHERE serviceID = ?");
    $check->execute([$input->serviceID]);
    $exists = $check->fetchColumn();

    if (!$exists) {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Service ID not found."]);
        exit;
    }

    // insert the appointment
    $stmt = $pdo->prepare("INSERT INTO appointment (service_id, customer_name, customer_phone, customer_address, appointment_date) 
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $input->service_id,
        $input->customer_name,
        $input->customer_phone,
        $input->customer_address,
        $input->appointment_date
    ]);

    echo json_encode([
        "success" => true,
        "appointmentID" => $pdo->lastInsertId(),
        "message" => "Appointment created successfully."
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Server error: " . $e->getMessage()
    ]);
}
?>