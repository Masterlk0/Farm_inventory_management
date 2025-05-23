<?php
require_once __DIR__ . '/../functions/db.php';

/**
 * Fetch inventory items from database with optional filters and search.
 * 
 * @param string $typeFilter  Filter by item type (Animal, Crop, Equipment) or empty for all
 * @param string $locationFilter Filter by location (partial match)
 * @param string $search Search term (partial match on name or notes)
 * @return array List of inventory items as associative arrays
 */
function getInventoryItems($typeFilter = '', $locationFilter = '', $search = '') {
    global $conn;

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
        $params[] = "%" . $search . "%";
        $params[] = "%" . $search . "%";
        $paramTypes .= "ss";
    }

    $sql .= " ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    if ($paramTypes) {
        $stmt->bind_param($paramTypes, ...$params);
    }
    $stmt->execute();

    $result = $stmt->get_result();
    $items = [];

    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    $stmt->close();
    return $items;
}

/**
 * Delete an inventory item by ID.
 * 
 * @param int $itemId
 * @return bool True on success, false on failure
 */
function deleteInventoryItem($itemId) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
    if (!$stmt) return false;

    $stmt->bind_param("i", $itemId);
    $success = $stmt->execute();

    $stmt->close();

    return $success;
}
