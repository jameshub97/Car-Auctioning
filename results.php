<html>
<head>
  <title>Results</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<h1>
   <div class="d-flex justify-content-center">
   Top 5 Picks are!</h1>
</div>
  <hr></hr>
</h1>
   <div class="d-flex justify-content-center">

<div class="wrapper"><div class="d-flex flex-column">
<div class="d-flex">
</hr>
</br>
</div>
<?PHP
// Initialize the session with error reporting disabled to ignore useless notices.
error_reporting(0);

require_once "config.php";
$sql = "SELECT * FROM votes ORDER BY amount desc LIMIT 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<h3>". $row["name"]. " : ". $row["amount"]. " votes ".  "</br>". "</h3>";
    // gets id's and relate to images/.
  }
}
?>
<hr></hr>
<a href="picksoftheweek.php">Return to Voting Section</a>
</div>
</div>
</div>


</body>
</html>
