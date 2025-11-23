<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Prepare query to get password hash
    $stmt = $mysqli->prepare("SELECT id, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            // ✅ Login successful → Start session & redirect
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['email'] = $email;

            echo "<script>
                    alert('Login Successful! Welcome back!');
                    window.location.href = 'dashboard.php';
                  </script>";
            exit;
        } else {
            echo "<script>alert('Incorrect password!');</script>";
        }
    } else {
        echo "<script>alert('Email not found!');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/login.css">
  <script src="assets/main.js"></script>
</head>
<body>
 <div class="login-container">
    <h2>Login</h2>
    <form method="POST" action="login.php" onsubmit="return validateLogin()">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Login</button>
        <p>Don’t have an account? <a href="register.php">Register</a></p>
    </form>
</div>

</body>
</html>
