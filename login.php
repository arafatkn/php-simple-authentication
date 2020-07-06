<?php
    include 'inc/functions.php';
    include 'inc/db.php';
    if(is_logged())
    {
        redir("index.php");
        exit;
    }
    if(isset($_POST["do"]) && $_POST["do"]=="login")
    {
        $login_error = [];
        $username = $mysqli->real_escape_string(post('username'));
        $password = post('password');

        $result = $mysqli->query("SELECT * FROM users WHERE username='$username' LIMIT 1");

        if($result->num_rows > 0)
        {
            $user = $result->fetch_assoc();
            if(password_verify($password, $user["password"]))
            {
                $_SESSION["user_id"] = $user["id"];
                redir("index.php");
                exit;
            }
            else
            {
                $login_error[] = "Wrong Password!";
            }
        }
        else
        {
            $login_error[] = "No User Found with this username";
        }
    }
    else if(isset($_POST["do"]) && $_POST["do"]=="signup")
    {
        $signup_error = [];
        $username = post('username');
        $password = post('password');
        $email = post('email');

        if(empty($username))    $signup_error[] = "Username can not be empty!";
        if(empty($email))    $signup_error[] = "Email can not be empty!";
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $signup_error[] = "Email is invalid!";
        if(empty($password))    $signup_error[] = "Password can not be empty!";

        $username = $mysqli->real_escape_string($username);
        $email = $mysqli->real_escape_string($email);

        $result = $mysqli->query("SELECT * FROM users WHERE username='$username' LIMIT 1");
        if($result->num_rows > 0)   $signup_error[] = "Username already exists!";

        $result = $mysqli->query("SELECT * FROM users WHERE email='$email' LIMIT 1");
        if($result->num_rows > 0)   $signup_error[] = "Email already exists!";

        if(count($signup_error) == 0)
        {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO users (username, email, `password`) VALUES ('$username', '$email', '$password')";
            $operation = $mysqli->query($query);
            if($operation)
            {
                $_SESSION["user_id"] = $mysqli->insert_id;
                redir("index.php");
                exit;
            }
            else
            {
                $signup_error[] = "Something is wrong. Please try again.";
            }
        }
    }
?>
<html>
<head>
<title>User Login</title>
<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>

<body>
<div class="container">
<br>
<h4 class="text-center">User Authentication</h4>
<hr>

<?=showMessage()?>

<div class="row">
	<aside class="col-sm-6">
        <div class="card">
        <article class="card-body">
        <!-- <a href="" class="float-right btn btn-outline-primary">New User?</a> -->
        <h4 class="card-title mb-4 mt-1">Log In</h4>
        <hr>

        <?=isset($login_error)?showError($login_error):''?>

        <form method="post">
            <input type="hidden" name="do" value="login">
            <div class="form-group">
                <label>Your Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" value="<?=post('do')=='login'?post('username'):''?>" required>
            </div> <!-- form-group// -->
            <div class="form-group">
                <!-- <a class="float-right" href="#">Forgot?</a> -->
                <label>Your Password</label>
                <input name="password" class="form-control" placeholder="******" type="password" required>
            </div> <!-- form-group// --> 
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block"> Login  </button>
            </div> <!-- form-group// -->                                                           
        </form>
        </article>
        </div> <!-- card.// -->
	</aside> <!-- col.// -->
	<aside class="col-sm-6">
        <div class="card">
        <article class="card-body">
        <!-- <a href="" class="float-right btn btn-outline-primary">Returning User</a> -->
        <h4 class="card-title mb-4 mt-1">New User? Sign up</h4>
        <hr>

        <?=isset($signup_error)?showError($signup_error):''?>

        <form method="post">
            <input type="hidden" name="do" value="signup">
            <div class="form-group">
                <label>Your Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo post('email'); ?>" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label>Your Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label>Your Password</label>
                <input type="password" name="password" class="form-control" placeholder="******" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block"> Sign Up  </button>
            </div>                                                                    
        </form>
        </article>
        </div> <!-- card.// -->
	</aside> <!-- col.// -->
</div> <!-- row.// -->

</div> 
<!--container end.//-->

</body>
</html>