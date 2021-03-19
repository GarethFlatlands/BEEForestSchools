<?php
if(!isset($_SESSION))
{
session_start();
}

echo file_get_contents("../assets/html/adminheader.php");
  // Opens the connection to the database
  include '../createConnection.php';
  $conn = OpenCon();
  if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $conn->connect_error);
    exit();
  }

  // Strips whitespace and special characters from user submitted answers
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

  //Set up variables needed for directory, file target and filetype
  if(isset($_POST['newGalleryDate'])){
    $newGalleryDate = test_input_dashes($_POST['newGalleryDate']);
  }

  $file_type_ok = 1;
  $file_size_ok = 1;

  // Generates random 16 character password for folder access
  $newFolderPassword = substr(md5(mt_rand()), 0, 16);

  // Get the target directory name and make it
  $target_dir = "../assets/galleries/private/" . $newGalleryDate ."/";
  mkdir($target_dir);

  if(isset($_POST['submit'])){
     // Count total files
     $countfiles = count($_FILES["uploadedFile"]["tmp_name"]);

     // Looping all files
     for($i=0;$i<$countfiles;$i++){
       $target_file = $target_dir . basename($_FILES["uploadedFile"]["name"][$i]);
       $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

       //Returns relevant errors, or uploads the pictures to the gallery if no error occurs
       if ($file_type_ok = 0) {
         echo "The file type was invalid";
       } else if ($file_size_ok = 0) {
         echo "The file size was too large.";
       } else {
           if (move_uploaded_file($_FILES["uploadedFile"]["tmp_name"][$i], $target_file)) {
           echo "The file ". htmlspecialchars(basename( $_FILES["uploadedFile"]["name"][$i])). " has been uploaded.<br>";
         } else {
           echo "There was an error uploading your file.";
         }
       }

     }
    }

  // Uses a prepared statement to add the folder name and password to the relevant database;
  $stmt = $conn->prepare("INSERT INTO privategalleries (folder_name, folder_password) VALUES (?,?);");
  $stmt->bind_param("ss", $newGalleryDate, $newFolderPassword);
  $stmt->execute();
  $result = $stmt->get_result();
?>
    <html>
    <head>
    <title>Edit the 'About Us' page</title>
    </head>
    <body>
      <main role="main">
        <div class="admin-login">
          <h1>New Private Gallery Created</h1>
          <p>Link to new gallery: <a href="../assets/galleries/private/"><?php echo "../assets/galleries/private/"?></a></p>
          <h3>Login details</h3>
          <p>Gallery username: <?php echo $newGalleryDate ?></p>
          <p>Gallery password: <?php echo $newFolderPassword ?> </p>
          <br>
        </div>
    </div>
<?php echo file_get_contents("../assets/html/adminfooter.html"); ?>
