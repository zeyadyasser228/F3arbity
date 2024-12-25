<?php

// Include the auth.php to use the logout() function
require_once __DIR__ . "/db/auth.php"; // Adjust the path as needed
require_once __DIR__ . "/components/navBar.php"; // Adjust the path as needed

// Start session
session_start();
if ($_SERVER['REQUEST_URI'] == "/web_project/index.php" && !isset($_SESSION["username"])) {
    // Redirect to login if the user is already logged in
    header("Location: login.php");
    exit();
}
// Check if logout button is clicked
if (isset($_POST['logout'])) {
    logout(); // Call the logout function from auth.php
}

// Continue with the rest of the page
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home-page</title>
    <link rel="icon" href="img/icon.jpg">

    <link rel="stylesheet" href="style.css?v=3.9" />

    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
  <style>
    .dropdown li form{
      	border-bottom: 1px solid #ccc;
      }
      /* Styling for the Sign Out button */
      .signout {
          background-color: white;
          width: 100%;
          outline: none;
          border: none;
          padding: 0.5rem 1rem;
      }

    .overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0,0,0,0.7);
    overflow: hidden;
    width: 100%;
    height: 0;
    transition: .5s ease;
}
.container-image{
  position: relative;
}

.container-image:hover .overlay {
    height: 100%;
}

.text {
    color: white;
    font-size: 20px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.card:hover {
    transform: scale(1.05);
}

      /* Hover effect for the button */
      .signout:hover {
          background-color: #f0f0f0;
      }
      .see_more{
        color: red;
        font-size: 20px;
        width: 250px;
        height: 420px;
        display: flex;
        justify-content: center;
        align-items: center;
      }

        .container {
          margin-top: 50px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .car-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            position: relative;
        }
        .car-card {
          position: relative;
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




    <!--Home-->
    <section class="home" id="home">
      <div class="home-text">
        <h1 style="text-align: left;">
          We Have Everything <br />
          Your <span>Car</span> Need
        </h1>
        <p>
         <span style="font-size:30px;">Welcome to Car Point!</span> 
         <br>
        <span style="width: 85%;display:inline-block;color: black;margin:20px 0;">

          Find the perfect car for you. At Car Point, we offer a wide range of cars, from new<br> all in one place. Whether you're buying or selling, we make the process quick.<br> Start browsing today and discover great deals!
        </span>
        </p>
        <!--home button-->
        <a href="cars.php" style="border-radius: 7px;transition: 0.3s;" class="btn">Discover Now</a>
      </div>
    </section>
    <!-- Cars Section -->
<section class="cars" id="cars">
  <div class="heading">
    <span>All Cars</span>
    <h2>We have all types of cars</h2>
    <p>
      Select your preferred color and explore different versions from this brand.
    </p>
  </div>
  <!-- Cars Container -->
  <div class="cars-container container">
    <?php
    // Include the database connection
    require_once __DIR__ . "/db/carsFetch.php";

    // Fetch only 4 cars from the database
    $result = GetCarsWithLimit(3);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
echo '<div class="car-card">';
echo '<div class="container-image">';
echo '<div class="overlay"><a href="details.php?id=' . $row['id'] . '"><div class="text">See More</div></a></div>';
echo '<img src="' . htmlspecialchars($row["car_photo"]) . '" alt="' . htmlspecialchars($row["car_name"]) . '" class="car-image">';
echo '</div>';
echo '<div class="car-info">';
echo '<div class="car-name">' . htmlspecialchars($row["car_name"]) . '</div>';
echo '<div class="car-details">';
echo 'Color:<div class="color-container"> <div class="car-color" style="background:' . $row["color"] . ';"></div>' . htmlspecialchars($row["color"]) . '</div><br>';
echo 'Year: ' . htmlspecialchars($row["model_year"]);
echo '</div>';
echo '<div class="price">$' . number_format($row["price"], 2) . '</div>';
echo '<div class="stock">In stock: ' . htmlspecialchars($row["stock"]) . '</div>';

echo '</div>';
echo '</div>';

            }
        } else {
            echo "No cars found";
        }
    ?>

        <a href="cars.php" class="see_more">
          See More
      </a>
  </div>
