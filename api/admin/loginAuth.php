<?php
header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json");

require_once ".../db_connect.php";

$data = json_decode (file_get_contents("php://input"), true);

if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode ([
        "success" => false,
        "message" => "Missing username or password"
    ]);
    exit;
}
$username = $data['username'];
$password = $data['password'];


$query = "SELECT * FROM employee WHERE username = ?";
$stmt = mysqli_prepare ($con, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$employee = mysqli_fetch_assoc($result);

if ($employee) {
    if (password_verify($password, $employee['password'])) {
        echo json_encode([
            "success" => true,
            "message" => "Login successful",
            "user" => [
                "id" => $employee['employee_id'],
                "username" => $employee['username'],
                "name" => $employee['name']
            ]
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Incorrect password"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "User not found"
    ]);
}
?>
