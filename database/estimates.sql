-- Table structure for estimates
CREATE TABLE IF NOT EXISTS `estimates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estimate_number` varchar(50) NOT NULL COMMENT 'Unique estimate/ticket number',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `project_type` varchar(50) NOT NULL,
  `project_description` text DEFAULT NULL,
  `timeline` varchar(50) DEFAULT NULL,
  `additional_requirements` text DEFAULT NULL,
  `charger_model_id` int(11) DEFAULT NULL COMMENT 'Foreign key to charger_models table',
  `charger_model_name` varchar(255) DEFAULT NULL COMMENT 'Stored for reference',
  `duke_rebate` enum('yes','no') DEFAULT NULL,
  `renting_home` enum('yes','no') DEFAULT NULL,
  `duke_customer` enum('yes','no') DEFAULT NULL,
  `ev_registered` enum('yes','no') DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending' COMMENT 'pending, reviewed, approved, rejected',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_estimate_number` (`estimate_number`),
  KEY `idx_email` (`email`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_charger_model_id` (`charger_model_id`),
  CONSTRAINT `fk_charger_model` FOREIGN KEY (`charger_model_id`) REFERENCES `charger_models` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for estimate attachments
CREATE TABLE IF NOT EXISTS `estimate_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estimate_id` int(11) NOT NULL COMMENT 'Foreign key to estimates table',
  `category` varchar(50) NOT NULL COMMENT 'electrical-panel, installation-area, charger-location',
  `file_name` varchar(255) NOT NULL,
  `file_path` text NOT NULL COMMENT 'Path to uploaded file',
  `file_size` bigint(20) DEFAULT NULL COMMENT 'File size in bytes',
  `file_type` varchar(100) DEFAULT NULL COMMENT 'MIME type',
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_estimate_id` (`estimate_id`),
  KEY `idx_category` (`category`),
  CONSTRAINT `fk_estimate_attachment` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
