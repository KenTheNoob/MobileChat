<?php
$input = json_decode(file_get_contents('php://input'), true);

$email = $input['email'] ?? null;
$password = $input['password'] ?? null;
$first_name = $input['first_name'] ?? null;
$last_name = $input['last_name'] ?? null;

if (!isset($email, $password, $first_name, $last_name)) {
    error_response(400, "Bad Request", "Missing required fields");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    error_response(400, "Bad Request", "Invalid email format");
}

if (strlen($password) < 6) {
    error_response(400, "Bad Request", "Password must be at least 6 characters");
}

// Check if email already exists
try {
    $result = $conn->execute_query(
        "SELECT user_id FROM users WHERE email = ?",
        [$email]
    );
    if ($result->num_rows > 0) {
        error_response(409, "Conflict", "Email already taken");
    }
} catch (mysqli_sql_exception $e) {
    error_response(500, "Internal Server Error", "Failed to check email uniqueness");
}

// Register new user
try {
    $conn->execute_query("INSERT INTO users (email, password, first_name, last_name) VALUES (?, ?, ?, ?)", [$email, password_hash($password, PASSWORD_BCRYPT), $first_name, $last_name]);
    echo json_encode(["user_id" => $conn->insert_id, "email" => $email, "first_name" => $first_name, "last_name" => $last_name]);
} catch (mysqli_sql_exception $e) {
    error_response(500, "Internal Server Error", "Failed to register user");
}
?>