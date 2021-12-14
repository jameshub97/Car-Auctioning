<?PHP
// *see references - a tutorial was used login/registration/logout*
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
require_once "config.php";
// Define variables which are intialised with no values.
$username = $password = "";
$username_err = $password_err = "";
// used to process request when submit is entered.
if($_SERVER["REQUEST_METHOD"] == "POST"){
  // Error handling for when users enter a username.
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    // Enters data into the data basse and uses password hashing for security
    // Uses error handling when fields are empty.
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            // logs user into services, noting account details for use in commenting.
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            header("location: welcome.php");
                            // additional error handling is used for when a user does not enter data in certain fields.
                        } else{
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Connections are closed.
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Set as post method for using above PHP in different file -->
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style type="text/css">

    </style>
</head>
<body>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  </div>
    <div class="wrapper">
            <div class="col center">
        <h2>Login</h2>
        <form method="POST">
        <p> For Unique Priveleges:</br>
        username: admin </br> password: adminadmin</p>

            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            </div>
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
                <a href="guest.php" class="btn btn-secondary">Login as Guest</a>
            </div>
            <p>Don't have an account? <a href="captcha-2.php">Sign up now</a>.</p>

        </form>
          </div>
    </div>
</body>
</html>
