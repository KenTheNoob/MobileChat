<?php
include 'db.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        $result = $conn->query("SELECT * FROM users");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode(["users" => $users]);
        break;
    case 'POST':
        $email = $input['email'];
        $password = $input['password'];
        $first_name = $input['first_name'];
        $last_name = $input['last_name'];
        $conn->execute_query("INSERT INTO users (email, password, first_name, last_name) VALUES (?, ?, ?, ?)", [$email, password_hash($password, PASSWORD_BCRYPT), $first_name, $last_name]);
        echo json_encode(["user_id" => $conn->insert_id, "email" => $email, "first_name" => $first_name, "last_name" => $last_name]);
        break;
    default:
        echo json_encode(["error_code" => "405", "error_title" => "Connection failure", "error_message" => "Method not allowed"]);
        break;
}

$conn->close();
?>