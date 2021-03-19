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

    #Checks username and password. Displays admin menu if correct, or notify them of a problem
     if ($_SESSION["login_check"]){
     ?><html>
     <head>
     <title>Admin Menu</title>
     </head>
     <body>
       <main role="main">
         <div class="admin-login">
           <h2>Edit Policies</h2>
           <hr>
           <p>Note - if you have just added a new policy and navigated back to this page, you may need to refresh the page before it appears in the table below.</p>
         <?php
         // Fetches all quotes currently in the database
         $stmt = $conn->prepare("SELECT id, policy_name, policy_link FROM policylinks");
         $stmt->execute();
         $out_id = NULL;
         $out_policy_name = NULL;
         $out_policy_link = NULL;
         $stmt->bind_result($out_id, $out_policy_name, $out_policy_link);
         // Pulls all quotes and places them into a table
         echo "<table class=\"table table-striped table-bordered table-hover\">";
         echo "<thead>";
         echo "<tr>";
         echo "<th scope=\"col\">Policy Name</th>";
         echo "<th scope=\"col\">Google Docs Link</th>";
         echo "<th scope=\"col\">Check to delete</th>";
         echo "<th scope=\"col\">Edit</th>";
         echo "</tr>";
         echo "</thead>";
         echo "<tbody>";
         while($stmt->fetch()){
           echo "<tr>";
           echo "<td>\"" . $out_policy_name . "\"</td>";
           echo "<td><a href=\"" . $out_policy_link . "\">" . $out_policy_link . "</a></td>";
           echo "<td> <form class=\"\" action=\"editpolicy.php\" method=\"post\"><div class=\"form-check\">";
           echo "<input type=\"checkbox\" class=\"form-check-input\" id=\"deleteCheck\" name=\"deleteCheckbox\" value=\"" . $out_id . "\"><br>";
           echo "<label class=\"form-check-label\" for=\"deleteCheck\">Delete?</label>";
           echo "</div></td>";
           echo "<td><input type=\"submit\" class=\"btn btn-info\" name=\"edit_item\" value=\"Edit\Delete\">";
           echo "<input type=\"hidden\" name=\"item_id\" value=\"" . htmlspecialchars($out_id) ."\">";
           echo "</form></a></td>";
           echo "</tr>";
           echo "</tr>";
           }
         echo "</tbody>";
         echo "</table>";
         ?>
         <!-- Form for adding a new quote -->
         <hr>
         <h3>Add A New Policy</h3>
         <form class=".admin-edit-area" action="<?php echo htmlspecialchars("addpolicy.php");?>" method="post">
           <div class="form-group">
             <label for="exampleFormControlTextarea1">Policy Name</label>
             <input type="text" name="new_policy_name" class="form-control" id="exampleFormControlTextarea1"></textarea>
           </div>
           <div class="form-group">
             <label for="exampleFormControlInput1">Google Docs Link</label>
             <input type="text" name="new_policy_link" class="form-control" id="exampleFormControlInput1">
           </div>
           <div class="form-group">
             <input type="submit" class="btn btn-success" name="" value="Submit new policy">
           </div>
         </form>
         <hr>
        <?php echo "<input type=\"button\" class=\"btn btn-primary btn-lg\" value=\"Back a page.\" onclick=\"history.back()\">"; ?>
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
