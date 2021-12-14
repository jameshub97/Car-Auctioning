
<html>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
 <body>
   <title>Guest Login</title>
    <form method="POST">
    <input type="submit" name="verify" value=" Proceed to Captcha"/>
    <br/>
    <!-- If true on captcha allow button to work, else state can not work -->
  </form>
 </body>
</html>

<?php
require_once "config.php";
// After a user visits this page an account is created which increases the "is guest" value on the table. This
if (isset($_POST['verify']))
    {
    $sql = "INSERT INTO users (username, is_guest) VALUES ('guest',  1)";
    $run_g = mysqli_query($conn,$sql);
    session_start();
    $_SESSION["loggedin"] = true;
    $_SESSION["id"] = $id;
    $_SESSION["username"] = "guest";
    header("location: captcha.php");
}
?>

<script>
</script>
