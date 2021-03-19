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
if(isset($_POST['new_policy_name'])){
  $new_policy_name = test_input($_POST["new_policy_name"]);
}else{
  $new_policy_name = "Policy name not set in POST Method";
}
if(isset($_POST['new_policy_link'])){
  $new_policy_link = test_input($_POST["new_policy_link"]);
}else{
  $new_policy_link = "Policy link not set in POST Method";
}
if(isset($_POST['item_id'])){
  $item_id = intval(test_input($_POST["item_id"]));
}else{
  $item_id = "ID not set in POST Method";
}

// Uses a prepared statement to add the new customer quote to the database;
$stmt = $conn->prepare("UPDATE policylinks SET policy_name=?, policy_link=? WHERE id=?;");
$stmt->bind_param("ssi", $new_policy_name, $new_policy_link, $item_id);
$stmt->execute();
$result = $stmt->get_result();

#Checks username and password. Displays admin menu if correct, or notify them of a problem
if ($_SESSION["login_check"]){
?><?php echo file_get_contents("../assets/html/adminheader.php"); ?>
  <main role="main">
    <div class="admin-login">
    <h1>Great news!</h1>
    <p>Your news item was updated successfully.</p>
    <form>
      <input type="button" class="btn btn-primary btn-lg" value="Back to the edit page." onclick="history.go(-2)">
    </form>
   </div>
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
