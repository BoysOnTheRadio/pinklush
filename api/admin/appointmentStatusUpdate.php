<?php
require_once "../db_connect.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"));

if (!isset($input->appointment_id) || !isset($input->status)) {
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
    exit;
}

$appointment_id = $input->appointment_id;
$status = $input->status;

$stmt = $conn->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ?");
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    exit;
}
$stmt->bind_param("si", $status, $appointment_id);
if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}
$stmt->close();
$conn->close();
