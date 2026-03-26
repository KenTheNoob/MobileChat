<?php
$input = json_decode(file_get_contents('php://input'), true);

$sender_user_id = $input['sender_user_id'];
$receiver_user_id = $input['receiver_user_id'];
$message = $input['message'];

$conn->execute_query(
    "INSERT INTO messages (sender_user_id, receiver_user_id, message, epoch) VALUES (?, ?, ?, ?)",
    [$sender_user_id, $receiver_user_id, $message, floor(microtime(true))]
);

echo json_encode(["success_code" => 200, "success_title" => "Message Sent", "success_message" => "Message was sent successfully"]);
?>