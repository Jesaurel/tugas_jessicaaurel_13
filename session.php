<?php
// Start the session (use this on every page that needs session functionality)
session_start();

// Check if the session has expired or if the user is logged out
function checkSessionTimeout() {
    // If there's no user_id in the session, redirect to login
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }
    
    // If the session has expired (based on the timeout setting), log the user out
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > SESSION_TIMEOUT) {
        logout();
    }

    // Update last activity timestamp
    $_SESSION['last_activity'] = time();
}

// Log the user out by clearing session data and redirecting to login
function logout() {
    session_unset();  // Unset all session variables
    session_destroy();  // Destroy the session
    header('Location: ' . BASE_URL . 'login.php');
    exit;
}

// Check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Get the user's role (admin, regular user, etc.)
function getUserRole() {
    return isset($_SESSION['role']) ? $_SESSION['role'] : null;
}

?>