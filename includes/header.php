<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Inventory System</title>
    <link rel="stylesheet" href="/assets/css/style.css"> <!-- Your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f8fa;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: #4CAF50;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar .logo {
            font-size: 20px;
            font-weight: bold;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .main-wrapper {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">🌾 Sunny Acres Farm</div>
    <div class="nav-links">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/pages/dashboard.php">Dashboard</a>
            <a href="/pages/inventory.php">Inventory</a>
            <a href="/logout.php">Logout</a>
        <?php else: ?>
            <a href="/login.php">Login</a>
        <?php endif; ?>
    </div>
</div>

<div class="main-wrapper">
