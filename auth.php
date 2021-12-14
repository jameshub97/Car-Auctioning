<?PHP
// When session starts, checks if username is being used.
// If no username is present then user is redirected to login page
session_start();
  if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit();
  }
?>
