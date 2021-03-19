<?php
if(!isset($_SESSION))
{
session_start();
}

echo file_get_contents("../assets/html/trumbowygheader.php");
  // Strips whitespace and special characters from user submitted answers
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    // PHP code to retrieve inputted username and login
    if(isset($_POST['item_id'])){
      $item_id = intval(test_input($_POST["item_id"]));
    }else{
      $item_id = "Test ID not set in POST Method";
    }

  // Connect to the relevant database
  include '../createConnection.php';
  $conn = OpenCon();
  if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $conn->connect_error);
    exit();
  }

  // Fetches all quotes currently in the database
  $stmt = $conn->prepare("SELECT id, item_headline, item_body_text, sub_headline FROM newsitems WHERE id=?");
  $stmt->bind_param("i", $item_id);
  $stmt->execute();
  $out_id = NULL;
  $out_item_headline = NULL;
  $out_item_body_text = NULL;
  $out_sub_headline = NULL;
  $stmt->bind_result($out_id, $out_item_headline, $out_item_body_text, $out_sub_headline);

  if ($_SESSION["login_check"]){
  ?><html>
  <head>
  <title>Edit News Items</title>
  </head>
  <body>
    <main role="main">
      <div class="admin-login">
        <h2>Edit News Item #<?php echo $item_id;?></h2>
        <hr>
          <?php
          while($stmt->fetch()){
            echo "<form class=\"admin-login\" action=\"" . htmlspecialchars("newsitemedited.php") . "\" method=\"post\">";
            echo "<h3>Headline</h3><br>";
            echo "<p>The Headline and Sub Headline are what the user will see on the front page. The complete Body Text will be displayed on a new page once they click to read the full article.</p><br>";
            echo "<div class=\"form-group\">";
            echo "<textarea class=\"form-control\" name=\"new_headline\" id=\"exampleFormControlTextarea1\" rows=\"3\">" . $out_item_headline . "</textarea><br>";
            echo "</div>";
            echo "<h3>Sub Headline</h3><br>";
            echo "<div class=\"form-group\">";
            echo "<textarea class=\"form-control\" name=\"new_sub_headline\" id=\"exampleFormControlTextarea1\" rows=\"3\">" . $out_sub_headline . "</textarea><br>";
            echo "</div>";
            echo "<h3>Body Text</h3><br>";
            echo "<div id=\"my-editor\">";
            echo $out_item_body_text;
            echo "</div>";
            echo "<input type=\"hidden\" name=\"item_id\" value=\"" . htmlspecialchars($out_id) ."\">";
            echo "<input type=\"hidden\" id=\"editedTextHidden\" name=\"editedTextHidden\" value=\"\">";
            echo "<input type=\"submit\" class=\"btn btn-primary btn-lg\" id=\"getEditedText\" name=\"\" value=\"Submit\"><hr>";
            echo "<input type=\"button\" class=\"btn btn-primary btn-lg\" value=\"Back to the news items page\" onclick=\"history.back()\">";
            echo "</form>";
            }
          ?>
        </div>
      </main>
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
<?php echo file_get_contents("../assets/html/trumbowygfooter.html"); ?>
