<?PHP
// Validates if a user is logged and re-directs to login page
error_reporting(0);
session_start();
// if a user is not logged in then is redirected to login page.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Used to remove changing of password for guests
$showDivFlag=false;
if ($_SESSION["username"] == "guest"){
    $showDivFlag=false;
 }else {
   $showDivFlag=true;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</div>

  <div class="wrapper">
        <h1><b>Welcome</b> <?php echo ($_SESSION["username"]); ?>  ! </h1>
    </div>
    <p>
      <?PHP
      // Provides link for admin to upload new files
      if ($_SESSION["username"] == "admin"){
        echo "<a href='fileupload.php'>As admin you can upload Files</a>"; }?>
      <hr></hr>
        <a href="picksoftheweek.php">View Picks of the Week</a> </br>
        <div id="results" <?php if ($showDivFlag===false){?>style="display:none"<?php } ?>>
          <a href="reset-password.php">Reset-password</a>
        </div>

        <a href="logout.php">Logout</a></br>
    </p>
  </div>
</body>
