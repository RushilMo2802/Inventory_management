<?php
require 'config.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Hash the password before saving
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // ✅ Check if email already exists first
    $checkStmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "<script>alert('This email is already registered! Please use another one.'); window.location='register.php';</script>";
        $checkStmt->close();
    } else {
        $checkStmt->close();

        // Insert new user
        $stmt = $mysqli->prepare("INSERT INTO users (fullname, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "<script>alert('Registration Successful! You can now log in.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Error occurred while registering. Please try again.');</script>";
        }

        $stmt->close();
    }
}

// $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="assets/css/register.css">
  <script src="assets/main.js"></script>
</head>
<body>
  <div class="register-container">
  <h2>Register</h2>
  <form method="POST" onsubmit="return validateRegisterForm()">
    <input type="text" name="username" id="username" placeholder="Enter Username" required>
    <input type="email" name="email" id="email" placeholder="Enter Email" required>
    <input type="password" name="password" id="password" placeholder="Enter Password" required>
    <button type="submit">Register</button>
    <p>Already have an account? <a href="login.php">Login</a></p>
  </form>
</div>

</body>
</html>
