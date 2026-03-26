<?php
$sender_user_id = $_GET['user_id_a'];
$receiver_user_id= $_GET['user_id_b'];

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
?>