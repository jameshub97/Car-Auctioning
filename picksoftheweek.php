<?PHP
// Initialize the session with error reporting disabled to ignore useless notices.
error_reporting(0);
session_start();
require_once "config.php";
// If a user is not logged in then is redirected to login page.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// Directory is referenced and used with glob to create an index of the amount of - images within arrays contains the different directory link.
$dir = 'images/';
$images = glob($dir . '*.jpg');
foreach ($images as $image){
    $listImages[] = $image;
}
// positive and negative buttons are used for navigating around images.
if(isset($_POST['positive']))
  {
  $plus = "update buttons set button=button+1";
  $run_plus= mysqli_query($conn,$plus);
  }

if(isset($_POST['negative']))
  {
  $minus = "update buttons set button=button-1";
  $run_minus = mysqli_query($conn,$minus);
}
// The id associated to the positive and negative buttons are used as a foreign key when referencing the voting page. So when the first image is viewed - when using the vote button this updates the votes section sharing the same as id with button value (sharing image index)

// button intilisation.
$sql_button = "SELECT button FROM buttons WHERE button";
$button_conn= $conn->query($sql_button);
$button_row= mysqli_fetch_row($button_conn);
$button_value = $button_row[0];
$result= json_encode($button_value);
$directory = $listImages[$button_value];
$sql2 = "SELECT * FROM votes WHERE id='$button_value'";
$result2 = $conn->query($sql2);
// Fetches the name of the car which is being selected.(which shares the button value, used to match index of car's being browsed)
$sql_button2 = "SELECT amount from votes WHERE id = $button_value";
$result3 = $conn->query($sql_button2);
if ($result3 ->num_rows > 0) {
  while($row = $result3 ->fetch_assoc()) {
    $vote_amount = "</br>". $row["amount"].  " votes ";
    // gets id's and relate to images/.
  }
}
// Uses button value to reference index of car to udpate votes (based on index)
if(isset($_POST['vote']))
  {
  $run_vote = "update votes set amount=amount+1 where id = $button_value;";
  $run_vote= mysqli_query($conn,$run_vote);
}
// Upadtes managerial special colum in car content database
if(isset($_POST['picks_oftw']))
  {
  $run_vote2 = "update votes set special=special+1 where id = $button_value;";
  $run_vote2 = mysqli_query($conn,$run_vote2);
}
// When there is more than one value for a car, the car is marked as a managerial special.
if ($result2->num_rows > 0) {
  while($row2 = $result2->fetch_assoc()) {
    $car_name = $row2["name"];
    $car_special = $row2["special"];
  }
  // CSS code is saved which then is used to give a managerial special a golden border.
  if($car_special > 1){
      $css = "#DAA520";
      $m_special = (" *managers special* </br>");
}

// Hides pick of the week button depending on if username is admin

if($_SESSION['username'] == "admin"){
  $class = 'show';
}else{
  $class = 'hidden';
}

// An SQL based comment system was faulty so an alternative has been implemented which uses a text file for reference.
if($_POST['Submit']){
  // obtains the username of the session user
 $Name = $_SESSION["username"];
 // retrieves the commenting entry and writes into the text file file
 $Comment = $_POST['Comment'];
 $old = fopen("comments.txt", "r+t");
 $old_comments = fread($old, 1024);
 $write = fopen("comments.txt", "w+");
 $string = "<b>".$Name."</b><br>".$Comment."<br>\n".$old_comments;
 fwrite($write, $string);
 fclose($write);
 fclose($old);
 // resutlts are then procesesd for use as a variable, referenced within the html forum.
$read = fopen("comments.txt", "r+t");
$list_comments = "<br><br>Comments<hr>".fread($read, 1024);
fclose($read);
}
}

$showDivFlag=false;
if ($_SESSION["username"] == "admin"){
    $showDivFlag=true;
 }else {

 }
?>
<html>
<head>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
     <style>
          div.ex1 {
            border-radius: 15px;
            border-width: thick;
            border-style: solid;
            border-color: <?PHP echo $css;?>;
            }
</style>
   </head>
   <title>Picks of the Week</title>
     <body>
   </div><div class="wrapper"><div class="d-flex flex-column">
     <div class="d-flex justify-content-center">
       <form action="" method="POST" id="commentForm">
     </br>
      <h2>Welcome to Picks of the Week!</br>
       <small class="text-muted">View and Vote Below</small></small></h2>
       <hr></hr>
      <div class="ex1"><img src= "<?php echo $directory; ?>" width="1000" height="600">
      </div>
      <hr></hr>
      <h2><?PHP echo $car_name; echo  $m_special; echo $vote_amount;?></br></h2>
         <hr></hr>
    </hr></hr>
      <input type="submit"  class="btn btn-primary" name="negative" value="<"><a></a>
      <input type="submit" class="btn btn-primary" name="positive" value=">"/> <input type="submit" class="btn btn-primary" name="vote" value="vote"/><a></br>
     </br>
     <div id="results" <?php if ($showDivFlag===false){?>style="display:none"<?php } ?>>
      <input type="submit" class="btn btn-primary" name="picks_oftw" value="Mark as Managers Special"/><a>
    </br>  </div>
    </a><a href="results.php">View Picks of the Week</a></br>
       <hr></hr></br>
       <textarea name="Comment" class="Input" style="width: 1000px"></textarea>

     </br><input type="submit" class="btn btn-outline-secondary" name="Submit" value="Submit Comment"><?PHP echo $list_comments; ?></form>
    </label><br><br>
  <br></br><a href="welcome.php">Back to Home</a>
  </body>
 </html>
