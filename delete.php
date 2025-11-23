<?php
require 'config.php';
require_login();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid or missing ID.");
}

$id = intval($_GET['id']);

// Determine the type of deletion (product or retailer)
$type = isset($_GET['type']) ? $_GET['type'] : '';

if ($type === 'product') {
    $stmt = $mysqli->prepare("DELETE FROM products WHERE id = ?");
    $redirect = "inventory.php?msg=product_deleted";
} elseif ($type === 'retailer') {
    $stmt = $mysqli->prepare("DELETE FROM retailers WHERE id = ?");
    $redirect = "retailers.php?msg=retailer_deleted";
} else {
    die("Invalid delete type.");
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: $redirect");
    exit;
} else {
    echo "Error deleting record: " . htmlspecialchars($stmt->error);
}

$stmt->close();
$mysqli->close();
?>
