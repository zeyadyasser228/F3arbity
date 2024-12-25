<?php
session_start();
require_once __DIR__ . "/db/connection.php";
require_once __DIR__ . "/components/navBar.php";
$conn = dataBase_connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="style.css?v=6.4">
    <style>
        .container-carDetails {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 50px;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .car-details {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 20px;
            display: flex;
            gap: 30px;
        }

        .car-image {
            flex: 1;
            max-width: 50%;
        }

        .car-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .car-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-top: 0;
        }

        .detail {
            margin-bottom: 15px;
            font-size: 1.1em;
        }

        .color-swatch {
            display: inline-block;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            margin-right: 10px;
            vertical-align: middle;
            border: 2px solid #fff;
            box-shadow: 0 0 0 1px #ccc;
        }

        .price {
            font-size: 1.5em;
            font-weight: bold;
            color: #27ae60;
            margin-top: 10px;
        }

        .stock {
            font-style: italic;
            color: #7f8c8d;
        }

        .error {
            color: #e74c3c;
            font-weight: bold;
            text-align: center;
            font-size: 1.2em;
        }

        @media (max-width: 768px) {
            .car-details {
                flex-direction: column;
            }

            .car-image {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    
  <?php
   renderNavbar($_SESSION);
?>
<div class="container-carDetails">

    <div class="car-details">
        <?php
        // Check if ID is provided in the URL
        if(isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];
            
            // Prepare a SQL statement
            $stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?");
            $stmt->bind_param("i", $id);
            
            // Execute the statement
            $stmt->execute();
            
            // Get the result
            $result = $stmt->get_result();
            
            if($result->num_rows > 0) {
                // Fetch the data
                $car = $result->fetch_assoc();
                
                // Display the car details
                echo "<div class='car-image'>";
                
                echo "<img src='" . htmlspecialchars($car['car_photo']) . "' alt='" . htmlspecialchars($car['car_name']) . "'>";
                echo "</div>";
                echo "<div class='car-info'>";
                echo "<h1>" . htmlspecialchars($car['car_name']) . "</h1>";
                echo "<div class='detail'><strong>Color:</strong> <span class='color-swatch' style='background-color:" . $car['color'] . ";'></span>" . htmlspecialchars($car['color']) . "</div>";
                echo "<div class='detail'><strong>Year:</strong> " . htmlspecialchars($car['model_year']) . "</div>";
                echo "<div class='detail price'><strong>Price:</strong> $" . number_format($car['price'], 2) . "</div>";
                echo "<div class='detail stock'><strong>In stock:</strong> " . htmlspecialchars($car['stock']) . "</div>";
                echo "</div>";
            } else {
                echo "<p class='error'>Car not found.</p>";
            }
            
            // Close the statement
            $stmt->close();
        } else {
            echo "<p class='error'>Invalid car ID.</p>";
        }

        // Close the connection
        $conn->close();
        ?>
    </div>
    </div>

</body>
</html>