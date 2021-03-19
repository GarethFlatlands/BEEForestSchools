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

  // Connect to the relevant database
  include '../createConnection.php';
  $conn = OpenCon();
  if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $conn->connect_error);
    exit();
  }

  // Fetches all quotes currently in the database
  $stmt = $conn->prepare("SELECT id, item_headline, sub_headline FROM newsitems");
  $stmt->execute();
  $out_id = NULL;
  $out_item_headline = NULL;
  $out_sub_headline = NULL;
  $stmt->bind_result($out_id, $out_item_headline, $out_sub_headline);

  if ($_SESSION["login_check"]){
  ?><html>
  <head>
  <title>Edit News Items</title>
  </head>
  <body>
    <main role="main">
      <div class="admin-login">
        <h2>Edit Front Page News Items</h2>
        <hr>
      <?php
      // Pulls all quotes and places them into a table
      echo "<table class=\"table table-striped table-bordered table-hover\">";
      echo "<thead>";
      echo "<tr>";
      echo "<th scope=\"col\">Headline</th>";
      echo "<th scope=\"col\">News Item Sub Headline</th>";
      echo "<th scope=\"col\">Edit</th>";
      echo "</tr>";
      echo "</thead>";
      echo "<tbody>";
      while($stmt->fetch()){
        echo "<tr>";
        echo "<td>\"" . $out_item_headline . "\"</td>";
        echo "<td>" . substr(htmlspecialchars($out_sub_headline),0,256) . "...</td>";
        echo "<td><form class=\"\" action=\"editnewsitem.php\" method=\"post\"><input type=\"submit\" class=\"btn btn-info\" name=\"edit_item\" value=\"Edit\">";
        echo "<input type=\"hidden\" name=\"item_id\" value=\"" . htmlspecialchars($out_id) ."\">";
        echo "</form></a></td>";
        echo "</tr>";
        }
      echo "</tbody>";
      echo "</table>";
      echo "<input type=\"button\" class=\"btn btn-primary btn-lg\" value=\"Back a page\" onclick=\"history.back()\">";
      ?>
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
<?php echo file_get_contents("../assets/html/adminfooter.html"); ?>
