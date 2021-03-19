<?php echo file_get_contents("assets/html/header.html"); ?>
<main role="main">
  <div class="jumbotron aboutus-jumbotron">
    <div class="container">
      <h1 class="display-4">About Us</h1>
      <p class="lead">All about us, the courses we run and some practical information.</p>
    </div>
  </div>
  <div class="container">
    <div class="about_us">
      <?php
      // Connect to the relevant database
      include 'createConnection.php';
      $conn = OpenCon();
      if ($conn->connect_errno) {
        printf("Connect failed: %s\n", $conn->connect_error);
        exit();
      }
      // Fetches the about us text from the database
      $stmt = $conn->prepare("SELECT about_us_text FROM aboutus");
      $stmt->execute();
      $out_about_us_text = NULL;
      $stmt->bind_result($out_about_us_text);
      while($stmt->fetch()){
        echo $out_about_us_text;
      }
      ?>
    </div>
  </div>

<?php echo file_get_contents("assets/html/footer.html"); ?>
