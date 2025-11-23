<?php
// order.php
require 'config.php';
require_login();

$msg = '';
$err = '';

// handle POST (place order)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $product_id = (int)($_POST['product_id'] ?? 0);
  $retailer_id = (int)($_POST['retailer_id'] ?? 0);
  $qty = (int)($_POST['quantity'] ?? 0);

  if ($product_id <= 0 || $retailer_id <= 0 || $qty <= 0) {
    $err = 'Invalid input.';
  } else {
    $mysqli->begin_transaction();

    try {
      // lock the product row
      $sel = $mysqli->prepare("SELECT quantity, threshold, restock_amount FROM products WHERE id = ? FOR UPDATE");
      $sel->bind_param('i', $product_id);
      $sel->execute();
      $sel->bind_result($available, $threshold, $restock_amount);
      if (!$sel->fetch()) {
        throw new Exception('Product not found.');
      }
      $sel->close();

      if ($available < $qty) {
        throw new Exception('Not enough stock. Available: ' . (int)$available);
      }

      // calculate new quantity
      $new_qty = $available - $qty;
      $update_last_restock = false;

      // restock if new quantity <= threshold
      if ($new_qty <= $threshold) {
        $new_qty += $restock_amount;
        $update_last_restock = true;
      }

      // update product quantity (and last_restock if applicable)
      if ($update_last_restock) {
        $upd = $mysqli->prepare("UPDATE products SET quantity = ?, last_restock = NOW() WHERE id = ?");
      } else {
        $upd = $mysqli->prepare("UPDATE products SET quantity = ? WHERE id = ?");
      }
      $upd->bind_param('ii', $new_qty, $product_id);
      if (!$upd->execute()) throw new Exception('Failed to update stock.');
      $upd->close();

      // insert order record
      $ins = $mysqli->prepare("INSERT INTO orders (product_id, retailer_id, quantity, order_date) VALUES (?, ?, ?, NOW())");
      $ins->bind_param('iii', $product_id, $retailer_id, $qty);
      if (!$ins->execute()) throw new Exception('Failed to record order.');
      $ins->close();

      $mysqli->commit();
      $msg = 'Order placed and stock updated.';
    } catch (Exception $e) {
      $mysqli->rollback();
      $err = $e->getMessage();
    }
  }
}

// fetch products and retailers for dropdowns
$products = $mysqli->query("SELECT id, name, quantity FROM products ORDER BY name ASC");
$retailers = $mysqli->query("SELECT id, name FROM retailers ORDER BY name ASC");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Place Order</title>
<link rel="stylesheet" href="assets/css/sidebar.css">
<link rel="stylesheet" href="assets/css/order.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <h2>Place Order</h2>

  <?php if($msg): ?><p class="success"><?=htmlspecialchars($msg)?></p><?php endif; ?>
  <?php if($err): ?><p class="error"><?=htmlspecialchars($err)?></p><?php endif; ?>

  <form method="post" class="order-form">
    <label>Item</label>
    <select name="product_id" required>
      <option value="">-- Select item --</option>
      <?php while($p = $products->fetch_assoc()): ?>
        <option value="<?= $p['id'] ?>">
          <?= htmlspecialchars($p['name']) ?> (Available: <?= (int)$p['quantity'] ?>)
        </option>
      <?php endwhile; ?>
    </select>

    <label>Retailer</label>
    <select name="retailer_id" required>
      <option value="">-- Select retailer --</option>
      <?php while($r = $retailers->fetch_assoc()): ?>
        <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?></option>
      <?php endwhile; ?>
    </select>

    <label>Quantity to send</label>
    <input type="number" name="quantity" min="1" required>

    <button type="submit" class="btn primary">Send Order</button>
  </form>
</div>

</body>
</html>
