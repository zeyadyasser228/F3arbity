<?php
require_once __DIR__ . "/db/connection.php";
session_start();

if (strpos($_SERVER['REQUEST_URI'], "/signOtp.php") && isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

$conn = dataBase_connect();

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userOtp = $_POST['otp'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (!empty($userOtp) && empty($newPassword)) {
        // Validate the OTP
        $stmt = mysqli_prepare($conn, "SELECT otp FROM users WHERE Email = ?");
        mysqli_stmt_bind_param($stmt, "s", $_SESSION["email"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        if ($rows && $rows[0]["otp"] == $userOtp) {
            // OTP is valid, allow password reset
            $_SESSION["otp_verified"] = true;
            $message = "OTP verified successfully. Please reset your password.";
            $messageType = 'success';
        } else {
            $message = "Invalid OTP. Please try again.";
            $messageType = 'error';
        }
    } elseif (!empty($newPassword) && !empty($confirmPassword)) {
        // Handle password reset
        if ($newPassword === $confirmPassword) {
            if ($_SESSION["otp_verified"] ?? false) {
                // Update the password in the database
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $stmt = mysqli_prepare($conn, "UPDATE users SET pass = ? WHERE Email = ?");
                mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $_SESSION["email"]);
                mysqli_stmt_execute($stmt);

                $message = "Password reset successful. Please log in.";
                $messageType = 'success';
                $_SESSION["email"] = "";
                $_SESSION["otp_verified"] = false;
                header("Refresh: 3; URL=login.php");
            } else {
                $message = "OTP verification is required before resetting the password.";
                $messageType = 'error';
            }
        } else {
            $message = "Passwords do not match. Please try again.";
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .form-container {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .input-field {
            transition: all 0.3s ease;
        }
        .input-field:focus {
            transform: scale(1.02);
        }
        .submit-btn {
            transition: all 0.3s ease;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .message {
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="form-container w-full max-w-md p-8 rounded-lg shadow-2xl">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Reset Your Password</h1>
        
        <?php if ($message): ?>
            <div class="message mb-6 p-4 rounded <?php echo $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if (!($_SESSION["otp_verified"] ?? false)): ?>
            <form action="signOtp.php" method="POST" class="space-y-6">
                <div>
                    <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">Enter OTP:</label>
                    <input type="text" id="otp" name="otp" required class="input-field w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>
                <button type="submit" class="submit-btn w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-300">
                    Verify OTP
                </button>
            </form>
        <?php else: ?>
            <form action="signOtp.php" method="POST" class="space-y-6">
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required class="input-field w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required class="input-field w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>
                <button type="submit" class="submit-btn w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-300">
                    Reset Password
                </button>
            </form>
        <?php endif; ?>
        <div class="mt-6 text-center">
            <a href="login.php" class="text-sm text-purple-600 hover:text-purple-800 transition-colors duration-300">Back to Login</a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const inputs = this.querySelectorAll('input[required]');
                inputs.forEach(input => {
                    if (!input.value) {
                        isValid = false;
                        input.classList.add('border-red-500');
                    } else {
                        input.classList.remove('border-red-500');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                }

                if (this.new_password && this.confirm_password) {
                    if (this.new_password.value !== this.confirm_password.value) {
                        e.preventDefault();
                        alert('Passwords do not match.');
                    }
                }
            });
        });
    </script>
</body>
</html>

