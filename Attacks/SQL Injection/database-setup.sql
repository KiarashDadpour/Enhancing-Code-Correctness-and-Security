CREATE DATABASE IF NOT EXISTS user_management;
USE user_management;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    role VARCHAR(20) DEFAULT 'User',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    full_name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2)
);

CREATE TABLE system_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, role) VALUES 
('admin', 'secret123', 'Administrator'),
('john_doe', 'password123', 'User'),
('jane_smith', 'test456', 'Manager');

INSERT INTO user_profiles (user_id, full_name, email, phone) VALUES 
(1, 'System Administrator', 'admin@company.com', '+1-555-0101'),
(2, 'John Doe', 'john.doe@email.com', '+1-555-0102'),
(3, 'Jane Smith', 'jane.smith@email.com', '+1-555-0103');

INSERT INTO products (name, description, price) VALUES 
('Laptop', 'High-performance business laptop', 1299.99),
('Mouse', 'Wireless optical mouse', 29.99),
('Keyboard', 'Mechanical gaming keyboard', 89.99);

INSERT INTO system_logs (message) VALUES 
('System boot completed successfully'),
('User admin logged in from 192.168.1.100'),
('Database backup initiated'),
('Security scan completed - no threats found');
