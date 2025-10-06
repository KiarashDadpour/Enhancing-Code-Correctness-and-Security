<?php
class DatabaseConfig {
    private $host = '127.0.0.1';
    private $port = 3307;
    private $user = 'root';
    private $pass = '';
    private $db_name = 'terminal_db';
    
    public function connect() {
        // Connect directly to the database (assumes it's already created)
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->db_name, $this->port);
        
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error . "\n" .
                "Please make sure:\n" .
                "1. MySQL is running on port 3307\n" .
                "2. Database 'terminal_db' exists\n" .
                "3. You have run database.sql script\n");
        }
        
        return $conn;
    }
}
?>
