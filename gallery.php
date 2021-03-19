<?php echo file_get_contents("assets/html/header.html"); ?>

<main role="main">
    <div class="jumbotron gallery-jumbotron">
      <div class="container">
        <h1 class="display-4">Image Gallery</h1>
        <p class="lead">The below images are a selection of shots from previously run Forest Schools courses.</p>
      </div>
    </div>
  <div class="container">
    <!-- Code to retrieve all images from the galleries/public folder and display them -->
    <?php
    // Sets up all variables
    $dir_name = "assets/galleries/public/";
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
     ?>
</div>

<?php echo file_get_contents("assets/html/footer.html"); ?>
