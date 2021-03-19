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

  //Scan the private gallery directory and retrieve all sub directories
  $privategallerydir    = '../assets/galleries/private/';
  $retrieveddirs = array_diff(scandir($privategallerydir), array('..', '.'));

  #Checks username and password. Displays admin menu if correct, or notify them of a problem
     if ($_SESSION["login_check"]){
     ?><html>
     <head>
     <title>Admin Menu</title>
     </head>
     <body>
       <div class="admin-login">
         <h1>Add/Delete Images in The Private Galleries</h1>
         <p>Select the date of the course to view the images from that session.</p>
         <p>Dates are given in the day/month/year format</p>
         <form class="admin-login" action="<?php echo htmlspecialchars("editprivategallery.php");?>" method="post">
           <div class="form-group">
            <label for="sel1">Select course date:</label>
            <select class="form-control" name="selected_date" id="selected_date">
              <?php
              foreach ($retrieveddirs as &$dirname) {
                echo "<option value=\"" . $dirname . "\"" . ">" . substr($dirname, 6, 2) . "/" . substr($dirname, 4, 2) . "/" . substr($dirname, 0, 4)  . "</option>";
              }
              ?>
            </select>
          </div>
           <input type="submit" name="submit" value="Submit">
         </form>
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
