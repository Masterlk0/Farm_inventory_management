<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
include '../partials/header.php';
include '../partials/sidebar.php';

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $farm_name = trim($_POST['farm_name']);
    $units = $_POST['units'];

    $stmt = $conn->prepare("UPDATE settings SET farm_name = ?, units = ?");
    $stmt->bind_param("ss", $farm_name, $units);
    $stmt->execute();
    $message = "Settings updated successfully.";
}

// Get current settings
$settings = $conn->query("SELECT * FROM settings LIMIT 1")->fetch_assoc();
?>

<div class="content">
    <h2>Farm Settings</h2>

    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Farm Name:</label>
        <input type="text" name="farm_name" value="<?= htmlspecialchars($settings['farm_name']) ?>" required>

        <label>Measurement Units:</label>
        <select name="units">
            <option value="Imperial" <?= $settings['units'] == 'Imperial' ? 'selected' : '' ?>>Imperial (lbs/acres)</option>
            <option value="Metric" <?= $settings['units'] == 'Metric' ? 'selected' : '' ?>>Metric (kg/hectares)</option>
        </select>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>

    <hr>

    <h3>User Management</h3>
    <a href="add_user.php" class="btn btn-success">➕ Add User</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Role</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $users = $conn->query("SELECT * FROM users");
            while ($user = $users->fetch_assoc()):
            ?>
            <tr>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['role'] ?></td>
                <td><a href="edit_user.php?id=<?= $user['id'] ?>">Edit</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <hr>

    <h3>Integration Settings</h3>
    <p>Configure weather, accounting, and IoT integrations. (UI Placeholder)</p>
    <button class="btn btn-secondary">Configure Integrations</button>

    <hr>

    <h3>Backup Data</h3>
    <a href="export_all.php" class="btn btn-outline-primary">💾 Export All Data</a>
</div>

<?php include '../partials/footer.php'; ?>
