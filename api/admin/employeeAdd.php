<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once "../db_connect.php";

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!$name || !$email || !$password) {
    echo json_encode([
        "success" => false,
        "message" => "All fields are required"
    ]);
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO employee (name, email, password) VALUES (?,?,?)";
$stmt = mysqli_prepare ($con, $query);
mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(
        [
            "success" => true,
            "message" => "Employee successfully added"
        ]
        );
} else
{
    echo json_encode([
        "success" => false,
        "message" => "failed to add employee"
    ]);
}
?>
