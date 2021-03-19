<?php
if(!isset($_SESSION))
{
session_start();
}
//Above code starts the session if not already done.
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

  // PHP code to retrieve inputted username and login
  if(isset($_POST['username'])){
    $username = test_input($_POST["username"]);
  }else{
    $username = "Name not set in POST Method";
  }
  if(isset($_POST['user_password'])){
    $user_password = test_input($_POST["user_password"]);
  }else{
    $user_password = "Password not set in POST Method";
  }

  // Uses a prepared statement to check the provided login details
  $stmt = $conn->prepare("SELECT COUNT(id) FROM useradmin WHERE username=? AND userPassword=sha1(?)");
  // $stmt = $conn->prepare("SELECT COUNT(id) FROM useradmin WHERE username=? AND userPassword=SHA2(?, 256)");
  $stmt->bind_param("ss", $username, $user_password);
  $stmt->execute();
  $result = $stmt->get_result();
  $_SESSION["login_check"] = intval($result->fetch_row()[0]);

  #Checks username and password. Displays admin menu if correct, or notify them of a problem
     if ($_SESSION["login_check"]){
     ?><html>
     <head>
     <title>Admin Menu</title>
     </head>
     <body>
       <div class="admin-login">
         <h1>Site Admin Menu</h1>
         <p>You are now logged in.</p>
         <div class="list-group">
           <a href="frontpagenews.php" class="list-group-item list-group-item-action">Edit front page news items</a>
           <a href="custquotes.php" class="list-group-item list-group-item-action">Edit, delete or add new customer quotes</a>
           <a href="policies.php" class="list-group-item list-group-item-action">Edit policies</a>
           <a href="editaboutus.php" class="list-group-item list-group-item-action">Edit the About Us page</a>
           <a href="editpublicgallery.php" class="list-group-item list-group-item-action">Edit the public gallery pictures</a>
           <a href="newgallery.php" class="list-group-item list-group-item-action">Create a new private photo gallery</a>
           <a href="selectprivategallery.php" class="list-group-item list-group-item-action">Edit the private gallery pictures</a>
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
<?php echo file_get_contents("../assets/html/adminfooter.html"); ?>
