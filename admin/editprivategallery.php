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

  //Retrieve private gallery dir name
  if(isset($_POST['selected_date'])){
    $selected_date = test_input($_POST["selected_date"]);
  }else{
    $selected_date = "Selected date not set in POST Method";
  }

  // Fetches the folder details from the database
  $stmt = $conn->prepare("SELECT folder_name, folder_password FROM privategalleries WHERE folder_name=?");
  $stmt->bind_param("s", $selected_date);
  $stmt->execute();
  $out_about_us_text = NULL;
  $stmt->bind_result($out_folder_name, $out_folder_password);

  //HTML to display based on login check
  if ($_SESSION["login_check"]){
  ?><html>
  <head>
  <title>Edit News Items</title>
  </head>
  <body>
    <main role="main">
      <div class="admin-login">
        <h2>Edit Private Gallery Pictures</h2>
        <p>Gallery login details:</p>
        <?php while($stmt->fetch()){
          echo "<p>Username: <strong>" . $out_folder_name . "</strong></p>";
          echo "<p>Password: <strong>" . $out_folder_password . "</strong></p>";
        }
        ?>
        <!-- Form for adding new pictures -->
        <hr>
        <h3>Add a new picture</h3>
        <p>Pictures should be in .jpeg, .jpg or .png file formats. Any other file type will be rejected.</p>
        <p>Multiple files can be uploaded here, and will be added to the gallery in the order they were uploaded.</p>
        <form class="admin-login" action="privatepictureadded.php" method="post" enctype='multipart/form-data'>
          <hr>
          <h3>Select photographs to upload</h3>
          <input type="file" name="uploadedFile" id="file" multiple><br>
          <input type="hidden" name="gallery_date" value="<?php echo $selected_date ?>">
          <input type="submit" name="" value="Upload pictures">
        </form>
        <hr>
        <h2>Or...</h2>
        <h3>Delete existing pictures</h3>
        <?php
        // Sets up all variables
        $dir_name = "../assets/galleries/private/" . $selected_date . "/";
        $images = glob($dir_name."*.jpg");
        echo "<table class=\"table table-striped table-bordered table-hover\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th scope=\"col\">Image";
        echo "<th scope=\"col\">Delete</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        // Loop to display all images
        foreach($images as $image) {
          echo "<tr>";
          echo "<td>";
          echo "<div class=\"img-thumbnail\">";
          echo "<img src=\"" . $image . "\" style=\"width:300px;height:auto>\">";
      		echo "</div>";
          echo "</td>";
          echo "<td><form class=\"\" action=\"deleteprivatepicture.php\" method=\"post\"><input type=\"submit\" class=\"btn btn-info\" name=\"edit_item\" value=\"Delete\">";
          echo "<input type=\"hidden\" name=\"image_filename\" value=\"" . htmlspecialchars($image) ."\">";
          echo "</form></a></td>";
          echo "</tr>";
          }
        echo "</tbody>";
        echo "</table>";
        ?>
       <?php echo "<input type=\"button\" class=\"btn btn-primary btn-lg\" value=\"Back a page.\" onclick=\"history.back()\">"; ?>
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
