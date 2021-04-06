<?php
if(!isset($_SESSION))
{
session_start();
}
include 'getWeather.php';
echo file_get_contents("assets/html/header.html");
?>
<main role="main">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3">Welcome!</h1>
      <p>Blackbrook Environmental Enterprise (BEE) Forest School, Rivelin. Forest School is a child-centred inspirational learning process, that offers opportunities for holistic growth. </p>
      <p><a class="btn btn-primary btn-lg" href="#" role="button">Check dates &raquo;</a></p>
    </div>
  </div>
  <!-- Weather bar display using the openweatermap API -->
  <header class="py-3 mb-4  bg-dark border-bottom">
    <div class="container d-flex flex-wrap justify-conten-center" id="weatherBar">
      <h4>The weather here is: <?php echo $_SESSION["main_weather"]?>, with a temperature of <?php echo $_SESSION["current_temp"] . "°C/" . round((($_SESSION["current_temp"]*9/5)+32),2) . "°F" ?></h1>
    </div>
  </header>


<!-- http://localhost/forestschools/index.php -->
<!-- s770353848.websitehome.co.uk -->

  <div class="container">
    <?php
    // Connect to the relevant database
    include 'createConnection.php';
    $conn = OpenCon();
    if ($conn->connect_errno) {
      printf("Connect failed: %s\n", $conn->connect_error);
      exit();
    }
    // Fetches the front page news items
    $stmt = $conn->prepare("SELECT item_headline, sub_headline FROM newsitems");
    $stmt->execute();
    $out_item_headline = NULL;
    $out_sub_headline = NULL;
    $stmt->bind_result($out_item_headline, $out_sub_headline);
    //Counter to concatenate with the string 'newsitem' to make the correct link
    $link_address_counter = 1;
      //Opens the row tag
      echo "<div class=\"row\">";
      //Loops through 3 entries in the news items database and displays it as a column
      while($stmt->fetch()){
        echo "<div class=\"col-md-4 front-page-article\">";
        echo "<form action=\"readnewsitem.php\" method=\"post\">";
        echo "<h2 class=\"headline\">" . $out_item_headline . "</h2>";
        echo "<p class=\"article-text\">" . $out_sub_headline . "</p>";
        echo "<input type=\"hidden\" name=\"news_item_id\" value=\"" . $link_address_counter . "\">";
        echo "<input type=\"submit\" class=\"btn btn-secondary\" value=\"View details &raquo;\">";
        echo "</div>";
        echo "</form>";
        $link_address_counter++;
      }
      //Closes the row tag
      echo "</div>";
    ?>
    <hr>
    <h2>Customer testimonials</h2>
    <div class="quoteCarousel">
      <div class="container">
      <!-- Pulls parent quotes from the database and displays them as slides in a carousel -->
      <?php
      // Prepares and executes prepared statement
      $stmt = $conn->prepare("SELECT cust_quote, cust_initials FROM customerquotes");
      $stmt->execute();
      $out_cust_quote = NULL;
      $out_cust_initials = NULL;
      $stmt->bind_result($out_cust_quote, $out_cust_initials);
      // Pulls all quotes and assigns each to a carousel slide
      while($stmt->fetch()){
          echo "<div class=\"mySlides\">";
          echo "<h3><b>\"" . $out_cust_quote . "\"</b></h3>";
          echo "<p>" . $out_cust_initials . "</p>";
          echo "</div>";
        }
      ?>
      </div>
    </div>
    <hr>

<!-- JS Script for the quote carousel to cycle slides -->
    <script>
      var slideIndex = 0;
      carousel();

      function carousel() {
        var i;
        var x = document.getElementsByClassName("mySlides");
        for (i = 0; i < x.length; i++) {
          x[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > x.length) {slideIndex = 1}
        x[slideIndex-1].style.display = "block";
        setTimeout(carousel, 6000);
      }
      </script>
<?php echo file_get_contents("assets/html/footer.html"); ?>
