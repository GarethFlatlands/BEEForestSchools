<?php
if(!isset($_SESSION))
{
session_start();
}

echo file_get_contents("../assets/html/adminheader.php");
  // http://localhost/forestschools/admin/newgallery.php

//Connect to private gallery db
//Create a new entry for the folder name and password
// Provide a link and password for sending
?>
    <html>
    <head>
    <title>Create A New Private Gallery</title>
    </head>
    <body>
      <main role="main">
        <div class="admin-login">
          <h1>Create A New Private Gallery</h1>
          <br>
          <form class="" action="gallerycreated.php" method="post" enctype='multipart/form-data'>
            <hr>
            <h3>1. Enter the date the new gallery relates to:</h3><br>
            <input type="date" name="newGalleryDate" value=""><br>
            <hr>
            <h3>2. Select photographs to upload</h3>
            <input type="file" name="uploadedFile[]" id="file" multiple><br>
            <hr>
            <input type="submit" name="submit" value="Create new gallery">
          </form>
          <input type="button" class="btn btn-primary btn-lg" value="Back a page" onclick="history.back()">
        </div>
    </div>
<?php echo file_get_contents("../assets/html/adminfooter.html"); ?>
