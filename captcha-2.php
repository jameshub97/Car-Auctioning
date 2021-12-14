
<head>
  <title>Captcha Forum</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <title>Captcha</title>
   <script src="https://www.google.com/recaptcha/api.js" async defer></script>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
</head>
<body>
  <form method="POST">
    <div class="g-recaptcha" data-sitekey="6Lfv7f4UAAAAACKdYffr9ycIFIZK7g9fOK0vy1Hz"></div><br/>
    <input type="submit" value="Submit">
  </form>
</body>

<?php


if($_SERVER["REQUEST_METHOD"] === "POST")
{

    $recaptcha_secret = "6Lfv7f4UAAAAAHvQBFjB0NkbiybufrB3L1T85K2N";
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
    $response = json_decode($response, true);

    if($response["success"] === true){
        echo "Form Submit Successfully.";
        header("location: register.php");
    }else{
        echo "Please complete the captcha";
    }


}

?>
