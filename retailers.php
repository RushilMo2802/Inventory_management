<?php
require 'config.php';
require_login();

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_retailer'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $stmt = $mysqli->prepare("UPDATE retailers SET name=?, phone=?, email=?, address=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $phone, $email, $address, $id);
    $stmt->execute();

    header("Location: retailers.php"); // reload page after update
    exit;
}

// Fetch all retailers
$retailers = $mysqli->query("SELECT * FROM retailers ORDER BY id ASC;");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Retailers</title>
<link rel="stylesheet" href="assets/css/sidebar.css">
<link rel="stylesheet" href="assets/css/retailers.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
  <h2>Retailers List</h2>
  
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Retailer Name</th>
        <th>Contact</th>
        <th>Email</th>
        <th>Address</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($retailers && $retailers->num_rows > 0): ?>
        <?php while($row = $retailers->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['address']) ?></td>
          <td>
            <button 
              class="btn-edit" 
              onclick="openEditPopup('<?= $row['id'] ?>','<?= htmlspecialchars($row['name']) ?>','<?= htmlspecialchars($row['phone']) ?>','<?= htmlspecialchars($row['email']) ?>','<?= htmlspecialchars($row['address']) ?>')">
              Edit
            </button>
            <a href="delete.php?id=<?= $row['id'] ?>&type=retailer" class="btn-delete" onclick="return confirm('Are you sure you want to delete this retailer?');">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="6">No retailers found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Popup Form for Editing -->
<div id="editPopup" class="popup-container">
  <div class="popup-box">
    <h3>Edit Retailer</h3>
    <form method="POST" action="">
      <input type="hidden" name="id" id="editId">
      <label>Name:</label>
      <input type="text" name="name" id="editName" required>
      <label>Phone:</label>
      <input type="text" name="phone" id="editPhone" required>
      <label>Email:</label>
      <input type="email" name="email" id="editEmail" required>
      <label>Address:</label>
      <textarea name="address" id="editAddress" required></textarea>
      <div class="popup-actions">
        <button type="submit" name="update_retailer" class="btn-edit">Save</button>
        <button type="button" class="btn-delete" onclick="closeEditPopup()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditPopup(id, name, phone, email, address) {
  document.getElementById('editId').value = id;
  document.getElementById('editName').value = name;
  document.getElementById('editPhone').value = phone;
  document.getElementById('editEmail').value = email;
  document.getElementById('editAddress').value = address;
  document.getElementById('editPopup').style.display = 'flex';
}

function closeEditPopup() {
  document.getElementById('editPopup').style.display = 'none';
}
</script>

</body>
</html>
