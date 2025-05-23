-- Database creation
CREATE DATABASE IF NOT EXISTS farm_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE farm_inventory;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,  -- store hashed passwords
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('Admin', 'Worker') DEFAULT 'Worker',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inventory table
CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('Animal', 'Crop', 'Equipment') NOT NULL,
    name VARCHAR(100) NOT NULL,
    quantity VARCHAR(50) NOT NULL,
    location VARCHAR(100) DEFAULT NULL,
    health_status VARCHAR(50) DEFAULT NULL,  -- For animals
    growth_stage VARCHAR(50) DEFAULT NULL,   -- For crops
    notes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Equipment maintenance (optional)
CREATE TABLE equipment_maintenance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipment_id INT NOT NULL,
    service_date DATE NOT NULL,
    service_type VARCHAR(100),
    cost DECIMAL(10,2),
    notes TEXT,
    FOREIGN KEY (equipment_id) REFERENCES inventory(id) ON DELETE CASCADE
);

-- Insert sample admin user (password: admin123 hashed using password_hash)
INSERT INTO users (username, password, email, role) VALUES
('admin', '$2y$10$N9qo8uLOickgx2ZMRZo5e.8Zk7veNQkm2LPWOTfSxYSvN6zwp5Nxy', 'admin@farm.com', 'Admin');

-- Insert sample inventory items
INSERT INTO inventory (type, name, quantity, location, health_status, growth_stage, notes) VALUES
('Animal', 'Cow', '15', 'Barn A', 'Healthy', NULL, 'Regular milk producers'),
('Crop', 'Wheat', '200kg', 'Field 3', NULL, 'Harvested', 'Winter wheat'),
('Equipment', 'Tractor #3', '1', 'Garage', NULL, NULL, 'John Deere 5075E');
