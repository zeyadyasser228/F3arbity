<?php
require_once __DIR__ . '/db/auth.php';

$message = '';
$messageType = '';
session_start();

if (strpos($_SERVER['REQUEST_URI'], "/forgetPassword.php") && isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $message = forgetPassword($email);
            $_SESSION["email"] = $email;
            $messageType = 'success';
            header("Location: signOtp.php");
            exit();
        } catch (Exception $e) {
            $message = "An error occurred: " . $e->getMessage();
            $messageType = 'error';
        }
    } else {
        $message = "Invalid email format";
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Forgot Password</h1>
        
        <?php if ($message): ?>
            <div class="message mb-6 p-4 rounded <?php echo $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="forgetPassword.php" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Enter your email to reset password:</label>
                <input type="email" id="email" name="email" required class="input-field w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
            </div>
            <button type="submit" class="submit-btn w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-300">
                Send OTP
            </button>
        </form>
        <div class="mt-6 text-center">
            <a href="login.php" class="text-sm text-purple-600 hover:text-purple-800 transition-colors duration-300">Back to Login</a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelector('form').addEventListener('submit', function(e) {
                let email = document.getElementById('email').value;
                if (!email) {
                    e.preventDefault();
                    alert('Please enter your email address.');
                }
            });
        });
    </script>
</body>
</html>

