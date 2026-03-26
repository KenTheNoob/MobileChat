<?php
$input = json_decode(file_get_contents('php://input'), true);

$sender_user_id = $input['sender_user_id'];
$receiver_user_id = $input['receiver_user_id'];
$message = $input['message'];

if (!isset($sender_user_id, $receiver_user_id)) {
    error_response(400, "Bad Request", "Missing required query parameters");
}

if (!ctype_digit((string) $sender_user_id) || !ctype_digit((string) $receiver_user_id)) {
    error_response(400, "Bad Request", "User IDs must be integers");
}

if ($sender_user_id == $receiver_user_id) {
    error_response(400, "Bad Request", "User IDs cannot be the same");
}

if (strlen($message) > 1000) {
    error_response(400, "Bad Request", "Message too long");
}

if (trim($message) == "") {
    error_response(400, "Bad Request", "Message cannot be empty");
}

// Validate that both users exist
try {
    $result = $conn->execute_query(
        "SELECT user_id FROM users WHERE user_id IN (?, ?)",
        [$sender_user_id, $receiver_user_id]
    );
    if ($result->num_rows !== 2) {
    error_response(404, "Not Found", "User(s) do not exist");
}
} catch (mysqli_sql_exception $e) {
    error_response(500, "Internal Server Error", "Failed to send message");
}

// Send message
try {
    $conn->execute_query(
        "INSERT INTO messages (sender_user_id, receiver_user_id, message, epoch) VALUES (?, ?, ?, ?)",
        [$sender_user_id, $receiver_user_id, $message, floor(microtime(true))]
    );
    echo json_encode(["success_code" => 200, "success_title" => "Message Sent", "success_message" => "Message was sent successfully"]);
} catch (mysqli_sql_exception $e) {
    error_response(500, "Internal Server Error", "Failed to send message");
}
?>