<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$branch_id = $data['branch_id'] ?? '';

if (!$name || !$email || !$password || !$branch_id) {
    echo json_encode([
        "success" => false,
        "message" => "All fields are required"
    ]);
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO employee (name, email, password, branch_id) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . mysqli_error($conn)
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $hashed_password, $branch_id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "success" => true,
        "message" => "Employee successfully added"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to add employee: " . mysqli_stmt_error($stmt)
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
