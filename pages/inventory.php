<?php include '../partials/header.php'; ?>

<?php
session_start();
require_once '../functions/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Handle deletion if requested (with simple confirmation)
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Delete item by id
    $stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to avoid resubmission
    header("Location: inventory.php");
    exit();
}

// Filters and search
$typeFilter = $_GET['type'] ?? '';
$locationFilter = $_GET['location'] ?? '';
$search = trim($_GET['search'] ?? '');

// Build SQL with filters
$sql = "SELECT * FROM inventory WHERE 1=1 ";
$params = [];
$paramTypes = "";

if ($typeFilter !== '' && in_array($typeFilter, ['Animal', 'Crop', 'Equipment'])) {
    $sql .= " AND type = ? ";
    $params[] = $typeFilter;
    $paramTypes .= "s";
}

if ($locationFilter !== '') {
    $sql .= " AND location LIKE ? ";
    $params[] = "%" . $locationFilter . "%";
    $paramTypes .= "s";
}

if ($search !== '') {
    $sql .= " AND (name LIKE ? OR notes LIKE ?) ";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $paramTypes .= "ss";
}

$sql .= " ORDER BY id DESC";

// Prepare and execute
$stmt = $conn->prepare($sql);

if ($paramTypes) {
    $stmt->bind_param($paramTypes, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Inventory | Farm Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Inventory List</h2>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" placeholder="Search by name or notes" class="form-control" value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-md-3">
            <select name="type" class="form-select">
                <option value="">All Types</option>
                <option value="Animal" <?= $typeFilter === 'Animal' ? 'selected' : '' ?>>Animal</option>
                <option value="Crop" <?= $typeFilter === 'Crop' ? 'selected' : '' ?>>Crop</option>
                <option value="Equipment" <?= $typeFilter === 'Equipment' ? 'selected' : '' ?>>Equipment</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="location" placeholder="Filter by location" class="form-control" value="<?= htmlspecialchars($locationFilter) ?>">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="inventory.php" class="btn btn-secondary ms-2">Reset</a>
        </div>
    </form>

    <a href="add_item.php" class="btn btn-success mb-3">Add New Item</a>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Location</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows === 0): ?>
            <tr>
                <td colspan="7" class="text-center">No items found.</td>
            </tr>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['type']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td>
                        <?php
                        if ($row['type'] === 'Animal') {
                            echo htmlspecialchars($row['health_status'] ?: '-');
                        } elseif ($row['type'] === 'Crop') {
                            echo htmlspecialchars($row['growth_stage'] ?: '-');
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="edit_item.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="inventory.php?delete_id=<?= $row['id'] ?>" 
                           onclick="return confirm('Are you sure you want to delete this item?');" 
                           class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
