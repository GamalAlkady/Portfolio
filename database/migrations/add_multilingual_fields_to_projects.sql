-- إضافة حقول اللغة العربية والإنجليزية لجدول المشاريع
-- Adding Arabic and English language fields to projects table

-- إضافة الحقول الجديدة
ALTER TABLE `projects` 
ADD COLUMN `title_ar` VARCHAR(255) NULL AFTER `title`,
ADD COLUMN `title_en` VARCHAR(255) NULL AFTER `title_ar`,
ADD COLUMN `description_ar` TEXT NULL AFTER `description`,
ADD COLUMN `description_en` TEXT NULL AFTER `description_ar`,
ADD COLUMN `category_ar` VARCHAR(100) NULL AFTER `category`,
ADD COLUMN `category_en` VARCHAR(100) NULL AFTER `category_ar`,
ADD COLUMN `technologies_ar` TEXT NULL AFTER `technologies`,
ADD COLUMN `technologies_en` TEXT NULL AFTER `technologies_ar`;

-- إضافة فهارس للبحث السريع
CREATE INDEX `idx_projects_title_ar` ON `projects` (`title_ar`);
CREATE INDEX `idx_projects_title_en` ON `projects` (`title_en`);
CREATE INDEX `idx_projects_category_ar` ON `projects` (`category_ar`);
CREATE INDEX `idx_projects_category_en` ON `projects` (`category_en`);

-- تحديث التعليق على الجدول
ALTER TABLE `projects` COMMENT = 'جدول المشاريع مع دعم اللغتين العربية والإنجليزية';

-- نسخ البيانات الموجودة إلى الحقول الجديدة (إذا كانت موجودة)
-- يمكنك تشغيل هذا إذا كان لديك بيانات موجودة وتريد نسخها
-- UPDATE `projects` SET 
--     `title_ar` = `title`,
--     `description_ar` = `description`,
--     `category_ar` = `category`,
--     `technologies_ar` = `technologies`
-- WHERE `title_ar` IS NULL;

-- إضافة قيود للتأكد من وجود محتوى بإحدى اللغتين على الأقل
-- ALTER TABLE `projects` 
-- ADD CONSTRAINT `chk_title_multilang` 
-- CHECK (`title_ar` IS NOT NULL OR `title_en` IS NOT NULL);

-- ALTER TABLE `projects` 
-- ADD CONSTRAINT `chk_description_multilang` 
-- CHECK (`description_ar` IS NOT NULL OR `description_en` IS NOT NULL);
