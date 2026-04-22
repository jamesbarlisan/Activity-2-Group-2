<?php
/**
 * Admin Authentication Check
 * Include this file in admin pages to protect them
 */

session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Check session timeout
if (isset($_SESSION['login_time'])) {
    $elapsed = time() - $_SESSION['login_time'];
    if ($elapsed > ADMIN_SESSION_TIMEOUT) {
        session_unset();
        session_destroy();
        header('Location: admin_login.php?timeout=1');
        exit;
    }
    // Update login time on each request
    $_SESSION['login_time'] = time();
}






