-- Table structure for admin users
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'Hashed password',
  `email` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`),
  KEY `idx_email` (`email`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert default admin user (username: admin, password: admin123)
-- Password hash for 'admin123' using password_hash() with PASSWORD_DEFAULT
INSERT INTO `admin_users` (`username`, `password`, `email`, `full_name`, `is_active`) 
VALUES ('admin', '$2y$10$ab.AA566zVq2Vf4wd4rUxua2gyZhTn/A4SpvfO.0LsSAigRsM8x6G', 'admin@example.com', 'Administrator', 1)
ON DUPLICATE KEY UPDATE `username`=`username`;

-- Alternative: If you need to update the password for existing admin user, run:
-- UPDATE `admin_users` SET `password` = '$2y$10$ab.AA566zVq2Vf4wd4rUxua2gyZhTn/A4SpvfO.0LsSAigRsM8x6G' WHERE `username` = 'admin';

