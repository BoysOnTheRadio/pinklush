<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../db_connect.php";

// Get branch_id and service_id from query parameters
$branch_id = isset($_GET['branch_id']) ? intval($_GET['branch_id']) : 0;
$service_id = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;

if ($branch_id === 0 || $service_id === 0) {
    echo json_encode(["error" => "Missing branch_id or service_id"]);
    exit;
}

// Get all employees in the branch who can do the given service, including their schedule
$sql = "
SELECT e.employee_id, e.name, sch.day, sch.shift_start, sch.shift_end
FROM employee e
JOIN schedule sch ON sch.employee_id = e.employee_id
JOIN employeeservices es ON es.employee_id = e.employee_id
WHERE sch.branch_id = ?
  AND es.service_id = ?
ORDER BY e.employee_id, sch.day
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $branch_id, $service_id);
$stmt->execute();
$result = $stmt->get_result();

$employees = [];
while ($row = $result->fetch_assoc()) {
    $id = $row['employee_id'];

    if (!isset($employees[$id])) {
        $employees[$id] = [
            'employee_id' => $id,
            'name' => $row['name'],
            'days' => [],
            'shift_start' => $row['shift_start'],
            'shift_end' => $row['shift_end']
        ];
    }

    // Only add unique days (prevent duplicate weekdays)
    if (!in_array($row['day'], $employees[$id]['days'])) {
        $employees[$id]['days'][] = $row['day'];
    }
}

// Output as JSON
echo json_encode(["employees" => array_values($employees)]);

$stmt->close();
$conn->close();
