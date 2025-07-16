<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db_connect.php';
header("Content-Type: application/json");

$query = "SELECT employee_id, name, email, is_admin, branch_id FROM employee";
$result = mysqli_query($conn, $query);

$employees = [];
while ($row = mysqli_fetch_assoc($result)) {
    $employees[] = $row;
}

echo json_encode(["success" => true, "employees" => $employees]);