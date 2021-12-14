<?PHP
//  Data base configrations for use in other files.
$servername = "localhost:3306";
$dbusername = "x2h03";
$dbpassword = "x2h03x2h03";
$dbname = "x2h03";
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "error";
}
?>
