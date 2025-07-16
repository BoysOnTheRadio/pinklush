<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../db_connect.php";

// build base query
$query = "SELECT 
    a.appointment_id,
    a.customer_name,
    a.customer_phone,
    a.customer_address,
    a.appointment_date,
    s.service_name,
    e.name AS stylist,
    b.address AS branch
FROM appointments a
LEFT JOIN service s ON a.service_id = s.service_id
LEFT JOIN schedule sch ON s.shift_id = sch.shift_id
LEFT JOIN employee e ON sch.employee_id = e.employee_id
LEFT JOIN branch b ON sch.branch_id = b.branch_id
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

$stmt = mysqli_prepare($con, $query);

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