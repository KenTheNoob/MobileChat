<?php
$input = json_decode(file_get_contents('php://input'), true);

$email = $input['email'];
$password = $input['password'];

$result = $conn->execute_query("SELECT * FROM users WHERE email = ?", [$email]);
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
  unset($user['password']);  
  echo json_encode(["user_id" => $user['user_id'], "email" => $user['email'], "first_name" => $user['first_name'], "last_name" => $user['last_name']]);
} else {
  echo json_encode(["error_code" => 101, "error_title" => "Login Failure", "error_message" => "Email or Password was Invalid!"]);
}
?>