<html>
<!-- this section allows admins to add more content to the database. MUST USE JPGS -->
<body>
  <head>
    <title>File Upload</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  </head>
  <form method="post" enctype="multipart/form-data">
  Select image to upload, must be jpg</br>
  <input type="file" name="fileToUpload" id="fileToUpload"></br>
  <input type="submit" value="Upload Image" name="submit">
  </form>
  <form method="post">
    <label for="carname">
    <input type="text" name="car_name" />
  </br>
    <input type="submit" value="Enter Name of car Here">
  </form>

<a href="picksoftheweek.php"></br>View Picks of the Week</a> </br>
</body>
</html>
<?PHP
error_reporting(0);
require_once "config.php";
// Initiation of variables, definiting the directory of where file will be placed
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Verfifies if correct files are being uploaded
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}
// Verifies if a file has be successfully/unsucessfuly uploaded.
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
  }
}
// Text field is used for user to define the name of the car.
// This is then added to the car database. The ID is increased by 1 so that the buttons within the picks of the week section navigate to corresponding ID values.
// For example, with 8 cars the following command finds the highest valued id and adds + 1 to state that it is the 9th car in the directory.
$car_name = $_POST["car_name"];
echo $car_name;
$sql = "SELECT id FROM votes ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $id_num =  $row["id"] + 1;
  }
  if(isset($_POST['car_name']))
    {
    $sql = "INSERT INTO votes (name, id) VALUES ('$car_name', $id_num)";
    $run_plus= mysqli_query($conn,$sql);
    }

}


?>
