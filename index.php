<?php
// index.php – main entry point
require_once 'config.php';

// If the user is logged in, go to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
} else {
    // Otherwise, go to login page
    header("Location: login.php");
    exit();
}
?>
