<?php
function error_response($error_code, $error_title, $error_message) {
    echo json_encode(["error_code" => $error_code, "error_title" => $error_title, "error_message" => $error_message]);
    exit();
}
?>