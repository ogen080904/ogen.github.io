<?php
require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verify"])) {
    $entered_otp = $_POST["otp"];

    if (isset($_SESSION["otp_code"]) && $entered_otp == $_SESSION["otp_code"]) {
        // Retrieve user data from session
        $username = $_SESSION["user_data"]["username"];
        $password = $_SESSION["user_data"]["password"];
        $email = $_SESSION["user_data"]["email"];

        // Use the existing connection from db.php
        if ($conn->connect_error) {
            die("Database Connection Failed: " . $conn->connect_error);
        }

        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            unset($_SESSION["otp_code"]);
            unset($_SESSION["user_data"]);
            // Success: Show alert and redirect
            echo "<script>
                    alert('Your OTP is verified! You are now registered.');
                    window.location.href = 'login.php';
                  </script>";
        } else {
            $errorMsg = "❌ Error registering user.";
        }
        $stmt->close();
        $conn->close();
    } else {
        $errorMsg = "❌ Invalid OTP.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Anta Store</title>
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

        /* Form Container */
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: rgb(0, 0, 0);
            margin-bottom: 20px;
            font-size: 28px;
        }

        input[type="text"] {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: rgb(0, 0, 0);
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #e55d00;
        }

        .error {
            color: red;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            font-size: 16px;
            margin-bottom: 15px;
        }

    </style>
</head>
<body>


    <!-- OTP Verification Form -->
    <div class="form-container">
        <h2>Verify OTP</h2>
        <?php if (!empty($errorMsg)) echo "<p class='error'>$errorMsg</p>"; ?>
        <?php if (!empty($successMsg)) echo "<p class='success'>$successMsg</p>"; ?>
        <form method="post" action="verify_otp.php">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <input type="submit" name="verify" value="Verify">
        </form>
    </div>

    <!-- Footer -->
   

</body>
</html>
