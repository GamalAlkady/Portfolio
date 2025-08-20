-- إنشاء جدول الزوار
CREATE TABLE IF NOT EXISTS `visitors` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `ip_address` varchar(45) NOT NULL,
    `user_agent` text DEFAULT NULL,
    `page_url` varchar(500) DEFAULT NULL,
    `referer` varchar(500) DEFAULT NULL,
    `country` varchar(100) DEFAULT NULL,
    `city` varchar(100) DEFAULT NULL,
    `session_id` varchar(100) DEFAULT NULL,
    `is_unique` boolean DEFAULT TRUE,
    `visit_date` date NOT NULL,
    `visit_time` time NOT NULL,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_ip_date` (`ip_address`, `visit_date`),
    INDEX `idx_visit_date` (`visit_date`),
    INDEX `idx_is_unique` (`is_unique`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- إضافة إعداد عداد الزوار إلى جدول الإعدادات
INSERT INTO `settings` (`name`, `value`, `created_at`, `updated_at`) VALUES
('show_visitor_counter', '1', NOW(), NOW()),
('visitor_counter_position', 'footer', NOW(), NOW())
ON DUPLICATE KEY UPDATE 
    `updated_at` = NOW();