</section>


    <!-- about -->
    <section class="about container" id="about">
      <div class="about-img">
        <img src="img/about.png" alt="" />
      </div>
      <div class="about-text">
        <span>About Us</span>
        <h2>
          Cheap prices with <br />
          Quality Cars
        </h2>
        <p>
          At Car Point, we believe in offering the best cars without breaking your budget. Our team carefully selects each vehicle to ensure both affordability and top-notch quality. You don’t have to compromise—drive the car of your dreams at a price you'll love.

          <!-- about buttons -->
        </p>
        <a href="about.php" class="btn">Learn More</a>

      </div>
    </section>

    <!-- parts -->
    <section class="parts" id="parts">
      <div class="heading">
        <span>What we offer</span>
        <h2>Our car Is always Excellent</h2>
        <p>
          Lorem ipsum, dolor sit amet consectetur adipisicing elit.
          Necessitatibus, delectus.
        </p>
      </div>

      <!-- parts container -->
      <div class="part-container container">
        <!-- part1 -->
        <div class="box">
          <img src="img/part1.png" alt="" />
          <h3>Auto Spare Part</h3>
          <span>$120.99</span>
          <i class="bx bxs-star">(6 Reviews)</i>
        </div>
        <!-- part1 -->
        <div class="box">
          <img src="img/part2.png" alt="" />
          <h3>Auto Spare Part</h3>
          <span>$120.99</span>
          <i class="bx bxs-star">(6 Reviews)</i>
        </div>
        <!-- part1 -->
        <div class="box">
          <img src="img/part3.png" alt="" />
          <h3>Auto Spare Part</h3>
          <span>$120.99</span>
          <i class="bx bxs-star">(6 Reviews)</i>
        </div>
        <!-- part1 -->
        <div class="box">
          <img src="img/part4.png" alt="" />
          <h3>Auto Spare Part</h3>
          <span>$120.99</span>
          <i class="bx bxs-star">(6 Reviews)</i>
        </div>
        <!-- part1 -->
        <div class="box">
          <img src="img/part5.png" alt="" />
          <h3>Auto Spare Part</h3>
          <span>$120.99</span>
          <i class="bx bxs-star">(6 Reviews)</i>
        </div>
        <!-- part1 -->
        <div class="box">
          <img src="img/part6.png" alt="" />
          <h3>Auto Spare Part</h3>
          <span>$120.99</span>
          <i class="bx bxs-star">(6 Reviews)</i>
        </div>
      </div>
    </section>

    <section>
      <!--Blog Container-->
      <section class="blog" id="blog"></section>
      <div class="heading">
        <span>Our Blog</span>
        <h2>Blog & News</h2>
        <p>
          Lorem ipsum, dolor sit amet consectetur adipisicing elit.
          Necessitatibus, delectus.
        </p>
      </div>
      <!--Blog Container-->
      <div class="blog-container container">
        <!--Box 1-->
        <div class="box">
          <img src="img/car1.jpg" />
          <span>Feb 14 2021</span>
          <h3>How To Get Prefect Car At Low Price</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Necessitatibus, praesentium.
          </p>
          <a href="#" class="blog-btn"
            >Read More<i class="bx bx-right-arrow-alt"></i
          ></a>
        </div>
        <!--Box 2-->
        <div class="box">
          <img src="img/car4.jpg" />
          <span>Feb 14 2021</span>
          <h3>How To Get Prefect Car At Low Price</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Necessitatibus, praesentium.
          </p>
          <a href="#" class="blog-but"
            >Read More <i class="bx bx-rigth-arrow-alt"></i
          ></a>
        </div>
        <!--Box 3-->
        <div class="box">
          <img src="img/car3.jpg" />
          <span>Feb 14 2021</span>
          <h3>How To Get Prefect Car At Low Price</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Necessitatibus, praesentium.
          </p>
          <a href="#" class="blog-but"
            >Read More <i class="bx bx-rigth-arrow-alt"></i
          ></a>
        </div>
      </div>
    </section>

    <!-- footer -->
    <section class="footer">
      <div class="footer-container container">
        <div class="footer-box">
          <a href="#" class="logo">Car<span>Point</span></a>
          <div class="social">
            <a href="#"><i class="bx bxl-facebook"></i></a>
            <a href="#"><i class="bx bxl-twitter"></i></a>
            <a href="#"><i class="bx bxl-instagram"></i></a>
            <a href="#"><i class="bx bxl-youtube"></i></a>
          </div>
        </div>
        <div class="footer-box">
          <h3>Pages</h3>
          <a href="#">Home</a>
          <a href="#">Cars</a>
          <a href="#">Parts</a>
          <a href="#">Sales</a>
        </div>
        <div class="footer-box">
          <h3>Legal</h3>
          <a href="#">Privacy</a>
          <a href="#">Refund Policy</a>
          <a href="#">Cookie Policy</a>
        </div>
        <div class="footer-box">
          <h3>Contact</h3>
          <p>United States</p>
          <p>Japan</p>
          <p>Germany</p>
        </div>
      </div>
    </section>
    <!--Copyrigth-->
    <div class="copyright">
      <p>&#169; CarpoolVenom All Right Reserved</p>
    </div>
   
    <!-- part1 -->
  
 
</section>

    <!--link to js -->
    <script src="main.js"></script>


  </body>
</html>
