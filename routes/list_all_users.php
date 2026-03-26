<?php
$requester_user_id = $_GET['requester_user_id'];

$result = $conn->execute_query("SELECT user_id, email, first_name, last_name FROM users WHERE user_id <> ?", [$requester_user_id]);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
echo json_encode(["users" => $users]);
?>