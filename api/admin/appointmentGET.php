<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db_connect.php';

// build base query
$query = "SELECT 
  a.appointment_id,
  a.customer_name,
  s.service_type,
  e.name AS stylist,
  a.appointment_date,
  a.customer_phone,
  a.facebook_username,
  a.instagram_username,
  b.address,
  a.status
FROM appointments a
LEFT JOIN service s ON a.service_id = s.service_id
LEFT JOIN employee e ON a.employee_id = e.employee_id
LEFT JOIN branch b ON e.branch_id = b.branch_id
WHERE 1=1";

$params = [];

// optional filters
if (isset($_GET['date'])) {
    $query .= " AND DATE(a.appointment_date) = ?";
    $params[] = $_GET['date'];
}
if (isset($_GET['stylist_id'])) {
    $query .= " AND e.employee_id = ?";
    $params[] = $_GET['stylist_id'];
}
if (isset($_GET['branch_id'])) {
    $query .= " AND b.branch_id = ?";
    $params[] = $_GET['branch_id'];
}

$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "SQL Prepare failed: " . mysqli_error($conn),
        "query" => $query
    ]);
    exit;
}

// bind parameters dynamically
if (!empty($params)) {
    $types = str_repeat('s', count($params));
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$appointments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $appointments[] = $row;
}

echo json_encode([
    "success" => true,
    "appointments" => $appointments
]);
?>