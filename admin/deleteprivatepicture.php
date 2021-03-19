<?php
if(!isset($_SESSION))
{
session_start();
}
echo file_get_contents("../assets/html/adminheader.php");
// Strips whitespace and special characters from user submitted answers
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

// Connect to the relevant database
include '../createConnection.php';
$conn = OpenCon();
if ($conn->connect_errno) {
  printf("Connect failed: %s\n", $conn->connect_error);
  exit();
}

//Gets item ID from the previous page
if(isset($_POST['image_filename'])){
  $image_filename = test_input($_POST["image_filename"]);
}else{
  $image_filename = "No image filename passed in POST Method";
}

if(file_exists($image_filename)){
  $image_deleted = unlink($image_filename);
} else {
  echo "The selected file does not exist.";
}

#Checks username and password. Displays admin menu if correct, or notify them of a problem
if ($_SESSION["login_check"]){
?><html>
<head><title>Picture deleted</title>
</head>
<body>
  <main role="main">
    <h1>Great news!</h1>
    <p>
    <?php
    if($image_deleted) {
      echo "The image " . $image_filename . " has been successfully deleted.";
    } else {
      echo "There was an error and the selected image has not been deleted.";
    }
    ?>
    </p>
    <form>
      <input type="button" class="btn btn-primary btn-lg" value="Back to the edit page." onclick="history.back()">
    </form>
   </div>
</body>
</html>
<?php

} else {

?><html>
<head>
<title>Oops! Something went wrong</title>
</head>
<body>
<h1>Oops! Something went wrong</h1>
<p>The username and/or password were incorrect.</p>
</body>
</html>
<?php
}
   ?>
<?php
  echo file_get_contents("../assets/html/adminfooter.html");
?>
