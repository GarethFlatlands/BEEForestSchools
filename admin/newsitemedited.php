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

// PHP code to retrieve inputted text and row id
if(isset($_POST['new_headline'])){
  $new_headline = test_input($_POST["new_headline"]);
}else{
  $new_headline = "Headline not set in POST Method";
}
if(isset($_POST['new_sub_headline'])){
  $new_sub_headline = test_input($_POST["new_sub_headline"]);
}else{
  $new_sub_headline = "Sub headline not set in POST Method";
}
if(isset($_POST['editedTextHidden'])){
  $new_body_text = ($_POST['editedTextHidden']);
}else{
  $new_body_text = "News item text details not set in POST Method";
}
if(isset($_POST['item_id'])){
  $item_id = intval(test_input($_POST["item_id"]));
}else{
  $item_id = "ID not set in POST Method";
}

// Uses a prepared statement to add the new customer quote to the database;
$stmt = $conn->prepare("UPDATE newsitems SET item_headline=?, sub_headline=?, item_body_text=? WHERE id=?;");
$stmt->bind_param("sssi", $new_headline, $new_sub_headline, $new_body_text, $item_id);
$stmt->execute();
$result = $stmt->get_result();

#Checks username and password. Displays admin menu if correct, or notify them of a problem
if ($_SESSION["login_check"]){
?><html>
<head>
<title>Admin Menu</title>
</head>
<body>
  <main role="main">
    <h1>Great news!</h1>
    <p>Your news item was updated successfully.</p>
    <form>
      <input type="button" class="btn btn-primary btn-lg" value="Back to the edit page." onclick="history.go(-2)">
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
</div>
<?php
  $stmt->close();
  echo file_get_contents("../assets/html/adminfooter.html");
?>
