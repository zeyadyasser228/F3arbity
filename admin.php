<?php 
// Include the auth.php to use the logout() function
require_once __DIR__ . "/db/auth.php"; // Adjust the path as needed
require_once __DIR__ . "/components/navBar.php"; // Adjust the path as needed

// Start session
session_start();
if (strpos($_SERVER['REQUEST_URI'], "/admins.php") && isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}
// Check if logout button is clicked
if (isset($_POST['logout'])) {
    logout(); // Call the logout function from auth.php
}
if (stripos($_SERVER['REQUEST_URI'], "/admin.php") !== false &&
    (strtolower($_SESSION["role"]) !== "admin")) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" href="img/icon.jpg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css?v=2.4" />
    <link rel="stylesheet" href="admin.css?v=1.5" />
  </head>
  <body>


  <?php
   renderNavbar($_SESSION);
?>

    <!-- Dashboard content -->
     <div class="layout">

       <div class="container">
         <a href="add_cars.php">
           <div class="box admin">
             <h2>Add Cars</h2>
            </div>
          </a>
          <a href="addadmins.php">
            <div class="box admin">
          <h2>Add Admins</h2>
        </div>
      </a>
       </div>
    </div>
  </body>
      <script src="main.js"></script>

</html>
