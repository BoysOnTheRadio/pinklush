<?php
header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json");

require_once ".../db_connect.php";

$data = json_decode (file_get_contents("php://input"), true);

$service_id = (int) ($data['service_id'] ?? 0);

if (!$service_id) {
    echo json_encode ([
        "success" => false,
        "message" => "service ID is required"
    ]);
    exit;
}

$query = "DELETE FROM service WHERE service_id = ?";
$stmt = mysqli_prepare ($con, $query);
mysqli_stmt_bind_param($stmt, "i", $service_id);

if (mysqli_stmt_execute($stmt)){
    echo json_encode(
        [
            "success" => true,
            "message" => "Service successfully deleted"
        ]
        );
}else {
    echo json_encode (
        [
            "success" => false,
            "message" => "Failed to delete service"
        ]
        );
}




?>