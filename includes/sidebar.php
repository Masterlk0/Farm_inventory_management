<style>
.sidebar {
    width: 220px;
    background-color: #2e7d32;
    color: #fff;
    position: fixed;
    top: 60px; /* adjust if your header is different height */
    bottom: 0;
    left: 0;
    padding-top: 20px;
    padding-left: 10px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.sidebar a {
    display: block;
    color: white;
    padding: 12px 16px;
    text-decoration: none;
    margin-bottom: 5px;
    border-radius: 4px;
}

.sidebar a:hover {
    background-color: #388e3c;
}

.content {
    margin-left: 240px; /* width of sidebar + some padding */
    padding: 20px;
}
</style>

<div class="sidebar">
    <h3 style="margin-left: 16px;">Menu</h3>
    <a href="/pages/dashboard.php"> Dashboard</a>
    <a href="/pages/inventory.php"> Inventory</a>
    <a href="/pages/add_item.php">Add Item</a>
    <a href="/pages/reports.php">Reports</a>
    <a href="/pages/settings.php"> Settings</a>
    <a href="/logout.php">Logout</a>
</div>
