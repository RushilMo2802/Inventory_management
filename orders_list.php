<?php
require 'config.php';
require_login();

$sql = "SELECT o.*, p.name AS product_name, r.name AS retailer_name
        FROM orders o
        JOIN products p ON p.id = o.product_id
        JOIN retailers r ON r.id = o.retailer_id
        ORDER BY o.order_date DESC";
$res = $mysqli->query($sql);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Orders</title>
<link rel="stylesheet" href="assets/css/sidebar.css">
<link rel="stylesheet" href="assets/css/orders_list.css">
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="main-content">
  <h2>Orders</h2>
  <table>
    <thead>
      <tr><th>ID</th><th>Product</th><th>Retailer</th><th>Qty</th><th>Time</th></tr>
    </thead>
    <tbody>
      <?php while($row = $res->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['product_name']) ?></td>
          <td><?= htmlspecialchars($row['retailer_name']) ?></td>
          <td><?= (int)$row['quantity'] ?></td>
          <td><?= $row['order_date'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
