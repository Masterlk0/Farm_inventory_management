<?php include '../partials/header.php'; ?>

<?php
session_start();
require_once '../functions/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Dummy data (replace with real queries)
$totalAnimals = 120;
$totalCrops = 45;
$lowStockAlerts = 3;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Farm Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 220px;
            background-color: #28a745;
            color: white;
            padding: 20px 15px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 15px 0;
        }
        .sidebar a:hover {
            text-decoration: underline;
        }
        .main {
            flex: 1;
            padding: 30px;
            background-color: #f4f4f4;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4>Farm Panel</h4>
    <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
    <hr>
    <a href="dashboard.php">Dashboard</a>
    <a href="inventory.php">Inventory</a>
    <a href="animals.php">Animals</a>
    <a href="crops.php">Crops</a>
    <a href="reports.php">Reports</a>
    <a href="settings.php">Settings</a>
    <hr>
    <a href="../logout.php" class="text-warning">Logout</a>
</div>

<!-- Main Content -->
<div class="main">
    <h2>Dashboard Overview</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Animals</h5>
                    <p class="card-text fs-4"><?= $totalAnimals ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-info">
                <div class="card-body">
                    <h5 class="card-title">Total Crops</h5>
                    <p class="card-text fs-4"><?= $totalCrops ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Low Stock Alerts</h5>
                    <p class="card-text fs-4"><?= $lowStockAlerts ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="add_item.php" class="btn btn-primary">Add New Item</a>
        <a href="reports.php" class="btn btn-secondary">Generate Report</a>
    </div>
</div>

</body>
</html>
