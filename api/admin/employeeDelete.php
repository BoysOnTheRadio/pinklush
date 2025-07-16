<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db_connect.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$employeeId = $data["employee_id"] ?? null;

if (!$employeeId) {
    echo json_encode(["success" => false, "message" => "No employee ID provided."]);
    exit;
}

$query = "DELETE FROM employee WHERE employee_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $employeeId);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["success" => true, "message" => "Employee deleted."]);
} else {
    echo json_encode(["success" => false, "message" => "Deletion failed."]);
}



?>