<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anta Store - Landing Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        /* Header Styles */
        header {
            background-color: #111;
            padding: 10px 0;
            text-align: center;
            color: white;
        }

        header h1 {
            font-size: 36px;
            color: rgb(0, 0, 0);
        }

        /* Navigation Styles */
        nav {
            background-color: #222;
            padding: 10px 0;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 18px;
            margin: 0 15px;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: rgb(0, 0, 0);
            border-radius: 5px;
        }

        /* Footer Styles */
        footer {
            background-color: #111;
            color: white;
            text-align: center;
            padding: 20px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        footer p {
            font-size: 16px;
        }

        /* Main Container */
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: rgb(0, 0, 0);
            font-size: 36px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .product-card {
            display: inline-block;
            width: 250px;
            margin: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .product-card img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .product-card h4 {
            color: #333;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .product-card p {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }

        .product-card strong {
            color: rgb(0, 0, 0);
            font-size: 18px;
        }

        .logout-link {
            font-size: 18px;
            color: rgb(0, 0, 0);
            text-decoration: none;
            margin-top: 30px;
            display: inline-block;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid rgb(0, 0, 0);
            transition: background-color 0.3s ease;
        }

        .logout-link:hover {
            background-color: rgb(0, 0, 0);
            color: white;
        }

    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <h1>Anta</h1>
    </header>

    <!-- Navigation -->
    <nav>
        <a href="landing.php">Home</a>
        <a href="shop.php">Shop</a>
        <a href="contact.php">Contact</a>
        <a href="logout.php">Logout</a>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
        <p>🏃‍♂️ Step into greatness with Anta.</p>

        <div class="product-card">
            <img src="images/airforce1.png" alt="Anta Air Force 1">
            <h4>Anta Air Force 1</h4>
            <p>Classic white street sneakers</p>
            <p><strong>₱5,295</strong></p>
        </div>

        <div class="product-card">
            <img src="images/cortez.png" alt="Anta Cortez 23">
            <h4>Anta Cortez 23</h4>
            <p>Platinum Violet/Amethyst</p>
            <p><strong>₱5,295</strong></p>
        </div>

        <div class="product-card">
            <img src="images/pegasus.png" alt="Anta Pegasus 40">
            <h4>Anta Pegasus 40</h4>
            <p>Lightweight running shoes</p>
            <p><strong>₱7,995</strong></p>
        </div>

        <div class="product-card">
            <img src="images/courtlegacy.png" alt="AntaCourt Legacy">
            <h4>AntaCourt Legacy</h4>
            <p>Full-length rubber outsole</p>
            <p><strong>₱12,999</strong></p>
        </div>

        <div class="product-card">
            <img src="images/dunklow.png" alt="Anta Dunk Low">
            <h4>Anta Dunk Low</h4>
            <p>Street-style sneakers</p>
            <p><strong>₱6,895</strong></p>
        </div>

        <p><a class="logout-link" href="logout.php">Logout</a></p>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Anta Store | All Rights Reserved</p>
    </footer>

</body>
</html>
