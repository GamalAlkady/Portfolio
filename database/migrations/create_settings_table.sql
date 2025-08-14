-- إنشاء جدول الإعدادات
CREATE TABLE IF NOT EXISTS `settings` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL UNIQUE,
    `value` text,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- إدراج الإعدادات الافتراضية
INSERT INTO `settings` (`name`, `value`, `created_at`, `updated_at`) VALUES
('site_name', 'Profolio', NOW(), NOW()),
('site_description', 'Professional Portfolio Website', NOW(), NOW()),
('site_keywords', 'portfolio, web development, programming', NOW(), NOW()),
('site_email', 'admin@example.com', NOW(), NOW()),
('site_phone', '+1234567890', NOW(), NOW()),
('site_address', 'Your Address Here', NOW(), NOW()),
('facebook_url', '', NOW(), NOW()),
('twitter_url', '', NOW(), NOW()),
('linkedin_url', '', NOW(), NOW()),
('github_url', '', NOW(), NOW()),
('instagram_url', '', NOW(), NOW()),
('youtube_url', '', NOW(), NOW()),
('maintenance_mode', '0', NOW(), NOW()),
('allow_registration', '1', NOW(), NOW()),
('items_per_page', '10', NOW(), NOW()),
('site_timezone', 'UTC', NOW(), NOW()),
('date_format', 'Y-m-d', NOW(), NOW()),
('time_format', 'H:i:s', NOW(), NOW())
ON DUPLICATE KEY UPDATE 
    `updated_at` = NOW();
