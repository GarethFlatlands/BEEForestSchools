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

  // http://localhost/forestschools/admin/test.php
  // PHP code to retrieve item ID for editing/deleting
  if(isset($_POST['editedTextHidden'])){
    $editedTextHidden = $_POST["editedTextHidden"];
  }else{
    $editedTextHidden = "Abous us text not set in POST Method";
  }

  // Connect to the relevant database
  include '../createConnection.php';
  $conn = OpenCon();
  if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $conn->connect_error);
    exit();
  }

  // Uses a prepared statement to add the edited text to the database;
  $stmt = $conn->prepare("UPDATE aboutus SET about_us_text=? WHERE id=1;");
  $stmt->bind_param("s", $editedTextHidden);
  $stmt->execute();
  $result = $stmt->get_result();

  #Checks username and password. Displays edit menu if correct, or notify them of a problem
     if ($_SESSION["login_check"]){
     ?><html>
     <head>
     <title>Edit the 'About Us' page</title>
     </head>
     <body>
       <main role="main">
         <div class="admin-login">
           <h1>Document saved</h1>
           <br>
           <div>
             <p>Your text was updated successfully.</p>
             <form>
               <input type="button" class="btn btn-primary btn-lg" value="Back to the admin menu page." onclick="history.go(-2)">
             </form>
           </div>
         </div>
         </div>
         <?php

         } else {

         ?><html>
         <head>
         <title>Oops! Something went wrong</title>
         </head>
         <body>
         <h1>Oops! Something went wrong</h1>
         <p>You need to be logged in to access this page.</p>
         </body>
         </html>
         <?php
         }
        ?>
    </div>
  <?php echo file_get_contents("../assets/html/adminfooter.html"); ?>
