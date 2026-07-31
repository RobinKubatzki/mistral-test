-- Checkin-Tool Database Schema

-- Create guests table
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

-- Create connections table
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

-- Insert some sample data
INSERT INTO `guests` (`register_id`, `full_name`, `age`, `category`, `arrival_day`, `checked_in`, `note`) VALUES
('GUEST-001', 'John Doe', 35, 'standard', '2024-01-15', FALSE, 'VIP customer'),
('GUEST-002', 'Jane Smith', 28, 'vip', '2024-01-15', FALSE, 'Early arrival'),
('GUEST-003', 'Bob Johnson', 42, 'family', '2024-01-16', FALSE, 'Family of 4'),
('GUEST-004', 'Alice Brown', 31, 'group', '2024-01-16', FALSE, 'Conference attendee'),
('GUEST-005', 'Charlie Wilson', 25, 'standard', '2024-01-17', FALSE, NULL),
('GUEST-006', 'Diana Miller', 45, 'vip', '2024-01-17', TRUE, 'Checked in early'),
('GUEST-007', 'Ethan Davis', 38, 'family', '2024-01-18', FALSE, 'With children'),
('GUEST-008', 'Fiona Garcia', 29, 'standard', '2024-01-18', TRUE, NULL),
('GUEST-009', 'George Martinez', 50, 'group', '2024-01-19', FALSE, 'Business group'),
('GUEST-010', 'Hannah Robinson', 33, 'other', '2024-01-19', FALSE, 'Special requirements');
