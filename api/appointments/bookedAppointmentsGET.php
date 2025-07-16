<?php
header("Content-Type: application/json");
require_once "../db_connect.php";

$employee_id = isset($_GET['provider_id']) ? intval($_GET['provider_id']) : 0;
$service_id = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;
$date = $_GET['date'] ?? '';

if ($employee_id === 0 || $service_id === 0 || empty($date)) {
    echo json_encode(["error" => "Missing provider_id, service_id, or date"]);
    exit;
}

// 1. Get the service type and max bookings per slot
$serviceSql = "SELECT service_type, max_bookings_per_slot FROM service WHERE service_id = ?";
$serviceStmt = $conn->prepare($serviceSql);
$serviceStmt->bind_param("i", $service_id);
$serviceStmt->execute();
$serviceResult = $serviceStmt->get_result();
$serviceData = $serviceResult->fetch_assoc();

if (!$serviceData) {
    echo json_encode(["error" => "Invalid service ID"]);
    exit;
}

$serviceType = $serviceData['service_type'];
$maxBookings = intval($serviceData['max_bookings_per_slot']);

// 2. Get counts of current bookings
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
    $time = date("h:i A", strtotime($row['time_slot']));
    $booked[$time] = intval($row['count']);
}

// 3. Return bookings + max allowed
echo json_encode([
    "booked" => $booked,
    "max_per_slot" => $maxBookings,
    "service_type" => $serviceType
]);

$stmt->close();
$serviceStmt->close();
$conn->close();
