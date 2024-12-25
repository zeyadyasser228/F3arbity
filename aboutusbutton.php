<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Quality Cars</title>
    <style>
        :root {
            --main-color: #d90429;
            --text-color: #020120;
            --bg-color: #fff;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }
        header {
            background-color: var(--main-color);
            color: var(--bg-color);
            padding: 20px;
            text-align: center;
        }
        section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }
        .content {
            flex: 1;
            padding-right: 20px;
            max-width: 50%;
            line-height: 1.6;
        }
        .content h2 {
            color: var(--main-color);
        }
        .image {
            flex: 1;
            max-width: 50%;
            text-align: center;
        }
        .image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        footer {
            background-color: var(--main-color);
            color: var(--bg-color);
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

    <header>
        <h1>About Car Point</h1>
    </header>

    <section>
        <!-- Left Side: Text Content -->
        <div class="content">
            <h2>Affordable Prices & Quality Cars</h2>
            <p>At Car Point, we take pride in offering cars at affordable prices without compromising on quality. We ensure every car goes through rigorous checks and inspections to guarantee that you are driving away with a vehicle that’s reliable, stylish, and within your budget.</p>
            
            <h2>Why Buy From Us?</h2>
            <ul>
                <li>Wide selection of top brands</li>
                <li>All cars come with a quality guarantee</li>
                <li>Customizable options: choose colors, models, and more</li>
                <li>Best price offers and financing options available</li>
            </ul>
        </div>
        
        <!-- Right Side: Image -->
        <div class="image">
            <img src="img/front-car-lights-night-road.jpg" alt="Luxury Car">
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Car Point. All rights reserved.</p>
    </footer>

</body>
</html>
