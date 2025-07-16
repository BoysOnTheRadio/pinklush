<?php
header("Content-Type: application/json");
require_once "../db_connect.php";

$employee_id = isset($_GET['provider_id']) ? intval($_GET['provider_id']) : 0;
$date = $_GET['date'] ?? '';
$service_id = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;

if ($employee_id === 0 || empty($date)) {
    echo json_encode(["error" => "Missing provider_id or date"]);
    exit;
}

// Query counts of appointments by time for that provider and date
$sql = "
    SELECT 
        TIME(appointment_date) AS time_slot,
        COUNT(*) AS count
    FROM appointments
    WHERE employee_id = ?
      AND DATE(appointment_date) = ?
      AND service_id = ?
      AND status = 'Scheduled'
    GROUP BY time_slot
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isi", $employee_id, $date, $service_id);
$stmt->execute();
$result = $stmt->get_result();

$booked = [];
while ($row = $result->fetch_assoc()) {
    // Format time_slot like "09:00 AM"
    $time = date("h:i A", strtotime($row['time_slot']));
    $booked[$time] = intval($row['count']);
}

echo json_encode(["booked" => $booked]);
