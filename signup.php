<?php
require_once __DIR__ . "/db/auth.php";

$notification = ""; // Variable to store PHP validation result

if (isset($_POST["signUp_btn"])) {
    // Get form inputs
    $name = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $pincode = trim($_POST['pincode']);
    $role = 'user';

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert into the database
    $result = SignNewUser($name, $email, $phone, $hashed_password, $role, $pincode);
    
    if ($result === true) {
        $notification = "Account successfully created! Redirecting to home page...";
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="signup.css">
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
            <div class="signup-form">
                <h1>Sign Up</h1>
                <form action="signup.php" method="post" onsubmit="validateForm(event)">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required><br><br>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br><br>

                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" maxlength="11" pattern="\d{11}" title="Please enter a valid 11-digit phone number" required><br><br>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" minlength="8" required><br><br>

                    <label for="pincode">PinCode:</label>
                    <input type="text" id="pincode" name="pincode" required><br><br>

                    <button type="submit" class="signup-btn" name="signUp_btn">Sign Up</button><br><br>
                    <span>Already have an account? <a href="login.php" class="login-link">Login</a></span>
                </form>
            </div>
        </div>
        <div class="right-bar">
            <img src="img/front-car-lights-night-road.jpg" alt="Car Photo">
        </div>
    </div>
    
</body>
</html>