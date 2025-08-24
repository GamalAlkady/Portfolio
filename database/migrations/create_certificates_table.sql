-- إنشاء جدول الشهادات والإنجازات
CREATE TABLE IF NOT EXISTS `certificates` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` json NOT NULL COMMENT 'عنوان الشهادة بعدة لغات',
    `description` json DEFAULT NULL COMMENT 'وصف الشهادة بعدة لغات',
    `issuer` varchar(255) NOT NULL COMMENT 'الجهة المانحة للشهادة',
    `issued_date` date NOT NULL COMMENT 'تاريخ منح الشهادة',
    `expiry_date` date DEFAULT NULL COMMENT 'تاريخ انتهاء الشهادة (إن وجد)',
    `certificate_type` enum('certificate','award','course','achievement') NOT NULL DEFAULT 'certificate' COMMENT 'نوع الشهادة',
    `certificate_file` varchar(500) DEFAULT NULL COMMENT 'ملف الشهادة',
    `verification_url` varchar(500) DEFAULT NULL COMMENT 'رابط التحقق من الشهادة',
    `skills_related` text DEFAULT NULL COMMENT 'المهارات المرتبطة بالشهادة',
    `is_featured` boolean DEFAULT FALSE COMMENT 'شهادة مميزة',
    `display_order` int(11) DEFAULT 0 COMMENT 'ترتيب العرض',
    `status` enum('active','inactive') NOT NULL DEFAULT 'active' COMMENT 'حالة الشهادة',
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_certificate_type` (`certificate_type`),
    INDEX `idx_status` (`status`),
    INDEX `idx_is_featured` (`is_featured`),
    INDEX `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='جدول الشهادات والإنجازات';

-- إضافة بعض البيانات التجريبية
INSERT INTO `certificates` (`title`, `description`, `issuer`, `issued_date`, `certificate_type`, `is_featured`, `display_order`, `status`) VALUES
(
    '{"ar": "شهادة تطوير المواقع المتقدمة", "en": "Advanced Web Development Certificate"}',
    '{"ar": "شهادة متخصصة في تطوير المواقع باستخدام أحدث التقنيات", "en": "Specialized certificate in web development using latest technologies"}',
    'Tech Academy',
    '2024-01-15',
    'certificate',
    1,
    1,
    'active'
),
(
    '{"ar": "جائزة أفضل مطور", "en": "Best Developer Award"}',
    '{"ar": "جائزة للتميز في مجال تطوير البرمجيات", "en": "Award for excellence in software development"}',
    'Developer Conference 2024',
    '2024-06-10',
    'award',
    1,
    2,
    'active'
),
(
    '{"ar": "دورة Laravel المتقدمة", "en": "Advanced Laravel Course"}',
    '{"ar": "دورة شاملة في إطار عمل Laravel", "en": "Comprehensive course in Laravel framework"}',
    'Online Learning Platform',
    '2023-12-20',
    'course',
    0,
    3,
    'active'
);

-- إضافة إعدادات الشهادات إلى جدول الإعدادات
INSERT INTO `settings` (`name`, `value`, `created_at`, `updated_at`) VALUES
('show_certificates_section', '1', NOW(), NOW()),
('certificates_per_page', '6', NOW(), NOW()),
('certificates_section_title_ar', 'الشهادات والإنجازات', NOW(), NOW()),
('certificates_section_title_en', 'Certificates & Achievements', NOW(), NOW())
ON DUPLICATE KEY UPDATE 
    `updated_at` = NOW();