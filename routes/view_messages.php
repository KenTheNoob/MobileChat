<?php
$sender_user_id = $_GET['user_id_a'] ?? null;
$receiver_user_id= $_GET['user_id_b'] ?? null;

if (!isset($sender_user_id, $receiver_user_id)) {
    error_response(400, "Bad Request", "Missing required URL parameters");
}

if (!ctype_digit($sender_user_id) || !ctype_digit($receiver_user_id)) {
    error_response(400, "Bad Request", "User IDs must be integers");
}

if ($sender_user_id == $receiver_user_id) {
    error_response(400, "Bad Request", "User IDs cannot be the same");
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
    error_response(500, "Internal Server Error", "Failed to view messages");
}

// View messages between the two users
try {
    $result = $conn->execute_query(
        "SELECT message_id, sender_user_id, message, epoch FROM messages WHERE (sender_user_id = ? AND receiver_user_id = ?) OR (sender_user_id = ? AND receiver_user_id = ?) ORDER BY epoch",
        [$sender_user_id, $receiver_user_id, $receiver_user_id, $sender_user_id]
    );

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $row['epoch'] = (float) $row['epoch'];
        $messages[] = $row;
    }

    echo json_encode(["messages" => $messages]);
} catch (mysqli_sql_exception $e) {
    error_response(500, "Internal Server Error", "Failed to view messages");
}
?>