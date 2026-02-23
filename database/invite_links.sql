-- Table structure for invite links
CREATE TABLE IF NOT EXISTS `invite_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL COMMENT 'Unique token for the invite link',
  `created_by` int(11) NOT NULL COMMENT 'Admin user ID who created the link',
  `is_used` tinyint(1) DEFAULT 0 COMMENT 'Whether the link has been used',
  `used_at` timestamp NULL DEFAULT NULL COMMENT 'When the link was used',
  `expires_at` timestamp NULL DEFAULT NULL COMMENT 'Link expiration date (NULL = no expiration)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_token` (`token`),
  KEY `idx_created_by` (`created_by`),
  KEY `idx_is_used` (`is_used`),
  KEY `idx_expires_at` (`expires_at`),
  KEY `idx_token_used` (`token`, `is_used`),
  CONSTRAINT `fk_invite_links_created_by` FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
