-- MySQL initialization script

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS checkin_tool;

-- Create user if not exists
CREATE USER IF NOT EXISTS 'checkin_user'@'%' IDENTIFIED BY 'checkin_password';

-- Grant privileges
GRANT ALL PRIVILEGES ON checkin_tool.* TO 'checkin_user'@'%';

-- Flush privileges
FLUSH PRIVILEGES;

-- Use the database
USE checkin_tool;

-- Create tables
CREATE TABLE IF NOT EXISTS `guests` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `register_id` VARCHAR(50) UNIQUE NOT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `age` INT,
  `category` ENUM('standard', 'vip', 'family', 'group', 'other') DEFAULT 'standard',
  `arrival_day` DATE NOT NULL,
  `checked_in` BOOLEAN DEFAULT FALSE,
  `checkin_date` DATETIME NULL,
  `note` TEXT,
  `signature_id` VARCHAR(255) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  INDEX idx_category (category),
  INDEX idx_arrival_day (arrival_day),
  INDEX idx_checked_in (checked_in),
  INDEX idx_register_id (register_id),
  FULLTEXT INDEX idx_full_name (full_name)
);

CREATE TABLE IF NOT EXISTS `connections` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `guest_id` INT NOT NULL,
  `connected_guest_id` INT NOT NULL,
  `connection_type` ENUM('family', 'friend', 'colleague', 'group', 'other') DEFAULT 'group',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (guest_id) REFERENCES guests(id) ON DELETE CASCADE,
  FOREIGN KEY (connected_guest_id) REFERENCES guests(id) ON DELETE CASCADE,
  
  UNIQUE KEY unique_connection (guest_id, connected_guest_id),
  INDEX idx_guest_id (guest_id),
  INDEX idx_connected_guest_id (connected_guest_id)
);

-- Insert sample data if empty
INSERT INTO `guests` (`register_id`, `full_name`, `age`, `category`, `arrival_day`, `checked_in`, `note`)
SELECT 'GUEST-001', 'John Doe', 35, 'standard', '2024-01-15', FALSE, 'VIP customer' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM guests);

INSERT INTO `guests` (`register_id`, `full_name`, `age`, `category`, `arrival_day`, `checked_in`, `note`)
SELECT 'GUEST-002', 'Jane Smith', 28, 'vip', '2024-01-15', FALSE, 'Early arrival' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM guests WHERE register_id = 'GUEST-002');

INSERT INTO `guests` (`register_id`, `full_name`, `age`, `category`, `arrival_day`, `checked_in`, `note`)
SELECT 'GUEST-003', 'Bob Johnson', 42, 'family', '2024-01-16', FALSE, 'Family of 4' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM guests WHERE register_id = 'GUEST-003');

INSERT INTO `guests` (`register_id`, `full_name`, `age`, `category`, `arrival_day`, `checked_in`, `note`)
SELECT 'GUEST-004', 'Alice Brown', 31, 'group', '2024-01-16', FALSE, 'Conference attendee' FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM guests WHERE register_id = 'GUEST-004');

INSERT INTO `guests` (`register_id`, `full_name`, `age`, `category`, `arrival_day`, `checked_in`, `note`)
SELECT 'GUEST-005', 'Charlie Wilson', 25, 'standard', '2024-01-17', FALSE, NULL FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM guests WHERE register_id = 'GUEST-005');
