<?php echo file_get_contents("../assets/html/adminheader.php"); ?>
  <body>
      <!-- http://localhost/forestschools/admin/login.php -->
      <!-- http://s770353848.websitehome.co.uk/admin/login.php -->
    <main role="main">
      <form class="admin-login" action="<?php echo htmlspecialchars("adminmenu.php");?>" method="post">
        <h3>Admin Login</h3>
        <input type="text" name="username" value="Username"><br>
        <input type="password" name="user_password" value="Password"><br>
        <input type="submit" class="btn btn-primary btn-lg" name="" value="Submit">
      </form>
      <div class="warning">
        <p>The admin portions of this website are restricted to authorised users only. If you do not have the express permission of the owners of the site to access these pages, then make no attempt to do so, and shut down this window immediately.</p>
        <p>No personal or financial information is stored on this site.</p>
        <p>All customer usernames and passwords are dynamically generated and unique to this site.</p>
      </div>

<?php echo file_get_contents("../assets/html/adminfooter.html"); ?>
