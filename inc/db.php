<?php

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "ferranarroyo";

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
?>