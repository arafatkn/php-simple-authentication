<?php

include 'inc/functions.php';
include 'inc/db.php';

if(!is_logged())
{
    redir("login.php");
    exit;
}

$user = getCurrentUser();

?>

<?php include 'inc/header.php'; ?>

<div class="card">
    <div class="card-header">
        <h3>Welcome, <?=$user["username"]?>!</h3>
    </div>
</div>

<?php include 'inc/footer.php'; ?>