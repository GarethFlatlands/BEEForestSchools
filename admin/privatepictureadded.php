<?php
if(!isset($_SESSION))
{
session_start();
}

echo file_get_contents("../assets/html/adminheader.php");

  //Retrieve private gallery dir name
  if(isset($_POST['gallery_date'])){
    $gallery_date = test_input_dashes($_POST["gallery_date"]);
  }else{
    $gallery_date = "Gallery date not set in POST Method";
  }

  //Set up variables needed for directory, file target and filetype
  $short_filename = basename($_FILES["uploadedFile"]["name"]);
  $target_dir = "../assets/galleries/private/" . $gallery_date . "/";
  $target_file = $target_dir . basename($_FILES["uploadedFile"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $file_type_ok = 1;
  $file_size_ok = 1;

  // Strips whitespace, special characters from user submitted answers
    function test_input_dashes($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $data = str_replace("-", "", $data);
      return $data;
    }

    //Checks the submitted file type is OK.
    function check_file_type($imageFileType) {
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
          echo "This file type is not valid. Only files ending .jpg, .jpeg, .png or .gif can be uploaded to galleries.";
          $file_type_ok = 0;
      }
    }

    //Checks the file size does not exceed a set maximum
    function check_file_size($file_size) {
      if ($file_size > 500000) {
        $file_size_ok = 0;
      }
    }

  //Returns relevant errors, or uploads the picture to the gallery if no error occurs
  if ($file_type_ok = 0) {
    echo "The file type was invalid";
  } else if ($file_size_ok = 0) {
    echo "The file size was too large.";
  } else {
      if (move_uploaded_file($_FILES["uploadedFile"]["tmp_name"], $target_file)) {
    } else {
      echo "There was an error uploading your file.";
    }
  }

?>
    <html>
    <head>
    <title>New Photo Added!</title>
    </head>
    <body>
      <main role="main">
        <div class="admin-login">
          <h1>New Picture(s) Added</h1>
          <p><?php
          echo $short_filename . " successfully uploaded to the private gallery. <br>";
          echo "<br><img src=\"" . $target_file . "\" style=\"width:300px;height:auto>\">";
          ?></p>
          <br>
          <input type="button" class="btn btn-primary btn-lg" value="Back a page." onclick="history.back()">
        </div>
    </div>
<?php echo file_get_contents("../assets/html/adminfooter.html"); ?>
