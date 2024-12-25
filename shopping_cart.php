<?php
session_start();
if (strpos($_SERVER['REQUEST_URI'], "/shopping_cart.php") && !isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}


$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    $required_fields = ['name', 'email', 'address', 'city', 'phone', 'card-number', 'expiry-date', 'cvv'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = ucfirst(str_replace('-', ' ', $field)) . ' is required';
        }
    }
    if (empty($errors)) {
        $success = true;
    }
}

// Calculate total from cart
$total = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cartItem) {
        // You should fetch the actual price from the database here
        // This is just a placeholder calculation
        $total += $cartItem["price"]; // Assuming each car costs $75,000
    }
}
$tax = $total * 0.05; // 5% tax
$grandTotal = $total + $tax;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Luxury Car Purchase</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="shopping_cart.css?v=5.7">
</head>
<body>
    <div class="container">
        <header>
            <h1>Complete Your Luxury Car Purchase</h1>
        </header>
        <main>
            <?php if ($success): ?>
                <div class="success-message">
                    <h2>Thank You for Your Purchase!</h2>
                    <p>Your order has been successfully processed. You will receive a confirmation email shortly.</p>
                    <?php
                    // Clear the cart
                    unset($_SESSION['cart']);
                    ?>
                    <p>Your cart has been cleared.</p>
                    <a href="index.php" class="clear">Return to Home</a>
                </div>
            <?php else: ?>
                <form id="checkout-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <section class="shipping-info">
                        <h2>Shipping Information</h2>
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                            <?php if (isset($errors['name'])): ?>
                                <span class="error"><?php echo $errors['name']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                            <?php if (isset($errors['email'])): ?>
                                <span class="error"><?php echo $errors['email']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
                            <?php if (isset($errors['address'])): ?>
                                <span class="error"><?php echo $errors['address']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>">
                            <?php if (isset($errors['city'])): ?>
                                <span class="error"><?php echo $errors['city']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                            <?php if (isset($errors['phone'])): ?>
                                <span class="error"><?php echo $errors['phone']; ?></span>
                            <?php endif; ?>
                        </div>
                    </section>
                    <section class="payment-info">
                        <h2>Payment Information</h2>
                        <div class="form-group">
                            <label for="card-number">Card Number</label>
                            <input type="text" id="card-number" name="card-number" value="<?php echo isset($_POST['card-number']) ? htmlspecialchars($_POST['card-number']) : ''; ?>">
                            <?php if (isset($errors['card-number'])): ?>
                                <span class="error"><?php echo $errors['card-number']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="expiry-date">Expiration Date</label>
                            <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" value="<?php echo isset($_POST['expiry-date']) ? htmlspecialchars($_POST['expiry-date']) : ''; ?>">
                            <?php if (isset($errors['expiry-date'])): ?>
                                <span class="error"><?php echo $errors['expiry-date']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" name="cvv" value="<?php echo isset($_POST['cvv']) ? htmlspecialchars($_POST['cvv']) : ''; ?>">
                            <?php if (isset($errors['cvv'])): ?>
                                <span class="error"><?php echo $errors['cvv']; ?></span>
                            <?php endif; ?>
                        </div>
                    </section>
                    <section class="order-summary">
                        <h2>Order Summary</h2>
                        <?php foreach ($_SESSION['cart'] as $cartItem): ?>
                            <div class="order-item">
                                <span><?php echo htmlspecialchars($cartItem['name']); ?></span>
                                <span>$<?php echo number_format($cartItem['price'], 2); ?></span>
                            </div>
                        <?php endforeach; ?>
                        <div class="order-item">
                            <span>Tax (5%)</span>
                            <span>$<?php echo number_format($tax, 2); ?></span>
                        </div>
                        <div class="order-total">
                            <strong>Total</strong>
                            <strong>$<?php echo number_format($grandTotal, 2); ?></strong>
                        </div>
                    </section>
                    <button type="submit" class="submit-btn">Complete Purchase</button>
                </form>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>