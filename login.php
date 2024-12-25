<?php
require_once __DIR__ . "/db/auth.php";
session_start();

$notification = ""; // Variable to store PHP validation result


if (strpos($_SERVER['REQUEST_URI'], "/login.php") && isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}


  if(isset($_POST["login_btn"])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $result = loginUser($email ,$password );

      if ($result === true) {
        $notification = "Login successfully!";
        $toastType = "success";
        echo "<script>
                window.onload = function() {
                    showToast('$notification', '#4CAF50');
                    setTimeout(function() {
                        window.location.href = 'index.php';
                    }, 3000);
                };
              </script>";
    } else {
        $notification = $result;
        $toastType = "error";
        echo "<script>
                window.onload = function() {
                    showToast('$notification', '#F44336');
                };
              </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css" />
        <style>
        #toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .toast {
            padding: 15px 20px;
            color: white;
            margin-bottom: 10px;
            border-radius: 4px;
            opacity: 0;
            transition: opacity 0.4s ease-out;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .toast.show {
            opacity: 1;
        }
    </style>
        <script>
        function validateForm(event) {
            // Get form values
            const username = document.getElementById("username").value.trim();
            const email = document.getElementById("email").value.trim();
            const phone = document.getElementById("phone").value.trim();
            const password = document.getElementById("password").value.trim();
            const pincode = document.getElementById("pincode").value.trim();

            // Validate inputs
            if (!username || !email || !phone || !password || !pincode) {
                showToast("All fields are required!", "#F44336");
                event.preventDefault();
                return false;
            }
            if (!/^\d{11}$/.test(phone)) {
                showToast("Phone number must be exactly 11 digits!", "#F44336");
                event.preventDefault();
                return false;
            }
            if (password.length < 8) {
                showToast("Password must be at least 8 characters long!", "#F44336");
                event.preventDefault();
                return false;
            }
        }

        function showToast(message, color) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.style.backgroundColor = color;
            toast.textContent = message;
            container.appendChild(toast);

            // Trigger reflow
            toast.offsetHeight;

            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    container.removeChild(toast);
                }, 400);
            }, 3000);
        }
    </script>
  </head>
  <body>
        <div id="toast-container"></div>
    <div class="container">
      <div class="left-bar">
        <div class="login-form">
          <h1>Login</h1>
          <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required /><br /><br />

            <label for="password">Password:</label>
            <input
              type="password"
              id="password"
              name="password"

              required
            /><br /><br />

            <button type="submit" class="login-btn" name="login_btn">Login</button><br /><br />

            <a href="forgetPassword.php" class="forgot-password">Forgot Password?</a><br /><br />

            <span
              >Don't have an account?
              <a href="signup.php" class="create-account"
                >Create Account</a
              ></span
            >
          </form>
        </div>
      </div>

      <div class="right-bar">
        <img src="img/front-car-lights-night-road.jpg" alt="Car Photo" />
      </div>
    </div>
  </body>
</html>