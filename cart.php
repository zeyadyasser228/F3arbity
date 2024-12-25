<?php
session_start();
require_once __DIR__ . "/components/navBar.php";
require_once __DIR__ . "/db/connection.php";

// Handle remove item action
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $removeId = intval($_GET['remove']);
    foreach ($_SESSION['cart'] as $key => $cartItem) {
        if ($cartItem['id'] == $removeId) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
            break;
        }
    }
}

// Handle clear cart action
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
}

// Check if the cart exists in the session
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p style='color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px;'>Your cart is empty.</p>";
    echo "<p><a href='index.php' style='color: #007bff; text-decoration: none;'>Continue shopping</a></p>";
    exit;
}

// Connect to the database using the existing function
$conn = dataBase_connect();

// Start the HTML output
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 20px;
        }
        .actions {
            margin-top: 20px;
            text-align: center;
        }
        .actions a {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        .actions a:hover {
            background-color: #0056b3;
        }
        .actions a.clear {
            background-color: #dc3545;
        }
        .actions a.clear:hover {
            background-color: #a71d2a;
        }
    </style>
    <link rel="stylesheet" href="style.css?v=3.1">
</head>
<body>
    <?php
    renderNavbar($_SESSION);
    ?>
    <h2 style="margin-bottom: 20px;">Your Cart</h2>

    <table>
        <tr>
            <th>Photo</th>
            <th>Car Name</th>
            <th>Color</th>
            <th>Model Year</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $cartItem) {
            $carId = $cartItem['id'];

            // Fetch car details for each car ID
            $stmt = $conn->prepare("SELECT id, car_name, color, model_year, price, stock, car_photo FROM cars WHERE id = ?");
            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }

            $stmt->bind_param('i', $carId);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if the car exists
            if ($car = $result->fetch_assoc()) {
                $total += $car['price'];
                echo "<tr>
                    <td><img src='{$car['car_photo']}' alt='{$car['car_name']}'></td>
                    <td>{$car['car_name']}</td>
                    <td>{$car['color']}</td>
                    <td>{$car['model_year']}</td>
                    <td>$" . number_format($car['price'], 2) . "</td>
                    <td>{$car['stock']}</td>
                    <td><a href='?remove={$car['id']}' style='color: red;'>Remove</a></td>
                </tr>";
            }

            // Close the statement for this iteration
            $stmt->close();
        }
        ?>
    </table>
    <div class="total">Total: $<?php echo number_format($total, 2); ?></div>
    <div class="actions">
        <a href="?clear=true" class="clear">Clear Cart</a>
        <a href="shopping_cart.php" class="clear">Checkout</a>
    </div>
    <script src="main.js"></script>
</body>
</html>
<?php
// Close the database connection
$conn->close();
?>