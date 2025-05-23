<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
include '../partials/header.php';
include '../partials/sidebar.php';

// Fetch all users
$result = $conn->query("SELECT * FROM users");
?>

<div class="content">
    <h2>User Management</h2>

    <a href="add_user.php" class="btn btn-success">➕ Add User</a>
    <br><br>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th><th>Email</th><th>Role</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <!-- Optional delete feature -->
                        <!-- <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a> -->
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../partials/footer.php'; ?>
