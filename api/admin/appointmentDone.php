<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../db_connect.php";

// get input data (expects JSON with appointment_id)
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['appointment_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing appointment_id"
    ]);
    exit;
}

$appointment_id = intval($data['appointment_id']);

// update the status to 'done'
$query = "UPDATE appointments SET status = 'Done' WHERE appointment_id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $appointment_id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "success" => true,
        "message" => "Appointment status updated to done."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to update appointment status."
    ]);
}
?>