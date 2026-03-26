<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "mobile_chat";
try {
  $conn = new mysqli($hostname, $username, $password, $dbname);
}
catch (mysqli_sql_exception $e) {
  header("Content-Type: application/json");
  echo json_encode(["error_code" => 500, "error_title" => "Internal Server Error", "error_message" => $e->getMessage()]);
  exit();
}
?>