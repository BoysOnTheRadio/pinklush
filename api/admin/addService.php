<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db_connect.php';

// Get the JSON data from the frontend
$data = json_decode(file_get_contents("php://input"), true);

$service_name = $data['service_name'] ?? '';
$service_type = $data['service_type'] ?? '';
$price = $data['price'] ?? 0;
$duration = $data['duration'] ?? 60; // default in minutes
$branch_ids = $data['branch_id'] ?? [];
$employee_ids = $data['employee_id'] ?? [];

if (!$service_name || !$service_type || !$price || empty($branch_ids) || empty($employee_ids)) {
    echo json_encode([
        "success" => false,
        "message" => "All fields are required"
    ]);
    exit;
}

// Insert into `service` table
$query = "INSERT INTO service (service_name, service_type, price, duration) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ssdi", $service_name, $service_type, $price, $duration);

if (mysqli_stmt_execute($stmt)) {
    $service_id = mysqli_insert_id($con);

    // Insert into `branch_services`
    foreach ($branch_ids as $branch_id) {
        $bs_query = "INSERT INTO branch_services (branch_id, service_id) VALUES (?, ?)";
        $bs_stmt = mysqli_prepare($con, $bs_query);
        mysqli_stmt_bind_param($bs_stmt, "ii", $branch_id, $service_id);
        mysqli_stmt_execute($bs_stmt);
    }

    // Insert into `employeeservices`
    foreach ($employee_ids as $employee_id) {
        $es_query = "INSERT INTO employeeservices (employee_id, service_id) VALUES (?, ?)";
        $es_stmt = mysqli_prepare($con, $es_query);
        mysqli_stmt_bind_param($es_stmt, "ii", $employee_id, $service_id);
        mysqli_stmt_execute($es_stmt);
    }

    echo json_encode([
        "success" => true,
        "message" => "Service successfully added",
        "service_id" => $service_id
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to add service"
    ]);
}
?>
