<?php
$requester_user_id = $_GET['requester_user_id'] ?? null;

if (!isset($requester_user_id)) {
    error_response(400, "Bad Request", "Missing required query parameters");
}

if (!ctype_digit((string) $requester_user_id)) {
    error_response(400, "Bad Request", "User ID must be an integer");
}

// Validate that the requester user exists
try {
    $result = $conn->execute_query("SELECT user_id FROM users WHERE user_id = ?", [$requester_user_id]);
    if ($result->num_rows === 0) {
        error_response(404, "Not Found", "User does not exist");
    }
} catch (mysqli_sql_exception $e) {
    error_response(500, "Internal Server Error", "Failed to list users");
}

// List all users except the requester
try {
    $result = $conn->execute_query("SELECT user_id, email, first_name, last_name FROM users WHERE user_id <> ?", [$requester_user_id]);

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode(["users" => $users]);
} catch (mysqli_sql_exception $e) {
    error_response(500, "Internal Server Error", "Failed to list users");
}
?>