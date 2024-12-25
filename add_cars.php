<?php
// Include the database connection
require_once __DIR__ . "/db/connection.php";
require_once __DIR__ . "/db/auth.php";
require_once __DIR__ . "/components/navBar.php";

// Increase upload file size and execution time limits
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '12M');
ini_set('max_execution_time', '300');

// Start session
session_start();
$conn = dataBase_connect();

// Check if logout button is clicked
if (isset($_POST['logout'])) {
    logout();
}

// Redirect if the user is not an admin
if (stripos($_SERVER['REQUEST_URI'], "/add_cars.php") !== false &&
    (strtolower($_SESSION["role"]) !== "admin")) {
    header("Location: index.php");
    exit();
}

// Handle form submission for add/update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carId = isset($_POST['car-id']) ? intval($_POST['car-id']) : null;
    $carName = $_POST['car-name'];
    $carColor = $_POST['car-color'];
    $modelYear = intval($_POST['model-year']);
    $price = floatval($_POST['price']);
    $stocks = intval($_POST['no-of-stocks']);

    // File upload logic
    $carPhoto = null;
    if (isset($_FILES['car-photo']) && $_FILES['car-photo']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $imageFileType = strtolower(pathinfo($_FILES['car-photo']['name'], PATHINFO_EXTENSION));
        $targetFile = $targetDir . uniqid() . "." . $imageFileType;

        // Validate file size and type
        if ($_FILES['car-photo']['size'] <= 10000000 && in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
            if (move_uploaded_file($_FILES['car-photo']['tmp_name'], $targetFile)) {
                $carPhoto = $targetFile;
            } else {
                echo "Error: Failed to upload car photo.";
            }
        } else {
            echo "Error: Invalid file type or size.";
        }
    }

    if ($carId) {
        // edit
        // Update existing car
        $query = "UPDATE cars SET car_name = ?, color = ?, model_year = ?, price = ?, stock = ?" .
                 ($carPhoto ? ", car_photo = ?" : "") . " WHERE id = ?";
        $stmt = $conn->prepare($query);
        if ($carPhoto) {
            $stmt->bind_param("ssidiss", $carName, $carColor, $modelYear, $price, $stocks, $carPhoto, $carId);
        } else {
            $stmt->bind_param("ssddii", $carName, $carColor, $modelYear, $price, $stocks, $carId);
        }
        $stmt->execute();
        $notification = "Updated Car successfully";

    } else {
        // 
        // Add new car
        $query = "INSERT INTO cars (car_name, color, model_year, price, stock, car_photo) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssddis", $carName, $carColor, $modelYear, $price, $stocks, $carPhoto);
        $stmt->execute();
    }

    header("Location: add_cars.php");
    exit();
}

// Handle delete request
// delete 
if (isset($_GET['delete'])) {
    $carId = intval($_GET['delete']);
    $query = "DELETE FROM cars WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $carId);
    $stmt->execute();
    header("Location: add_cars.php");
    exit();
}

// Fetch all cars
$query = "SELECT * FROM cars";
$result = $conn->query($query);
$cars = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cars</title>
    <link rel="stylesheet" href="style.css?v=5.4">
    <!-- <link rel="stylesheet" href="add_cars.css?v=5.6"> -->
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
    }

    .layout {
        display: flex;
        margin: 20px;
        gap: 20px;
    }

    .car-cards {
        flex: 2;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .car-card {
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: calc(50% - 10px);
        max-height: 550px;
        overflow-y: auto;
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .car-card img {
        width: 100%;
        height: auto;
        display: block;
    }

    .car-card h3 {
        font-size: 1.2em;
        margin: 10px 0;
    }

    .car-card p {
        font-size: 0.9em;
        margin: 5px 10px;
        line-height: 1.5;
    }

    .car-card button, .car-card a {
        display: inline-block;
        width: 150px;
        margin: 10px 5px;
        padding: 8px 15px;
        font-size: 0.9em;
        color: #fff;
        background: #d90429;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.3s;
    }

    .car-card button:hover, .car-card a:hover {
        background: #d90429;
    }
    .car-card .btns-container{
        align-self: center;
        width: 80%;
        display: flex;
        justify-content: space-between;
    }
    .car-card:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .right-container {
        flex: 1;
        background: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        align-self: flex-start;
    }

    #form-title {
        font-size: 1.5em;
        margin-bottom: 20px;
    }

    form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    form input, form button {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1em;
    }

    form button {
        background: #d90429;
        color: #fff;
        cursor: pointer;
        transition: background 0.3s;
    }

    form button:hover {
        background: rgba(217, 4, 39, 0.53);
    }

    form input[type="file"] {
        padding: 5px;
    }

    form input[type="color"] {
        width: 50px;
        padding: 0;
        height: 30px;
    }

    @media (max-width: 920px) {
	.layout{
		flex-direction: column-reverse;
	}
	.right-container{
		width: 100%;
	}
}
</style>
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
<?php renderNavbar($_SESSION); ?>
        <div id="toast-container"></div>

<div class="layout">
    <!-- Left Side: Car Cards -->
    <div class="car-cards">
        <?php foreach ($cars as $car): ?>
            <div class="car-card">
                <img src="<?= htmlspecialchars($car['car_photo']) ?>" alt="Car Image" width="100%">
                <h3><?= htmlspecialchars($car['car_name']) ?></h3>
                <p>Model Year: <?= htmlspecialchars($car['model_year']) ?></p>
                <p>Color: <span style="background-color:<?= htmlspecialchars($car['color']) ?>;">&nbsp;&nbsp;&nbsp;</span></p>
                <p>Price: $<?= htmlspecialchars($car['price']) ?></p>
                <p>Stocks: <?= htmlspecialchars($car['stock']) ?></p>
                <div class="btns-container">

                    <button onclick="editCar(<?= htmlspecialchars(json_encode($car)) ?>)">Edit</button>
                    <a href="?delete=<?= $car['id'] ?>" onclick="return confirm('Are you sure you want to delete this car?');">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Right Side: Form -->
    <div class="right-container">
        <h1 id="form-title">Add Car Details</h1>
        <form id="car-form" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="car-id" name="car-id" />
            <label for="car-name">Car Name:</label>
            <input type="text" id="car-name" name="car-name" required />

            <label for="car-color">Color:</label>
            <input type="color" id="car-color" name="car-color" required />

            <label for="model-year">Model Year:</label>
            <input type="number" id="model-year" name="model-year" required />

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required />

            <label for="no-of-stocks">Number of Stocks:</label>
            <input type="number" id="no-of-stocks" name="no-of-stocks" required />

            <label for="car-photo">Car Photo:</label>
            <input type="file" id="car-photo" name="car-photo" accept="image/*" />

            <button type="submit">Save</button>
        </form>
    </div>
</div>
    <script src="main.js"></script>

<script>
    function editCar(car) {
        document.getElementById("form-title").innerText = "Edit Car Details";
        document.getElementById("car-id").value = car.id;
        document.getElementById("car-name").value = car.car_name;
        document.getElementById("car-color").value = car.color;
        document.getElementById("model-year").value = car.model_year;
        document.getElementById("price").value = car.price;
        document.getElementById("no-of-stocks").value = car.stock;
        document.getElementById("car-form").scrollIntoView({ behavior: "smooth" });
    }
</script>
</body>
</html>


