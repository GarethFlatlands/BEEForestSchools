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
if(isset($_POST['new_quote'])){
  $new_quote = test_input($_POST["new_quote"]);
}else{
  $new_quote = "Quote not set in POST Method";
}
if(isset($_POST['new_parent_initials'])){
  $new_parent_initials = test_input($_POST["new_parent_initials"]);
}else{
  $new_parent_initials = "Parent details not set in POST Method";
}

// Uses a prepared statement to add the new customer quote to the database;
$stmt = $conn->prepare("INSERT INTO customerquotes (cust_quote, cust_initials) VALUES (?,?);");
$stmt->bind_param("ss", $new_quote, $new_parent_initials);
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
    <h1>Success!</h1>
    <p>Your quote was added to the database.</p>
    <form>
      <input type="button" class="btn btn-primary btn-lg" value="Back to the quotes page." onclick="history.back()">
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
