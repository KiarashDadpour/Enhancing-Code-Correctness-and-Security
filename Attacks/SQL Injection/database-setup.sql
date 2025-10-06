-- Database initialization script for SQL Injection Workshop
-- Run this script in MySQL to set up the database manually

CREATE DATABASE IF NOT EXISTS terminal_db;
USE terminal_db;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50),
    price DECIMAL(10,2),
    quantity INT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- System logs table
CREATE TABLE IF NOT EXISTS system_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100),
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default users
INSERT IGNORE INTO users (username, password, role) VALUES 
('admin', 'admin123', 'administrator'),
('root', 'toor', 'admin'),
('user', 'pass123', 'user'),
('test', 'test', 'user');

-- Insert sample products
INSERT IGNORE INTO products (name, category, price, quantity, description) VALUES 
('iPhone 15 Pro', 'Electronics', 999.99, 50, 'Latest Apple smartphone'),
('Samsung Galaxy S24', 'Electronics', 899.99, 75, 'Android flagship phone'),
('MacBook Pro 16"', 'Computers', 2399.99, 25, 'Professional laptop'),
('Dell XPS 13', 'Computers', 1299.99, 40, 'Ultrabook laptop'),
('Sony WH-1000XM5', 'Audio', 349.99, 100, 'Noise cancelling headphones'),
('Apple AirPods Pro', 'Audio', 249.99, 150, 'Wireless earbuds'),
('iPad Air', 'Tablets', 599.99, 60, 'Tablet computer'),
('Samsung Tab S9', 'Tablets', 799.99, 45, 'Android tablet'),
('Nintendo Switch', 'Gaming', 299.99, 80, 'Gaming console'),
('PlayStation 5', 'Gaming', 499.99, 30, 'Next-gen console');

-- Insert sample logs
INSERT IGNORE INTO system_logs (user_id, action, details, ip_address) VALUES 
(1, 'LOGIN', 'User logged in successfully', '192.168.1.100'),
(2, 'USER_CREATE', 'Created new user account', '192.168.1.101'),
(1, 'PRODUCT_UPDATE', 'Updated product inventory', '192.168.1.100'),
(3, 'SEARCH', 'Searched for products', '192.168.1.102');
