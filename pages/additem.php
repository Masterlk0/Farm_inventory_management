<?php include '../partials/header.php'; ?>

<?php
session_start();
require_once '../functions/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $quantity = intval($_POST['quantity'] ?? 0);
    $location = $_POST['location'] ?? '';
    $health = $_POST['health'] ?? '';
    $growth_stage = $_POST['growth_stage'] ?? '';
    $notes = trim($_POST['notes'] ?? '');

    // Validation
    if ($type === '' || $name === '' || $quantity <= 0 || $location === '') {
        $error = "Please fill in all required fields with valid data.";
    } else {
        // Prepare insert query depending on type
        $stmt = $conn->prepare("INSERT INTO inventory (type, name, quantity, location, health_status, growth_stage, notes, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // health_status only for animals; growth_stage only for crops; for equipment, both NULL
        $health_db = ($type === 'Animal') ? $health : null;
        $growth_db = ($type === 'Crop') ? $growth_stage : null;

        $user_id = $_SESSION['user_id'];

        $stmt->bind_param("ssissssi", $type, $name, $quantity, $location, $health_db, $growth_db, $notes, $user_id);

        if ($stmt->execute()) {
            $success = "Item added successfully!";
        } else {
            $error = "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add Item | Farm Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script>
        function toggleFields() {
            const type = document.getElementById('type').value;
            document.getElementById('health-group').style.display = (type === 'Animal') ? 'block' : 'none';
            document.getElementById('growth-group').style.display = (type === 'Crop') ? 'block' : 'none';
        }
        window.onload = function() {
            toggleFields();
        };
    </script>
</head>
<body>
<div class="container mt-4">
    <h2>Add New Item</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="type" class="form-label">Item Type</label>
            <select id="type" name="type" class="form-select" onchange="toggleFields()" required>
                <option value="">Select Type</option>
                <option value="Animal" <?= (isset($_POST['type']) && $_POST['type'] === 'Animal') ? 'selected' : '' ?>>Animal</option>
                <option value="Crop" <?= (isset($_POST['type']) && $_POST['type'] === 'Crop') ? 'selected' : '' ?>>Crop</option>
                <option value="Equipment" <?= (isset($_POST['type']) && $_POST['type'] === 'Equipment') ? 'selected' : '' ?>>Equipment</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control" min="1" required value="<?= htmlspecialchars($_POST['quantity'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" id="location" name="location" class="form-control" required value="<?= htmlspecialchars($_POST['location'] ?? '') ?>">
        </div>

        <div class="mb-3" id="health-group" style="display:none;">
            <label for="health" class="form-label">Health Status (Animals)</label>
            <select id="health" name="health" class="form-select">
                <option value="Healthy" <?= (isset($_POST['health']) && $_POST['health'] === 'Healthy') ? 'selected' : '' ?>>Healthy</option>
                <option value="Sick" <?= (isset($_POST['health']) && $_POST['health'] === 'Sick') ? 'selected' : '' ?>>Sick</option>
                <option value="Recovering" <?= (isset($_POST['health']) && $_POST['health'] === 'Recovering') ? 'selected' : '' ?>>Recovering</option>
            </select>
        </div>

        <div class="mb-3" id="growth-group" style="display:none;">
            <label for="growth_stage" class="form-label">Growth Stage (Crops)</label>
            <select id="growth_stage" name="growth_stage" class="form-select">
                <option value="Seedling" <?= (isset($_POST['growth_stage']) && $_POST['growth_stage'] === 'Seedling') ? 'selected' : '' ?>>Seedling</option>
                <option value="Vegetative" <?= (isset($_POST['growth_stage']) && $_POST['growth_stage'] === 'Vegetative') ? 'selected' : '' ?>>Vegetative</option>
                <option value="Flowering" <?= (isset($_POST['growth_stage']) && $_POST['growth_stage'] === 'Flowering') ? 'selected' : '' ?>>Flowering</option>
                <option value="Harvest Ready" <?= (isset($_POST['growth_stage']) && $_POST['growth_stage'] === 'Harvest Ready') ? 'selected' : '' ?>>Harvest Ready</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea id="notes" name="notes" class="form-control" rows="3"><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="dashboard.php" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
</body>
</html>
