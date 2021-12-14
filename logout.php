<?PHP
// Users are directed the login page when starting web-site services.
session_start();
$_SESSION = array();
session_destroy();
header("location: login.php");
exit;
?>
