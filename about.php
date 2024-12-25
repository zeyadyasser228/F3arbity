<?php 
session_start();
require_once __DIR__ . "/db/auth.php"; // Adjust the path as needed
require_once __DIR__ . "/components/navBar.php"; // Adjust the path as needed




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
    <title>About LuxeDrive Gallery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f3f4f6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        main {
            padding: 2rem 0;
        }
        h1, h2, h3 {
            margin-bottom: 1rem;
        }
        h1 {
            font-size: 2rem;
        }
        h2 {
            font-size: 1.8rem;
        }
        h3 {
            font-size: 1.5rem;
        }
        p {
            margin-bottom: 1rem;
        }
        .grid {
            display: grid;
            gap: 2rem;
        }
        .two-columns {
            grid-template-columns: 1fr 1fr;
        }
        .three-columns {
            grid-template-columns: repeat(3, 1fr);
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .feature-card, .exhibit-card {
            background-color: #fff;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .feature-card i {
            font-size: 2.5rem;
            color: #2563eb;
            margin-bottom: 1rem;
        }
        .cta {
            background-color: #2563eb;
            color: #fff;
            text-align: center;
            padding: 3rem 1rem;
            border-radius: 8px;
            margin-top: 2rem;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background-color: #fff;
            color: #2563eb;
        }
        .btn-secondary {
            background-color: transparent;
            color: #fff;
            border: 2px solid #fff;
        }
        .btn-primary:hover {
            background-color: #f3f4f6;
        }
        .btn-secondary:hover {
            background-color: #fff;
            color: #2563eb;
        }
        footer {
            background-color: #1f2937;
            color: #fff;
            padding: 3rem 0;
        }
        .footer-content {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }
        .footer-section h3 {
            margin-bottom: 1rem;
        }
        .footer-section p {
            color: #9ca3af;
        }
        .social-links a {
            color: #9ca3af;
            margin-right: 1rem;
            text-decoration: none;
        }
        .social-links a:hover {
            color: #fff;
        }
        .copyright {
            text-align: center;
            margin-top: 2rem;
            color: #9ca3af;
        }
        @media (max-width: 768px) {
            .two-columns, .three-columns {
                grid-template-columns: 1fr;
            }
            .footer-content {
                grid-template-columns: 1fr;
            }
        }
    </style>


    <link rel="stylesheet" href="style.css?v1.2">

</head>
<body>

  <?php
   renderNavbar($_SESSION);
?>

    <main class="container">
        <section>
            <h2>About Our Car Gallery</h2>
            <p>Welcome to LuxeDrive Gallery, where automotive dreams come to life. We are passionate about curating the finest collection of classic, luxury, and performance vehicles from around the world.</p>
            <div class="grid two-columns">
                <img src="./img/about.jpg" alt="LuxeDrive Gallery Showroom">
                <div>
                    <h3>Our Mission</h3>
                    <p>At LuxeDrive Gallery, we strive to preserve automotive history while showcasing the pinnacle of engineering and design. Our mission is to provide car enthusiasts with an immersive experience that celebrates the artistry and innovation of the automotive industry.</p>
                    <p>Whether you're a seasoned collector or a curious newcomer, our gallery offers a unique opportunity to witness automotive excellence up close and personal.</p>
                </div>
            </div>
        </section>

        <section>
            <h2>What Sets Us Apart</h2>
            <div class="grid three-columns">
                <div class="feature-card">
                    <i class="fas fa-car"></i>
                    <h3>Extensive Collection</h3>
                    <p>Over 200 meticulously maintained vehicles spanning a century of automotive history.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-tools"></i>
                    <h3>Expert Restoration</h3>
                    <p>Our team of skilled craftsmen breathe new life into classic cars, preserving their heritage for future generations.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-calendar"></i>
                    <h3>Regular Events</h3>
                    <p>Monthly showcases, test drives, and automotive enthusiast meetups that bring our community together.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-users"></i>
                    <h3>Knowledgeable Staff</h3>
                    <p>Our passionate team of experts is always ready to share insights and stories behind each vehicle.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-award"></i>
                    <h3>Award-Winning Curation</h3>
                    <p>Recognized for our outstanding selection and presentation of rare and significant automobiles.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Prime Location</h3>
                    <p>Conveniently located in the heart of the city, easily accessible for locals and tourists alike.</p>
                </div>
            </div>
        </section>

    </main>
    <script src="main.js?v0.2"></script>
</body>

</html>