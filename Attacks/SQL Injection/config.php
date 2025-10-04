<?php
class DatabaseConfig {
    private $host = '127.0.0.1';
    private $port = 3307;
    private $user = 'root';
    private $pass = '';
    private $db_name = 'terminal_db';
    
    public function connect() {
        // First connect without database
        $conn = new mysqli($this->host, $this->user, $this->pass, '', $this->port);
        
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }
        
        // Initialize database
        $this->initializeDatabase($conn);
        
        // Reconnect with database selected
        $conn->close();
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->db_name, $this->port);
        
        return $conn;
    }
    
    private function initializeDatabase($conn) {
        // Create database
        $conn->query("CREATE DATABASE IF NOT EXISTS {$this->db_name}");
        $conn->select_db($this->db_name);
        
        // Create users table
        $conn->query("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE,
            password VARCHAR(100),
            role VARCHAR(20),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Insert default users
        $conn->query("INSERT IGNORE INTO users (username, password, role) VALUES 
            ('admin', 'admin123', 'administrator'),
            ('root', 'toor', 'admin'),
            ('user', 'pass123', 'user'),
            ('test', 'test', 'user')");
    }
}
?>
