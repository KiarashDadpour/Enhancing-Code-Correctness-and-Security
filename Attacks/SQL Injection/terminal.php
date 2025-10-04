<?php
require_once 'config.php';

class TerminalSystem {
    private $conn;
    private $current_user = null;
    
    public function __construct() {
        $this->initializeDatabase();
    }
    
    private function initializeDatabase() {
        $db_config = new DatabaseConfig();
        $this->conn = $db_config->connect();
        
        if (!$this->conn) {
            die("Cannot connect to database\n");
        }
    }
    
    public function run() {
        $this->clearScreen();
        $this->showLogin();
        
        if ($this->authenticate()) {
            $this->mainTerminal();
        }
    }
    
    private function clearScreen() {
        system('cls');
    }
    
    private function showLogin() {
        echo "╔═══════════════════════════════════════╗\n";
        echo "║           TERMINAL ACCESS            ║\n";
        echo "║        Authentication Required       ║\n";
        echo "╚═══════════════════════════════════════╝\n\n";
    }
    
    private function authenticate() {
        $attempts = 0;
        
        while ($attempts < 3) {
            echo "login: ";
            $username = trim(fgets(STDIN));
            echo "password: ";
            $password = trim(fgets(STDIN));
            
            $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $result = $this->conn->query($query);
            
            if ($result && $result->num_rows > 0) {
                $this->current_user = $result->fetch_assoc();
                echo "\n✅ Login successful! Welcome {$this->current_user['username']}\n";
                sleep(1);
                return true;
            }
            
            $attempts++;
            echo "❌ Login failed. Attempts remaining: " . (3 - $attempts) . "\n\n";
        }
        
        echo "🚫 Maximum login attempts exceeded.\n";
        return false;
    }
    
    private function mainTerminal() {
        $this->clearScreen();
        echo "=== SYSTEM TERMINAL ===\n";
        echo "User: {$this->current_user['username']} | Role: {$this->current_user['role']}\n";
        echo "Type 'help' for commands\n";
        echo "Type 'exit' to logout\n\n";
        
        while (true) {
            echo "{$this->current_user['username']}@server:~$ ";
            $input = trim(fgets(STDIN));
            
            if (empty($input)) continue;
            
            $this->executeCommand($input);
            
            if ($input === 'exit' || $input === 'logout') {
                echo "Logging out...\n";
                break;
            }
        }
    }
    
    private function executeCommand($command) {
        $parts = explode(' ', $command);
        $cmd = strtolower($parts[0]);
        $param = isset($parts[1]) ? $parts[1] : '';
        
        switch ($cmd) {
            case 'help':
                $this->showHelp();
                break;
                
            case 'whoami':
                echo "User: {$this->current_user['username']} | Role: {$this->current_user['role']}\n";
                break;
                
            case 'users':
                $this->listUsers();
                break;
                
            case 'search':
                $this->searchUser($param);
                break;
                
            case 'pwd':
                echo "/home/{$this->current_user['username']}\n";
                break;
                
            case 'ls':
                $this->listFiles();
                break;
                
            case 'clear':
                $this->clearScreen();
                break;
                
            case 'date':
                echo date('Y-m-d H:i:s') . "\n";
                break;
                
            case 'echo':
                echo implode(' ', array_slice($parts, 1)) . "\n";
                break;
                
            case 'sql':
                $this->executeRawSQL(implode(' ', array_slice($parts, 1)));
                break;
                
            default:
                echo "Command not found: $command\n";
        }
    }
    
    private function showHelp() {
        echo "\nAvailable Commands:\n";
        echo "-------------------\n";
        echo "help      - Show this help\n";
        echo "whoami    - Show current user\n";
        echo "users     - List all users\n";
        echo "search    - Search users [SQLi Vulnerable]\n";
        echo "pwd       - Show current directory\n";
        echo "ls        - List files\n";
        echo "clear     - Clear screen\n";
        echo "date      - Show date/time\n";
        echo "echo      - Echo text\n";
        echo "sql       - Execute SQL query [DANGEROUS]\n";
        echo "exit      - Logout\n\n";
        
        echo "SQL Injection Examples:\n";
        echo "----------------------\n";
        echo "Login: admin' -- \n";
        echo "Search: ' OR 1=1 -- \n";
        echo "Search: ' UNION SELECT username,password,role FROM users -- \n\n";
    }
    
    private function listUsers() {
        $result = $this->conn->query("SELECT username, role, created_at FROM users");
        
        if ($result && $result->num_rows > 0) {
            echo "\nSystem Users:\n";
            echo str_repeat("-", 50) . "\n";
            while ($row = $result->fetch_assoc()) {
                echo "{$row['username']} | {$row['role']} | Created: {$row['created_at']}\n";
            }
            echo "Total: {$result->num_rows} users\n";
        } else {
            echo "No users found\n";
        }
    }
    
    private function searchUser($keyword) {
        if (empty($keyword)) {
            echo "Usage: search <keyword>\n";
            return;
        }
        
        $query = "SELECT username, password, role FROM users WHERE username LIKE '%$keyword%'";
        $result = $this->conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            echo "\nSearch Results:\n";
            echo str_repeat("-", 60) . "\n";
            while ($row = $result->fetch_assoc()) {
                echo "User: {$row['username']} | Password: {$row['password']} | Role: {$row['role']}\n";
            }
            echo "Found: {$result->num_rows} result(s)\n";
        } else {
            echo "No results found\n";
        }
    }
    
    private function listFiles() {
        $files = [
            "documents/",
            "downloads/", 
            "desktop/",
            "system.log",
            "config.ini",
            "readme.txt"
        ];
        
        echo implode("  ", $files) . "\n";
    }
    
    private function executeRawSQL($query) {
        if (empty($query)) {
            echo "Usage: sql <query>\n";
            return;
        }
        
        $result = $this->conn->query($query);
        
        if ($result === TRUE) {
            echo "Query executed successfully\n";
        } else if ($result && $result->num_rows > 0) {
            echo "\nQuery Results:\n";
            echo str_repeat("-", 50) . "\n";
            
            $fields = $result->fetch_fields();
            foreach ($fields as $field) {
                echo $field->name . " | ";
            }
            echo "\n" . str_repeat("-", 50) . "\n";
            
            // Get data
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                echo implode(" | ", $row) . "\n";
            }
            echo "Total rows: {$result->num_rows}\n";
        } else {
            echo "No results or error in query\n";
        }
    }
}

try {
    $terminal = new TerminalSystem();
    $terminal->run();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
