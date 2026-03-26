<?php
$input = json_decode(file_get_contents('php://input'), true);

$email = $input['email'] ?? null;
$password = $input['password'] ?? null;

if (!isset($email, $password)) {
  error_response(400, "Bad Request", "Missing required fields");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  error_response(400, "Bad Request", "Invalid email format");
}

// Authenticate user
try {
  $result = $conn->execute_query("SELECT * FROM users WHERE email = ?", [$email]);
  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
    unset($user['password']);  
    echo json_encode(["user_id" => $user['user_id'], "email" => $user['email'], "first_name" => $user['first_name'], "last_name" => $user['last_name']]);
  } else {
    error_response(401, "Login Failure", "Email or Password was Invalid!");
  }
} catch (mysqli_sql_exception $e) {
  error_response(500, "Internal Server Error", "Failed to query user");
}
?>