<?php
session_start();
require_once __DIR__. "/db/AddAdmin.php";
require_once __DIR__ . "/components/navBar.php"; // Adjust the path as needed
require_once __DIR__ . "/db/auth.php"; // Adjust the path as needed
if(isset($_POST["AddAdmin_btn"])){
    $name = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'admin';
    // $name, $email ,$phone,$password , $role ="admin"
    AddAdmin($name, $email ,$phone,$password , $role);
  }
if (isset($_POST['logout'])) {
logout();
} // Call the logout function from auth.php
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Admins</title>
    <link rel="stylesheet" href="add_admins.css?v=0.1" />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <!-- Navigation Bar -->
      <?php
   renderNavbar($_SESSION);
?>
  <div class="layout">
    <!-- Main Content -->
    <div class="main-container">
      <!-- Left Side: Visuals -->
      
      <div class="right-container">
        <h1>Add Admin Details</h1>
        <form id="admin-form" method="post" action="">
          <label for="username">Admin Name:</label>
          <input type="text" id="username" name="username" required />
          <label for="phone">Phone:</label>
        <input 
          type="tel" 
          id="phone" 
          name="phone" 
          minlength="11" 
          pattern="[0-9]{11,}" 
          title="Please enter a valid phone number (only digits allowed)" 
          required >

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required />

          <label for="password">Password:</label>
          <input
            type="password"
            id="password"
            name="password"
            minlength="8"

            
            required
          />

          <button type="submit" name="AddAdmin_btn">Add Admin</button>
        </form>
      </div>
    </div>
  </div>
  <script src="main.js"></script>
  </body>
</html>
