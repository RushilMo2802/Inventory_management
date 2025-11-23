<?php
require 'config.php';
require_login();

// --- Handle Update Form Submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $id = intval($_POST['id']);
    $name = $mysqli->real_escape_string($_POST['name']);
    $quantity = intval($_POST['quantity']);
    $threshold = intval($_POST['threshold']);
    $restock_amount = intval($_POST['restock_amount']);

    $mysqli->query("UPDATE products SET 
        name='$name', 
        quantity=$quantity, 
        threshold=$threshold, 
        restock_amount=$restock_amount 
        WHERE id=$id
    ");

    header("Location: inventory.php");
    exit;
}

// --- Fetch All Products ---
$items = $mysqli->query("SELECT id, name, quantity, threshold, restock_amount, last_restock FROM products ORDER BY id DESC");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Inventory</title>
<link rel="stylesheet" href="assets/css/sidebar.css">
<link rel="stylesheet" href="assets/css/inventory.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <h2>Inventory List</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Threshold</th>
        <th>Restock Amount</th>
        <th>Last Restock</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($items && $items->num_rows > 0): ?>
        <?php while($row = $items->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['threshold'] ?></td>
            <td><?= $row['restock_amount'] ?></td>
            <td><?= $row['last_restock'] ?: '—' ?></td>
            <td>
              <button class="btn-edit" 
                onclick="openEditModal(
                  '<?= $row['id'] ?>',
                  '<?= htmlspecialchars($row['name'], ENT_QUOTES) ?>',
                  '<?= $row['quantity'] ?>',
                  '<?= $row['threshold'] ?>',
                  '<?= $row['restock_amount'] ?>'
                )">Edit</button>
              <a href="delete.php?id=<?= $row['id'] ?>&type=product" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>

          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="7">No products found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Popup Edit Modal -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeEditModal()">&times;</span>
    <h3>Edit Product</h3>
    <form method="post">
      <input type="hidden" name="id" id="edit-id">
      <label>Name:</label>
      <input type="text" name="name" id="edit-name" required>
      <label>Quantity:</label>
      <input type="number" name="quantity" id="edit-quantity" required>
      <label>Threshold:</label>
      <input type="number" name="threshold" id="edit-threshold" required>
      <label>Restock Amount:</label>
      <input type="number" name="restock_amount" id="edit-restock" required>
      <button type="submit" name="update_product">Save Changes</button>
    </form>
  </div>
</div>

<script>
// Open modal and fill data
function openEditModal(id, name, quantity, threshold, restock) {
  document.getElementById('edit-id').value = id;
  document.getElementById('edit-name').value = name;
  document.getElementById('edit-quantity').value = quantity;
  document.getElementById('edit-threshold').value = threshold;
  document.getElementById('edit-restock').value = restock;
  document.getElementById('editModal').style.display = 'flex';
}

// Close modal
function closeEditModal() {
  document.getElementById('editModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
  const modal = document.getElementById('editModal');
  if (event.target === modal) {
    modal.style.display = 'none';
  }
};
</script>

</body>
</html>

 