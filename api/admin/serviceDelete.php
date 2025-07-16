<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$service_id = $data['service_id'] ?? null;

if (!$service_id) {
    echo json_encode(["success" => false, "message" => "Service ID required"]);
    exit;
}

mysqli_query($conn, "DELETE FROM branchservices WHERE service_id = $service_id");
mysqli_query($conn, "DELETE FROM employeeservices WHERE service_id = $service_id");

$query = "DELETE FROM service WHERE service_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $service_id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["success" => true, "message" => "Service deleted successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to delete service"]);
}
?>
