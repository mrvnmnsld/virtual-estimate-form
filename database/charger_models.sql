-- Table structure for charger models
CREATE TABLE IF NOT EXISTS `charger_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(255) NOT NULL COMMENT 'Name of the charger model',
  `brand` varchar(100) DEFAULT NULL COMMENT 'Brand/manufacturer name',
  `is_active` tinyint(1) DEFAULT 1 COMMENT 'Whether the model is active (1) or inactive (0)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_model_name` (`model_name`),
  KEY `idx_brand` (`brand`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert popular EV charger models
INSERT INTO `charger_models` (`model_name`, `brand`, `is_active`) VALUES
('Wall Connector', 'Tesla', 1),
('Home Flex', 'ChargePoint', 1),
('JuiceBox 40', 'Enel X Way', 1),
('JuiceBox 32', 'Enel X Way', 1),
('ChargePoint Home', 'ChargePoint', 1),
('Grizzl-E Classic', 'United Chargers', 1),
('Grizzl-E Duo', 'United Chargers', 1),
('ClipperCreek HCS-40', 'ClipperCreek', 1),
('ClipperCreek HCS-50', 'ClipperCreek', 1),
('ChargePoint Express 250', 'ChargePoint', 1),
('Wallbox Pulsar Plus', 'Wallbox', 1),
('Wallbox Quasar', 'Wallbox', 1),
('Siemens VersiCharge', 'Siemens', 1),
('Siemens US2', 'Siemens', 1),
('ABB Terra AC', 'ABB', 1),
('Flo Home X5', 'Flo', 1),
('Flo Home G5', 'Flo', 1),
('Emporia EV Charger', 'Emporia', 1),
('Autel MaxiCharger', 'Autel', 1),
('Mustart Level 2', 'Mustart', 1),
('Lectron Level 2', 'Lectron', 1),
('Blink HQ 150', 'Blink', 1),
('Blink HQ 200', 'Blink', 1),
('Other', 'Various', 1)
ON DUPLICATE KEY UPDATE `model_name` = VALUES(`model_name`);
