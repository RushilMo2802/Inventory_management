<?php
require 'config.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $quantity = (int)$_POST['quantity'];
    $threshold = (int)$_POST['threshold'];
    $restock_amount = (int)$_POST['restock_amount'];

    if (empty($name)) {
        $error = "Name is required.";
    } else {
        $ins = $mysqli->prepare("INSERT INTO products (name, quantity, threshold, restock_amount, last_restock) VALUES (?,?,?,?,NOW())");
        $ins->bind_param('siii', $name, $quantity, $threshold, $restock_amount);

        if ($ins->execute()) {
            header('Location: inventory.php');
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
<title>Add Item</title>
<link rel="stylesheet" href="assets/css/sidebar.css">
<link rel="stylesheet" href="assets/css/add_item.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <h2>Add Item</h2>
  <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="post" class="form-box">
    <label>Name*: <input name="name" required></label><br>
    <label>Quantity: <input name="quantity" type="number" value="0" required></label><br>
    <label>Threshold: <input name="threshold" type="number" value="100"></label><br>
    <label>Restock amount: <input name="restock_amount" type="number" value="500"></label><br>
    <button type="submit">Add Item</button>
  </form>
</div>

</body>
</html>
