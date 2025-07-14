<?php
header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json");

require_once ".../db_connect.php";

$data = json_decode (file_get_contents("php://input"), true);

$employee_id = (int) ($data['employee_id'] ?? 0);

if (!$employee_id) {
    echo json_encode ([
        "success" => false,
        "message" => "Employee ID is required"
    ]);
    exit;
}

$query = "DELETE FROM employee WHERE employee_id = ?";
$stmt = mysqli_prepare ($con, $query);
mysqli_stmt_bind_param($stmt, "i", $employee_id);

if (mysqli_stmt_execute($stmt)){
    echo json_encode(
        [
            "success" => true,
            "message" => "Employee successfully deleted"
        ]
        );
}else {
    echo json_encode (
        [
            "success" => false,
            "message" => "Failed to delete employee"
        ]
        );
}




?>