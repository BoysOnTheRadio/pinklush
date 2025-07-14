<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../db_connect.php";

$data = json_decode(file_get_contents("php://input"), true);

$service_type = trim($data['service_type'] ?? '');
$shift_id = (int)($data['shift_id'] ?? 0);
$service_name = trim($data['service_name'] ?? '');
$description = trim($data['description'] ?? '');
$duration = (int)($data['duration'] ?? 0);
$price = (float)($data['price'] ?? 0.0);

if (!$service_type || !$shift_id || !$service_name || !$description || !$duration || !$price) {
    echo json_encode([
        "success" => false,
        "message" => "All fields are required"
    ]);
    exit;
}


$query = "INSERT INTO service (service_type, shift_id, service_name, description, duration, price) VALUES (?,?,?,?,?,?)";
$stmt = mysqli_prepare ($con, $query);
mysqli_stmt_bind_param($stmt, "sissid", $service_type, $shift_id, $service_name, $description, $duration, $price);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(
        [
            "success" => true,
            "message" => "Service successfully added"
        ]
        );
} else
{
    echo json_encode([
        "success" => false,
        "message" => "Failed to add Service"
    ]);
}
?>
