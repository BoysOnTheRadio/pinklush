<?php
header("Content-Type: application/json");

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db_connect.php';

$query = "SELECT service_id, service_type, service_name, description, price, duration FROM service";
$result = mysqli_query($conn, $query);

$services = [];

while ($row = mysqli_fetch_assoc($result)) {
    $services[] = $row;
}

echo json_encode(["success" => true, "services" => $services]);