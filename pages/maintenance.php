<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/util.php';

include '../partials/header.php';
include '../partials/sidebar.php';

// Fetch maintenance records from the database
$sql = "SELECT * FROM maintenance ORDER BY last_service DESC";
$result = $conn->query($sql);
?>

<div class="content">
    <h2>Equipment Maintenance Log</h2>
    
    <a href="add_maintenance.php" class="btn btn-success" style="margin-bottom: 10px;">➕ Add Service Record</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Equipment Name</th>
                <th>Last Service</th>
                <th>Next Due</th>
                <th>Service Type</th>
                <th>Cost</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['equipment_name']) ?></td>
                        <td><?= formatDate($row['last_service']) ?> (<?= htmlspecialchars($row['hours_last']) ?> hrs)</td>
                        <td><?= formatDate($row['next_service']) ?> or <?= htmlspecialchars($row['hours_next']) ?> hrs</td>
                        <td><?= htmlspecialchars($row['service_type']) ?></td>
                        <td>$<?= htmlspecialchars($row['cost']) ?></td>
                        <td><?= htmlspecialchars($row['notes']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">No maintenance records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../partials/footer.php'; ?>
