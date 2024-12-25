<?php
require_once __DIR__ . "/db/carsFetch.php";
require_once __DIR__ . "/db/auth.php"; // Adjust the path as needed
require_once __DIR__ . "/components/navBar.php"; // Adjust the path as needed

session_start();

if (strpos($_SERVER['REQUEST_URI'], "/cars.php") && !isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Check if logout button is clicked
if (isset($_POST['logout'])) {
    logout(); // Call the logout function from auth.php
}

// Initialize the cart if it's not set in the session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $carId = $_POST['car_id'];
    $carName = $_POST['car_name'];
    $carPrice = $_POST['car_price'];

    // Check if the car is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $carId) {
            // Car is already in the cart, don't add quantity
            $found = true;
            break;
        }
    }

    // If car is not found in the cart, add it
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $carId,
            'name' => $carName,
            'price' => $carPrice,
        ];
    }

    // Redirect to the same page to update the cart
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$result = getAllCars();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css?v1.2" />

    <title>My Car Collection</title>
    <style>
        .container {
          margin-top: 50px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .car-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .car-card:hover {
            transform: translateY(-5px);
        }
        .car-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .car-info {
            padding: 15px;
        }
        .car-name {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .color-container{
          display: flex;
          align-items: center;
          gap: 10px;
          color: black;
        }
        .car-color{
          width: 50px;
          height: 20px;
          border-radius: 5px;
        }
        .car-details {
            font-size: 0.9em;
            color: #666;
        }
        .price {
            font-size: 1.1em;
            font-weight: bold;
            color: #4CAF50;
            margin-top: 10px;
        }
        .stock {
            font-size: 0.9em;
            color: #999;
        }
    </style>
</head>
<body>
  <?php
   renderNavbar($_SESSION);
?>
  <div class="container">
    <h1>My Car Collection</h1>
    <div class="car-grid">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="car-card">';
                echo '<img src="' . htmlspecialchars($row["car_photo"]) . '" alt="' . htmlspecialchars($row["car_name"]) . '" class="car-image">';
                echo '<div class="car-info">';
                echo '<div class="car-name">' . htmlspecialchars($row["car_name"]) . '</div>';
                echo '<div class="car-details">';
                echo 'Color:<div class="color-container"> <div class="car-color" style="background:'.$row["color"].';"></div>'.htmlspecialchars($row["color"]).'</div> <br>';
                echo 'Year: ' . htmlspecialchars($row["model_year"]);
                echo '</div>';
                echo '<div class="price">$' . number_format($row["price"], 2) . '</div>';
                echo '<div class="stock">In stock: ' . htmlspecialchars($row["stock"]) . '</div>';

                // Add to cart form
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="car_id" value="' . $row["id"] . '">';
                echo '<input type="hidden" name="car_name" value="' . htmlspecialchars($row["car_name"]) . '">';
                echo '<input type="hidden" name="car_price" value="' . htmlspecialchars($row["price"]) . '">';
                echo '<button type="submit" name="add_to_cart" class="add-to-cart-btn" style="
                margin-top:5px;
                cursor:pointer;
                border-radius: 5px;
    display: flex;
    align-items: center;
    font-size: 1rem;
    color: white;
    background: #d90429;
    border: 1px solid #d90429;
    padding: 4px;">Add to Cart</button>';
                echo '</form>';

                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No cars found";
        }
        ?>
        </div>
    </div>
    <script src="main.js?v0.2"></script>
</body>
</html>
