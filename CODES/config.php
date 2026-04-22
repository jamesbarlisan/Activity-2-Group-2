<?php
/**
 * Configuration File
 * Database connection settings for the chatbot system
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '1234');
define('DB_NAME', 'chatbot_db');

// Session configuration
define('SESSION_NAME', 'chatbot_admin_session');
define('SESSION_LIFETIME', 3600); // 1 hour

// Admin session timeout (in seconds)
define('ADMIN_SESSION_TIMEOUT', 3600); // 1 hour

// Default timezone
date_default_timezone_set('UTC');

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Google Gemini API Configuration
define('GEMINI_API_KEY', 'AIzaSyAx4mdws_d0-3ZCaumtJqZw8TFrVD1hDIY');
// Using gemini-2.5-flash (fast and efficient) - tested and working
// Alternative models available: gemini-2.5-pro (more capable), gemini-2.0-flash (older version)
define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent');
define('GEMINI_ENABLED', true); // Set to false to disable Gemini fallback
define('GEMINI_DEBUG', true); // Set to true to log detailed error messages




