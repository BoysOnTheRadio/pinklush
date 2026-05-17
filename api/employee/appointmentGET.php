<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db_connect.php';

$employee_id = $_GET['employee_id'] ?? '';

if (!$employee_id) {
    echo json_encode([
        "success" => false,
        "message" => "Employee ID is required"
    ]);
    exit;
}

try {
    $query = "SELECT 
                a.appointment_id,
                a.appointment_date,
                a.status,
                c.customer_name,
                c.customer_phone,
                c.facebook_username,
                c.instagram_username,
                s.service_name,
                s.service_type,
                e.name,
                b.address
              FROM appointments a
              JOIN customer c ON a.customer_id = c.customer_id
              JOIN service s ON a.service_id = s.service_id
              JOIN employee e ON a.employee_id = e.employee_id
              JOIN branch b ON e.branch_id = b.branch_id
              WHERE a.employee_id = ?;
              ORDER BY a.appointment_date ASC";

    $stmt = mysqli_prepare($conn, $query);
    
    if (!$stmt) {
        echo json_encode([
            "success" => false,
            "message" => "Database error: " . mysqli_error($conn)
        ]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $employee_id);
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

    mysqli_stmt_close($stmt);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}

mysqli_close($conn);
?> 