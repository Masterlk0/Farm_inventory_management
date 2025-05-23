<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/util.php';

include '../partials/header.php';
include '../partials/sidebar.php';

// Fetch inventory value summary
$summary = [
    'Animals'   => ['count' => 0, 'value' => 0],
    'Crops'     => ['count' => 0, 'value' => 0],
    'Equipment' => ['count' => 0, 'value' => 0],
];

// Sample SQL assumes there’s a value column in each relevant table
$categories = ['animals', 'crops', 'equipment'];
foreach ($categories as $category) {
    $sql = "SELECT COUNT(*) AS count, SUM(value) AS total_value FROM $category";
    $res = $conn->query($sql);
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $key = ucfirst($category);
        $summary[$key]['count'] = $row['count'] ?? 0;
        $summary[$key]['value'] = $row['total_value'] ?? 0;
    }
}
?>

<div class="content">
    <h2>Inventory Reports</h2>

    <form method="GET" class="mb-4">
        <label for="date_range">Date Range:</label>
        <select name="range" id="date_range">
            <option value="this_month">This Month</option>
            <option value="last_month">Last Month</option>
            <option value="custom">Custom</option>
        </select>
        <input type="date" name="start" placeholder="Start Date">
        <input type="date" name="end" placeholder="End Date">
        <button type="submit">Generate</button>
    </form>

    <h4>Inventory Value Summary</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Category</th>
                <th>Count</th>
                <th>Total Value (USD)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($summary as $category => $data): ?>
                <tr>
                    <td><?= $category ?></td>
                    <td><?= $data['count'] ?></td>
                    <td>$<?= number_format($data['value'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="report-export mt-3">
        <a href="export_report_pdf.php" class="btn btn-danger">📄 Export to PDF</a>
        <a href="export_report_excel.php" class="btn btn-success">📊 Export to Excel</a>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
