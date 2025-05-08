<?php
require 'db.php';
require 'vendor/autoload.php'; // Load PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if ($conn->connect_error) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
}

$successMsg = "";
$errorMsg = "";

// Function to send OTP via Gmail
function sendOTPEmail($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;
        $mail->Username = 'ogensolis55@gmail.com';  
        $mail->Password = 'jakt yhiw yoio imcb';  // Use your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('ogensolis55@gmail.com', 'Anta Store');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Anta Store OTP Code';
        $mail->Body = "<p>Your OTP for Anta Store registration is: <b>$otp</b></p>
                       <p>It is valid for 10 minutes.</p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo); // Logs the error for debugging
        return false;
    }
}

// Handle Registration (Generate OTP and Send Email)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password

    if (empty($username) || empty($email) || empty($password)) {
        $errorMsg = "All fields are required!";
    } else {
        // Check if username or email already exists
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $checkStmt->bind_param("ss", $username, $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $errorMsg = "Username or email already exists.";
        } else {
            // Generate a 6-digit OTP
            $otp = rand(100000, 999999);
            $_SESSION["otp_code"] = $otp;
            $_SESSION["email"] = $email;
            $_SESSION["user_data"] = [
                'username' => $username,
                'password' => $password,
                'email' => $email
            ];

            // Send OTP via Gmail
            if (sendOTPEmail($email, $otp)) {
                header("Location: verify_otp.php");
                exit();
            } else {
                $errorMsg = "Failed to send OTP email.";
            }
        }

        $checkStmt->close();
    }
}

// Close DB connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anta Store - Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color:rgb(0, 0, 0); /* Anta Orange */
            font-size: 28px;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border 0.3s ease;
        }

        input:focus {
            border-color: rgb(0, 0, 0);
            outline: none;
        }

        input[type="submit"] {
            background-color: rgb(0, 0, 0);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            padding: 12px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #e65c00;
        }

        .error {
            color: #ff0000;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .success {
            color: #28a745;
            font-size: 16px;
            margin-bottom: 15px;
        }

        p {
            font-size: 16px;
            margin-top: 20px;
        }

        a {
            color: rgb(0, 0, 0);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register - Anta Store</h2>
        <?php if (!empty($errorMsg)) echo "<p class='error'>$errorMsg</p>"; ?>
        <form method="post" action="register.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="register" value="Register">
        </form>
        <p><a href="login.php">Already have an account? Login</a></p>
    </div>
</body>
</html>
