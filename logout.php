<?php

include 'inc/functions.php';

unset($_SESSION["user_id"]);

$_SESSION["message"] = "You have been logged out successfully";

redir("login.php");

?>