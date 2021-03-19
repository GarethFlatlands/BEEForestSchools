<?php echo file_get_contents("assets/html/header.html"); ?>
<main role="main">
  <div class="jumbotron policies-jumbotron">
    <div class="container">
      <h1 class="display-4">Our Policies</h1>
      <p class="lead">You can read all our policies by clicking on the relevant links below. All the documents linked on this page are accessed via Google documents, and will navigate away from this site once clicked.</p>
    </div>
  </div>
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
    $stmt = $conn->prepare("SELECT policy_name, policy_link FROM policylinks");
    $stmt->execute();
    $out_policy_name = NULL;
    $out_policy_link = NULL;
    $stmt->bind_result($out_policy_name, $out_policy_link);
    echo "<div class=\"list-group\">";
    while($stmt->fetch()){
      echo "<a href=\"" . $out_policy_link . "\" class=\"list-group-item list-group-item-action\">" . $out_policy_name . "</a>";
    }
    echo "</div>";
    ?>
    <hr>
</div>
<?php echo file_get_contents("assets/html/footer.html"); ?>
