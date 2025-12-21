-- Table structure for sample images
CREATE TABLE IF NOT EXISTS `sample_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL COMMENT 'Image category: electrical_panel, installation_area, charger_location',
  `image_url` text NOT NULL COMMENT 'URL or path to the sample image',
  `is_active` tinyint(1) DEFAULT 1 COMMENT 'Whether the image is active (1) or inactive (0)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert default sample images (using local paths)
-- Note: Store relative paths (e.g., assets/img/samples/...) or full URLs
-- The controller will automatically prepend base_url() for relative paths
INSERT INTO `sample_images` (`category`, `image_url`, `is_active`) VALUES
('electrical_panel', 'assets/img/samples/electrical-panel-sample.jpg', 1),
('installation_area', 'assets/img/samples/installation-area-sample.jpg', 1),
('charger_location', 'assets/img/samples/charger-location-sample.jpg', 1)
ON DUPLICATE KEY UPDATE `image_url` = VALUES(`image_url`);
