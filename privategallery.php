<?php echo file_get_contents("assets/html/header.html"); ?>
<!-- http://localhost/forestschools/privategallery.php -->
<?php
// Strips whitespace and special characters from user submitted answers
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $_SESSION["login_check"] = 0;

  if(isset($_POST['folder_name'])){
    $folder_name = test_input($_POST["folder_name"]);
  }else{
    $folder_name = "Name not set in POST Method";
  }
  if(isset($_POST['folder_password'])){
    $folder_password = test_input($_POST["folder_password"]);
  }else{
    $folder_password = "Password not set in POST Method";
  }

// Connect to the relevant database
include 'createConnection.php';
$conn = OpenCon();
if ($conn->connect_errno) {
  printf("Connect failed: %s\n", $conn->connect_error);
  exit();
}
// Uses a prepared statement to check the provided login details
  $stmt = $conn->prepare("SELECT COUNT(id) FROM privategalleries WHERE folder_name=? AND folder_password=?");
  $stmt->bind_param("ss", $folder_name, $folder_password);
  $stmt->execute();
  $result = $stmt->get_result();
  $_SESSION["login_check"] = intval($result->fetch_row()[0]);
?>

<main role="main">
    <div class="jumbotron gallery-jumbotron">
      <div class="container">
        <h1 class="display-4">Private Gallery</h1>
        <p class="lead"></p>
      </div>
    </div>
    <div class="container">

    <!-- Only display the login form if not logged in -->
    <?php if(!$_SESSION["login_check"]){
    echo "<form class=\"admin-login\" action=\"?>" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";
    echo "<h3>Private Gallery Login</h3>";
    echo "<input type=\"text\" name=\"folder_name\" value=\"Username\"><br>";
    echo "<input type=\"password\" name=\"folder_password\" value=\"Password\"><br>";
    echo "<input type=\"submit\" class=\"btn btn-primary btn-lg\" name=\"submit\" value=\"Submit\">";
    echo "</form><br>";
    }
    ?>
    <!-- Code to retrieve all images from the galleries/public folder and display them -->
    <?php
    if ($_SESSION["login_check"]){
    // Sets up all variables
    $dir_name = "assets/galleries/private/" . $folder_name . "/";
    $images = glob($dir_name."*.jpg");
    $row_counter = 1;
    $image_counter = 1;

    // Loop to display all images
    foreach($images as $image) {
      // Resets the row counter to 1 if more than 3, as full size screen is 3 images per row
      if($row_counter>3){
        $row_counter = 1;
      }
      // Starts row div if counter is 1
      if($row_counter === 1){
        echo '<div class="row">';
      }
      // Code to display each image with a counter to increment for the purposes of CSS
      echo "<div class=\"column col-lg-4 col-sm-6\">";
  		echo "<div class=\"img-thumbnail\">";
      echo "<a target=\"_blank\" href=\"" . $image . "\">";
      echo "<img src=\"" . $image . "\" class=\"image\">";
      echo "</a>";
  		echo "</div>";
  		echo "</div>";
      // Ends row div if counter is 3 so new row can begin next loop
     if($row_counter === 3){
       echo '</div>';
     }
     // Increments the counters
     $row_counter++;
     $image_counter++;
    }
    } else {

    ?><html>
    <head>
    <title>Oops! Something went wrong</title>
    </head>
    <body>
    <h1>No images to display</h1>
    <p>Please enter your password.</p>
    </body>
    </html>
    <?php
    }
     ?>
</div>

<?php echo file_get_contents("assets/html/footer.html"); ?>
