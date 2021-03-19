<?php echo file_get_contents("assets/html/header.html"); ?>
<main role="main">
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

      if(isset($_POST['news_item_id'])){
        $news_item_id = $_POST['news_item_id'];
      } else {
        $news_item_id = "Could not determine the news item required.";
      }

      // Fetches the about us text from the database
      $stmt = $conn->prepare("SELECT item_headline, item_body_text FROM newsitems WHERE id=?");
      $stmt->bind_param("i", $news_item_id);
      $stmt->execute();
      $out_item_headline = NULL;
      $out_item_body_text = NULL;
      $stmt->bind_result($out_item_headline, $out_item_body_text);
      while($stmt->fetch()){
        echo "<h1>" . $out_item_headline . "</h1>";
        echo $out_item_body_text;
      }
      ?>
    </div>
  </div>

<?php echo file_get_contents("assets/html/footer.html"); ?>
