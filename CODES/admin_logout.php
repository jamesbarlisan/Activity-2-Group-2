<?php
/**
 * Admin Logout
 * Destroys session and redirects to login
 */

session_start();
session_unset();
session_destroy();

header('Location: admin_login.php');
exit;






