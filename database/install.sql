-- Create DB
CREATE DATABASE IF NOT EXISTS elevator_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE elevator_system;

-- Drop existing (safe to re-run)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS feedback;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS service_requests;
DROP TABLE IF EXISTS technicians;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS contact_messages;
SET FOREIGN_KEY_CHECKS = 1;

-- Customers
CREATE TABLE customers (
  c_id INT AUTO_INCREMENT PRIMARY KEY,
  c_name VARCHAR(120) NOT NULL,
  email VARCHAR(120) UNIQUE NOT NULL,
  phone VARCHAR(30) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admins
CREATE TABLE admins (
  a_id INT AUTO_INCREMENT PRIMARY KEY,
  a_name VARCHAR(120) NOT NULL,
  email VARCHAR(120) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Technicians
CREATE TABLE technicians (
  t_id INT AUTO_INCREMENT PRIMARY KEY,
  t_name VARCHAR(120) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  email VARCHAR(120) UNIQUE,
  specialty VARCHAR(120),
  location VARCHAR(120),
  available TINYINT(1) DEFAULT 1,
  password VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Service Requests
CREATE TABLE service_requests (
  r_id INT AUTO_INCREMENT PRIMARY KEY,
  c_id INT NOT NULL,
  t_id INT NULL,
  r_type ENUM('Installation','Repair','Maintenance') NOT NULL,
  status ENUM('Pending','Assigned','Ongoing','Completed','Cancelled') DEFAULT 'Pending',
  description TEXT,
  location VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (c_id) REFERENCES customers(c_id) ON DELETE CASCADE,
  FOREIGN KEY (t_id) REFERENCES technicians(t_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Payments
CREATE TABLE payments (
  p_id INT AUTO_INCREMENT PRIMARY KEY,
  c_id INT NOT NULL,
  r_id INT NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  status ENUM('Pending','Paid','Failed','Refunded') DEFAULT 'Pending',
  method ENUM('Cash','Card','Bkash','Nagad','Rocket') DEFAULT 'Cash',
  p_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (c_id) REFERENCES customers(c_id) ON DELETE CASCADE,
  FOREIGN KEY (r_id) REFERENCES service_requests(r_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Feedback
CREATE TABLE feedback (
  f_id INT AUTO_INCREMENT PRIMARY KEY,
  c_id INT NOT NULL,
  r_id INT NOT NULL,
  rating TINYINT NOT NULL,
  comment TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (c_id) REFERENCES customers(c_id) ON DELETE CASCADE,
  FOREIGN KEY (r_id) REFERENCES service_requests(r_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Notifications (logs)
CREATE TABLE notifications (
  n_id INT AUTO_INCREMENT PRIMARY KEY,
  c_id INT,
  r_id INT,
  channel ENUM('Email','SMS','InApp') DEFAULT 'InApp',
  message VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (c_id) REFERENCES customers(c_id) ON DELETE SET NULL,
  FOREIGN KEY (r_id) REFERENCES service_requests(r_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table contact_messages
CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Seed admin (demo) - demo uses MD5 for quick login; production: use password_hash()
INSERT INTO admins (a_name, email, password)
VALUES ('Super Admin', 'admin@elevator.com', MD5('admin123'))
ON DUPLICATE KEY UPDATE email=email;

-- Seed test customer
INSERT INTO customers (c_name, email, phone, password)
VALUES ('Test Customer','customer@test.com','01700000000', MD5('123456'))
ON DUPLICATE KEY UPDATE email=email;

-- Seed technicians
INSERT INTO technicians (t_name, phone, email, specialty, location, password)
VALUES 
('Tech Hasan','01811111111','hasan@els.com','Repair','Dhaka', MD5('123456')),
('Tech Rafi','01822222222','rafi@els.com','Installation','Gazipur', MD5('123456'))
ON DUPLICATE KEY UPDATE email=email;

-- Dumping data for table `contact_messages`
INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Simanto', 's@gmail.com', 'elevator start and running problem .', '2025-09-01 01:38:01');

ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);
-- AUTO_INCREMENT for table `contact_messages`
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

