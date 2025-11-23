<?php
require 'config.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);

    if (empty($name)) {
        $error = "Name required.";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO retailers (name, phone , email, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $name, $contact, $email, $address);
        
        if ($stmt->execute()) {
            header('Location: retailers.php');
            exit;
        } else {
            $error = "Insert failed: " . $mysqli->error;
        }
    }
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Retailer</title>
<link rel="stylesheet" href="assets/css/sidebar.css">
<link rel="stylesheet" href="assets/css/add_retailer.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <h2>Add Retailer</h2>
  <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="post" class="form-box">
    <label>Name*: <input name="name" required></label><br>
    <label>Contact: <input name="contact"></label><br>
    <label>Email: <input name="email"></label><br>
    <label>Address: <textarea name="address"></textarea></label><br>
    <button type="submit">Add</button>
  </form>
</div>
</body>
</html>
