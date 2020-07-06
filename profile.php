<?php

include 'inc/functions.php';
include 'inc/db.php';

if(!is_logged())
{
    redir("login.php");
    exit;
}

$user = getCurrentUser();

if(count($_POST) && isset($_POST["username"]) && isset($_POST["email"]))
{
    $errors = [];
    $username = post('username');
    $password = post('password');
    $email = post('email');

    if(empty($username))    $signup_error[] = "Username can not be empty!";
    if(empty($email))    $signup_error[] = "Email can not be empty!";
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $signup_error[] = "Email is invalid!";

    $username = $mysqli->real_escape_string($username);
    $email = $mysqli->real_escape_string($email);

    if($username!=$user["username"])
    {
        $result = $mysqli->query("SELECT * FROM users WHERE username='$username' LIMIT 1");
        if($result->num_rows > 0)   $signup_error[] = "Username already exists!";
    }

    if($email!=$user["email"])
    {
        $result = $mysqli->query("SELECT * FROM users WHERE email='$email' LIMIT 1");
        if($result->num_rows > 0)   $signup_error[] = "Email already exists!";
    }

    if(count($errors) == 0)
    {
        $uid = $user['id'];
        if(empty($password))
        {
            $query = "UPDATE users SET `username`='$username', `email`='$email' WHERE  `id`='$uid'";
        }
        else
        {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $query = "UPDATE users SET `username`='$username', `email`='$email', `password`='$password' WHERE  `id`='$uid'";
        }
        
        $operation = $mysqli->query($query);
        if($operation)
        {
            $_SESSION["message"] = "Profile Data has been updated";
        }
        else
        {
            $signup_error[] = "Something is wrong. Please try again.";
        }
    }
}

?>

<?php include 'inc/header.php'; ?>

<br>
<h4 class="text-center">User Profile</h4>
<hr>

<div class="row justify-content-center">
	<div class="col-sm-6">
        <?=showMessage()?>
        <div class="card">
        <article class="card-body">
        <h4 class="card-title mb-4 mt-1">Edit Profile</h4>
        <hr>

        <?=isset($errors) && count($errors)?showError($errors):''?>

        <form method="post">
            <div class="form-group">
                <label>Your Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo post('email', $user["email"]); ?>" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label>Your Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo post('username', $user["username"]); ?>" required>
            </div>
            <div class="form-group">
                <label>Your Password (Leave empty if you do not want to change)</label>
                <input type="password" name="password" class="form-control" placeholder="******">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block"> Update Details  </button>
            </div> <!-- form-group// -->                                                           
        </form>
        </article>
        </div> <!-- card.// -->
	</div> <!-- col.// -->
</div> <!-- row.// -->

<?php include 'inc/footer.php'; ?>