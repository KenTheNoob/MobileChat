<?php
require(__DIR__ . "/lib/db.php");
require(__DIR__ . "/lib/response.php");

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($path) {
    case '/register':
        if ($method == 'POST') require __DIR__ . '/routes/register.php';
        else error_response(405,'Method Not Allowed','Only accepts POST requests');
        break;
    case '/login':
        if ($method == 'POST') require __DIR__ . '/routes/login.php';
        else error_response(405,'Method Not Allowed','Only accepts POST requests');
        break;
    case '/view_messages':
        if ($method == 'GET') require __DIR__ . '/routes/view_messages.php';
        else error_response(405, 'Method Not Allowed', 'Only accepts GET requests');
        break;
    case '/send_message':
        if ($method == 'POST') require __DIR__ . '/routes/send_message.php';
        else error_response(405,'Method Not Allowed','Only accepts POST requests');
        break;
    case '/list_all_users':
        if ($method == 'GET') require __DIR__ . '/routes/list_all_users.php';
        else error_response(405,'Method Not Allowed','Only accepts GET requests');
        break;
    case '/':
        echo json_encode(["status_code" => 200, "status_title" => "OK", "status_message" => "Success"]);
        break;
    default:
        error_response(404, "Not Found", "Endpoint does not exist");
        break;
}

$conn->close();
?>