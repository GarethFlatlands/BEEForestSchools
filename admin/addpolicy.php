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

// PHP code to retrieve inputted quote and details
if(isset($_POST['new_policy_name'])){
  $new_policy_name = test_input($_POST["new_policy_name"]);
}else{
  $new_policy_name = "Quote not set in POST Method";
}
if(isset($_POST['new_policy_link'])){
  $new_policy_link = test_input($_POST["new_policy_link"]);
}else{
  $new_policy_link = "Parent details not set in POST Method";
}

// Uses a prepared statement to add the new customer quote to the database;
$stmt = $conn->prepare("INSERT INTO policylinks (policy_name, policy_link) VALUES (?,?);");
$stmt->bind_param("ss", $new_policy_name, $new_policy_link);
$stmt->execute();
$result = $stmt->get_result();

#Checks username and password. Displays admin menu if correct, or notify them of a problem
if ($_SESSION["login_check"]){
?><?php echo file_get_contents("../assets/html/adminheader.php"); ?>
  <main role="main">
    <div class="admin-login">
      <h1>Success!</h1>
      <p>Your policy was added to the database.</p>
      <form>
        <input type="button" class="btn btn-primary btn-lg" value="Back to the policies page." onclick="history.back()">
      </form>
   </div>
<?php

} else {

?><?php echo file_get_contents("../assets/html/adminheader.php"); ?>
<h1>Oops! Something went wrong</h1>
<p>The username and/or password were incorrect.</p>
<?php
}
   ?>
</div>
<?php
  $stmt->close();
  echo file_get_contents("../assets/html/adminfooter.html");
?>
