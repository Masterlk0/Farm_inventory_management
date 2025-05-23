<?php
session_start();

// Redirect logic
if (isset($_SESSION['user_id'])) {
    header("Location: pages/dashboard.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="2;url=login.php">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Inventory System</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Optional -->
</head>
<body>
    <div style="text-align:center; margin-top: 20%;">
        <h2>Redirecting...</h2>
        <p>If you're not redirected, <a href="login.php">click here to login</a>.</p>
    </div>
</body>
</html>
