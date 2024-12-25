<?php
function renderNavbar($sessionData) {
    // Get cart items from the session
    $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $cartItemCount = count($cartItems); // Get the number of items in the cart

    // Check if a remove button was clicked for a specific item
    if (isset($_POST['remove_item'])) {
        $carIdToRemove = $_POST['car_id_to_remove'];
        // Remove the item with the given ID from the cart
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($carIdToRemove) {
            return $item['id'] != $carIdToRemove;
        });
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array

        // Redirect to the same page to update the cart state immediately
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
?>
    <nav>
        <div class="nav-container">
            <a href="index.php" class="logo">
                <button class="logo-btn">F</button>
                <span>3arbity</span>
            </a>
            <ul class="menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="cars.php">Cars</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <div class="hamburger">&#9776;</div>

            <!-- Cart Icon -->
            <?php if (isset($_SESSION["username"])): ?>
            <div class="cart-container">
                <button id="cart-btn">
                    🛒
                    <span class="cart-count"><?php echo $cartItemCount; ?></span>
                </button>
                <!-- Cart Dropdown -->
                <div class="cart-dropdown">
                    <h4>Cart Items</h4>
                    <?php if ($cartItemCount > 0): ?>
                        <ul>
                            <?php foreach ($cartItems as $item): ?>
                                <li style="margin-bottom: 0.5rem; border-bottom:1px solid #ccc; display: flex; justify-content: space-between; padding: 10px 20px;">
                                    <span style="font-weight: bold;"><?php echo htmlspecialchars($item['name']); ?></span>
                                    <!-- Remove button for each item -->
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="car_id_to_remove" value="<?php echo $item['id']; ?>">
                                        <button type="submit" name="remove_item" style="background: none; border: none; color: red; cursor: pointer;">Remove</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                            <li style="text-align:center;padding: 10px 20px;"><a style="color: #d92727;" href="cart.php">Go to My Cart</a></li>
                        </ul>
                    <?php else: ?>
                        <p>Your cart is empty.</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if (isset($sessionData['username'])): ?>
                <div class="user-menu">
                    <span><?php echo htmlspecialchars($sessionData['username']); ?></span>
                    <img src="./img/user.png" alt="User Photo">
                    <div class="dropdown">
                        <div>
                            <span><?php echo htmlspecialchars($sessionData['username']); ?></span><br>
                            <small><?php echo htmlspecialchars($sessionData['email']); ?></small>
                        </div>
                        <ul>
                            <?php if (in_array(strtolower($sessionData['role']), ['admin', 'superadmin'])): ?>
                                <li><a href="admin.php">Dashboard</a></li>
                            <?php endif; ?>
                            <li><a href="#">Settings</a></li>
                            <li><a href="#">Earnings</a></li>
                            <li>
                                <form action="" method="POST" style="display:inline;">
                                    <button class="signout" type="submit" name="logout">Sign Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <div class="auth-buttons">
                    <a href="login.php">Sign In</a>
                    <a href="signup.php">Sign Up</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>
<?php
} // Closing brace for renderNavbar
?>
