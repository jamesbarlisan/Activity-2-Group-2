<?php
require_once 'config.php';

class Database {
    private $conn;
    

    public function __construct() {
        $this->connect();
    }
    
 
    private function connect() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        
        // Set charset to utf8mb4 for proper character encoding
        $this->conn->set_charset("utf8mb4");
    }
    
    /**
     * Get database connection
     * @return mysqli
     */
    public function getConnection() {
        return $this->conn;
    }
    
    /**
     * Close database connection
     */
    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
    
    /**
     * Escape string to prevent SQL injection
     * @param string $string
     * @return string
     */
    public function escape($string) {
        return $this->conn->real_escape_string($string);
    }
}

// Create global database instance
$db = new Database();
$conn = $db->getConnection();






