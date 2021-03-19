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

    // PHP code to retrieve item ID for editing/deleting
    if(isset($_POST['item_id'])){
      $item_id = intval(test_input($_POST["item_id"]));
    }else{
      $item_id = "Test ID not set in POST Method";
    }

    if(isset($_POST['deleteCheckbox'])){
      $delete_checkbox = $_POST['deleteCheckbox'];
    } else {
      $delete_checkbox = 0;
    }

  // Connect to the relevant database
  include '../createConnection.php';
  $conn = OpenCon();
  if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $conn->connect_error);
    exit();
  }

  // Fetches all quotes currently in the database
  $stmt = $conn->prepare("SELECT id, cust_quote, cust_initials FROM customerquotes WHERE id=?");
  $stmt->bind_param("i", $item_id);
  $stmt->execute();
  $out_id = NULL;
  $out_cust_quote = NULL;
  $out_cust_initials = NULL;
  $stmt->bind_result($out_id, $out_cust_quote, $out_cust_initials);

  if ($_SESSION["login_check"] && $delete_checkbox == 0){
  ?><html>
  <head>
  <title>Edit News Items</title>
  </head>
  <body>
    <main role="main">
      <div class="admin-login">
        <h2>Edit Customer Quote #<?php echo $item_id;?></h2>
        <hr>
          <?php
          while($stmt->fetch()){
            echo "<form class=\"admin-login\" action=\"" . htmlspecialchars("quoteedited.php") . "\" method=\"post\">";
            echo "<h3>Quote text</h3><br>";
            echo "<p>You do not need to add quote marks around new quotes when inputting them. This is done automatically.</p>";
            echo "<div class=\"form-group\">";
            echo "<textarea class=\"form-control\" name=\"new_quote\" id=\"exampleFormControlTextarea1\" rows=\"3\">" . $out_cust_quote . "</textarea><br>";
            echo "</div>";
            echo "<h3>Name or initials of person quoted</h3><br>";
            echo "<textarea class=\"form-control\" name=\"new_cust_initials\" id=\"exampleFormControlTextarea1\" rows=\"3\">" . $out_cust_initials . "</textarea><br>";
            echo "<input type=\"hidden\" name=\"item_id\" value=\"" . htmlspecialchars($out_id) ."\">";
            echo "<input type=\"submit\" class=\"btn btn-primary btn-lg\" name=\"\" value=\"Submit edited quote\"><hr>";
            echo "</form>";
            echo "<input type=\"button\" class=\"btn btn-primary btn-lg\" value=\"Back to the quotes page\" onclick=\"history.back()\"><br>";
            }
          ?>
        </div>
      </main>
  </body>
  </html>
  <?php

} else if ($_SESSION["login_check"] && $delete_checkbox != 0){
  ?><html>
  <head>
  <title>Edit News Items</title>
  </head>
  <body>
    <main role="main">
      <div class="admin-login">
        <h2>Delete Quote #<?php echo $item_id;?></h2>
        <?php
        while($stmt->fetch()){
          echo "<form class=\"admin-login\" action=\"" . htmlspecialchars("quotedeleted.php") . "\" method=\"post\">";
          echo "<h3>Quote Text</h3><br>";
          echo "<div class=\"form-group\">";
          echo "<textarea class=\"form-control\" name=\"new_quote\" id=\"exampleFormControlTextarea1\" rows=\"3\" disabled>" . $out_cust_quote . "</textarea><br>";
          echo "</div>";
          echo "<h3>Name or initials of person quoted</h3><br>";
          echo "<textarea class=\"form-control\" name=\"new_cust_initials\" id=\"exampleFormControlTextarea1\" rows=\"3\" disabled>" . $out_cust_initials . "</textarea><br>";
          echo "<input type=\"hidden\" name=\"item_id\" value=\"" . htmlspecialchars($out_id) ."\">";
          echo "<input type=\"submit\" class=\"btn btn-danger btn-lg\" name=\"\" value=\"Delete this quote\"><hr>";
          echo "</form>";
          echo "<input type=\"button\" class=\"btn btn-primary btn-lg\" value=\"Back to the quotes page\" onclick=\"history.back()\"><br>";
          }
        ?>
      </div>
    </main>
</body>
</html>
<?php
}
  else {

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
