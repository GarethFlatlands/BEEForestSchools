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
           <h2>Edit Customer Quotes</h2>
           <hr>
           <p>Note - if you have just added a new quote and navigated back to this page, you may need to refresh the page before it appears in the table below.</p>
         <?php
         // Fetches all quotes currently in the database
         $stmt = $conn->prepare("SELECT id, cust_quote, cust_initials FROM customerquotes");
         $stmt->execute();
         $out_id = NULL;
         $out_cust_quote = NULL;
         $out_cust_initials = NULL;
         $stmt->bind_result($out_id, $out_cust_quote, $out_cust_initials);
         // Pulls all quotes and places them into a table
         echo "<table class=\"table table-striped table-bordered table-hover\">";
         echo "<thead>";
         echo "<tr>";
         echo "<th scope=\"col\">Item ID</th>";
         echo "<th scope=\"col\">Quote</th>";
         echo "<th scope=\"col\">Parent initials</th>";
         echo "<th scope=\"col\">Check to delete</th>";
         echo "<th scope=\"col\">Edit</th>";
         echo "</tr>";
         echo "</thead>";
         echo "<tbody>";
         while($stmt->fetch()){
           echo "<tr>";
           echo "<td>" . $out_id . "</td>";
           echo "<td>\"" . $out_cust_quote . "\"</td>";
           echo "<td>" . $out_cust_initials . "</td>";
           echo "<td> <form class=\"\" action=\"editcustquote.php\" method=\"post\"><div class=\"form-check\">";
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
         <h3>Add a new quote</h3>
         <p>You do not need to add quote marks around new quotes when inputting them. This is done automatically.</p>
         <form class=".admin-edit-area" action="<?php echo htmlspecialchars("addquote.php");?>" method="post">
           <div class="form-group">
             <label for="exampleFormControlTextarea1">New quote</label>
             <textarea class="form-control" name="new_quote" id="exampleFormControlTextarea1" rows="3"></textarea>
           </div>
           <div class="form-group">
             <label for="exampleFormControlInput1">Parent initials</label>
             <input type="text" name="new_parent_initials" class="form-control" id="exampleFormControlInput1" placeholder="eg C (parent of B)">
           </div>
           <div class="form-group">
             <input type="submit" class="btn btn-success" name="" value="Submit new quote">
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
