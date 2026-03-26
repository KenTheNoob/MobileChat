<?php
$input = json_decode(file_get_contents('php://input'), true);

$email = $input['email'];
$password = $input['password'];
$first_name = $input['first_name'];
$last_name = $input['last_name'];

$conn->execute_query("INSERT INTO users (email, password, first_name, last_name) VALUES (?, ?, ?, ?)", [$email, password_hash($password, PASSWORD_BCRYPT), $first_name, $last_name]);
echo json_encode(["user_id" => $conn->insert_id, "email" => $email, "first_name" => $first_name, "last_name" => $last_name]);
?>