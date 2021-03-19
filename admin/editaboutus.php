<?php
if(!isset($_SESSION))
{
session_start();
}

echo file_get_contents("../assets/html/trumbowygheader.php");
  // Strips whitespace and special characters from user submitted answers
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

  // http://localhost/forestschools/admin/test.php

  // Connect to the relevant database
  include '../createConnection.php';
  $conn = OpenCon();
  if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $conn->connect_error);
    exit();
  }

  $fetched_text = "";

  // Fetches the about us text from the database
  $stmt = $conn->prepare("SELECT about_us_text FROM aboutus");
  $stmt->execute();
  $out_about_us_text = NULL;
  $stmt->bind_result($out_about_us_text);
  while($stmt->fetch()){
    $fetched_text .= $out_about_us_text;
  }

  #Checks username and password. Displays edit menu if correct, or notify them of a problem
     if ($_SESSION["login_check"]){
     ?><html>
     <head>
     <title>Edit the 'About Us' page</title>
     </head>
     <body>
       <main role="main">
         <div class="admin-login">
           <h1>Edit the "About Us" Page Text</h1>
           <br>
           <form class=".admin-edit-area" action="aboutusedited.php" method="post">
             <div id="my-editor">
               <?php echo $fetched_text ?>
             </div>
             <input type="hidden" id="editedTextHidden" name="editedTextHidden" value="">
             <input type="submit" id="getEditedText" class="btn btn-success" value="Submit edited text">
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
         <p>You need to be logged in to access this page.</p>
         </body>
         </html>
         <?php
         }
        ?>
    </div>
<?php echo file_get_contents("../assets/html/trumbowygfooter.html"); ?>
