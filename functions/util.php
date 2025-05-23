<?php
// Sanitize input data to prevent XSS and SQL Injection
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Format dates into a readable form (e.g., May 23, 2025)
function formatDate($dateStr) {
    return date("F j, Y", strtotime($dateStr));
}

// Check if a form field is empty and return a message (useful for validation)
function isEmpty($field, $message = "This field is required.") {
    return empty(trim($field)) ? $message : "";
}

// Redirect with a session-based flash message
function redirectWithMessage($url, $message, $type = 'success') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
    header("Location: $url");
    exit();
}

// Display a flash message if set
function displayFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $type = $_SESSION['flash_type'] ?? 'info';
        $message = $_SESSION['flash_message'];
        echo "<div class='alert alert-$type'>$message</div>";
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
    }
}
?>
