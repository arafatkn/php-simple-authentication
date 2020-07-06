<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=isset($title)?$title:'User Dashboard'?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body style="background:#cef">

<div class="container">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark justify-content-between">

        <a class="navbar-brand" href="index.php">UserPanel</a>

        <ul class="navbar-nav">
        <li class="nav-item active"><a class="nav-link" href="index.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout (<?=isset($user)?$user["username"]:getCurrentUser()["username"]?>)</a></li>
        <li class="nav-item" style="padding:0px 20px"></li>
        </ul>
    </nav>