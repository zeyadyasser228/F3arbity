<?php
session_start();
require_once __DIR__ . "/db/auth.php"; // Ensure this path is correct
require_once __DIR__ . "/db/connection.php"; // Database connection file
require_once __DIR__ . "/components/navBar.php"; // Ensure this path is correct

// Initialize database connection
$conn = dataBase_connect(); // Call the function to establish the connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    // Insert the message into the database
    $query = "INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    if ($stmt->execute()) {
        generateToast("Message submitted successfully!", "success"); // Toast for success
    } else {
        generateToast("Failed to submit the message. Please try again later.", "error"); // Toast for error
    }

    $stmt->close();
    $conn->close();
}

// Check if logout button is clicked
if (isset($_POST['logout'])) {
    logout(); // Call the logout function from auth.php
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Car Website</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        .container {
            width: 100%;
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .contact-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            flex: 1;
        }
        .image-space {
            flex: 1;
            margin-right: 20px;
            background-color: #ddd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #666;
        }
        h1 {
            color: #ff0000;
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #333;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea{
            resize: none;
        }
        button {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #cc0000;
        }
        @media (max-width: 920px) {
	.container{
		flex-direction: column-reverse;
        gap: 30px;
	}
}
    </style>

    <link rel="stylesheet" href="style.css?v1.2">
    <script>
        function showToast(message, color) {
            const toast = document.createElement('div');
            toast.textContent = message;
            toast.style.position = 'fixed';
            toast.style.bottom = '20px';
            toast.style.right = '20px';
            toast.style.backgroundColor = color;
            toast.style.color = '#fff';
            toast.style.padding = '10px 20px';
            toast.style.borderRadius = '5px';
            toast.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
            toast.style.zIndex = 1000;
            toast.style.transition = 'opacity 0.3s ease-in-out';
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => document.body.removeChild(toast), 300);
            }, 3000);
        }
    </script>
    <?php
    // Add PHP-generated toast script here
    ?>
</head>
<body>
    <?php renderNavbar($_SESSION); ?>
    <div class="container">
        <div class="image-space">
            <img src="img/contact.jpg" alt="">
        </div>
        <div class="contact-form">
            <h1>Contact Us</h1>
            <form method="POST" action="">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
    <script src="main.js?v0.2"></script>
</body>
</html>