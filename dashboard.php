<?php
require 'config.php';
require_login(); // ensures only logged-in users can access

// Fetch username from database using user_id stored in session
$user_name = 'User'; // default fallback
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Use prepared statement to fetch username
    $stmt = $mysqli->prepare("SELECT fullname FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($user_name);
    $stmt->fetch();
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="assets/css/sidebar.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #ecf0f1;
      margin: 0;
    }
    .main-content {
      margin-left: 250px; /* adjust if sidebar width changes */
      padding: 40px;
    }
    h1 {
      color: #16a085;
      text-align: center;
    }
    p {
      text-align: center;
      font-size: larger;
      color: #2c3e50;
    }
  </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <h1>Welcome, <?= htmlspecialchars($user_name); ?>!</h1>
  <p>Select a section from the sidebar to get started.</p>
</div>

</body>
</html>
