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
  $stmt = $conn->prepare("SELECT id, policy_name, policy_link FROM policylinks WHERE id=?");
  $stmt->bind_param("i", $item_id);
  $stmt->execute();
  $out_id = NULL;
  $out_policy_name = NULL;
  $out_policy_link = NULL;
  $stmt->bind_result($out_id, $out_policy_name, $out_policy_link);

  if ($_SESSION["login_check"] && $delete_checkbox == 0){
  ?><?php echo file_get_contents("../assets/html/adminheader.php"); ?>
    <main role="main">
      <div class="admin-login">
        <h2>Edit Policy #<?php echo $item_id;?></h2>
        <hr>
          <?php
          while($stmt->fetch()){
            echo "<form class=\"admin-login\" action=\"" . htmlspecialchars("policyedited.php") . "\" method=\"post\">";
            echo "<h3>Policy Name</h3><br>";
            echo "<div class=\"form-group\">";
            echo "<input class=\"form-control\" name=\"new_policy_name\" type=\"text\" placeholder=\"" . $out_policy_name . "\"><br>";
            echo "</div>";
            echo "<h3>Policy Link</h3><br>";
            echo "<input class=\"form-control\" name=\"new_policy_link\" type=\"text\" placeholder=\"" . $out_policy_link . "\"><br>";
            echo "<input type=\"hidden\" name=\"item_id\" value=\"" . htmlspecialchars($out_id) ."\"><br>";
            echo "<input type=\"submit\" class=\"btn btn-primary btn-lg\" name=\"\" value=\"Submit edited policy\"><hr>";
            echo "</form>";
            echo "<input type=\"button\" class=\"btn btn-primary btn-lg\" value=\"Back to the policies page\" onclick=\"history.back()\"><br>";
            }
          ?>
        </div>
  <?php

} else if ($_SESSION["login_check"] && $delete_checkbox != 0){
  ?><?php echo file_get_contents("../assets/html/adminheader.php"); ?>
    <main role="main">
      <div class="admin-login">
        <h2>Delete Policy #<?php echo $item_id;?></h2>
        <?php
        while($stmt->fetch()){
          echo "<form class=\"admin-login\" action=\"" . htmlspecialchars("policydeleted.php") . "\" method=\"post\">";
          echo "<h3>Policy Name</h3><br>";
          echo "<div class=\"form-group\">";
          echo "<input class=\"form-control\" name=\"new_policy_name\" type=\"text\" placeholder=\"" . $out_policy_name . "\" disabled><br>";
          echo "</div>";
          echo "<h3>Policy Link</h3><br>";
          echo "<input class=\"form-control\" name=\"new_policy_link\" type=\"text\" placeholder=\"" . $out_policy_link . "\" disabled><br>";
          echo "<input type=\"hidden\" name=\"item_id\" value=\"" . htmlspecialchars($out_id) ."\">";
          echo "<input type=\"submit\" class=\"btn btn-danger btn-lg\" name=\"\" value=\"Delete this policy\"><hr>";
          echo "</form>";
          echo "<input type=\"button\" class=\"btn btn-primary btn-lg\" value=\"Back to the policies page\" onclick=\"history.back()\"><br>";
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
