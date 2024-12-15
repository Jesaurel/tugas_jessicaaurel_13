<?php
// General configuration settings

// Start session only if it hasn't started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Other configurations remain the same

define('ADMIN_EMAIL', 'jessicaaurel283@gmail.com');
define('SITE_NAME', 'Catering Lezat');
define('BASE_URL', 'http://localhost/jessicaaurelclarista_13_catering/public/');
define('FROM_NAME', 'Catering Lezat');
define('FROM_EMAIL', 'noreply@cateringlezat.com');

// Set default timezone for the application
date_default_timezone_set('Asia/Jakarta'); // Set timezone to Jakarta (Indonesia)

// Session settings
define('SESSION_TIMEOUT', 3600); // Session timeout in seconds (1 hour)

// Security settings (no hashing needed for passwords)
define('SALT', ''); // No salt needed if passwords are stored directly

// Payment Settings (e.g., Dana integration, etc.)
define('PAYMENT_METHODS', ['cash', 'dana']); // Supported payment methods

// Define a few helper methods

/**
 * Redirect to a given URL
 *
 * @param string $url
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Check if the user is logged in
 *
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Log out the current user and destroy the session
 */
function logout() {
    session_unset();
    session_destroy();
    redirect(BASE_URL . '../login.php'); // Redirect to the login page
}

/**
 * Session timeout check
 */
function checkSessionTimeout() {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > SESSION_TIMEOUT) {
        logout();
    }
    $_SESSION['last_activity'] = time(); // Update the session timestamp
}

/**
 * Verify password (no hashing)
 *
 * @param string $password
 * @param string $storedPassword
 * @return bool
 */
function verifyPassword($password, $storedPassword) {
    return $password === $storedPassword;
}
?>