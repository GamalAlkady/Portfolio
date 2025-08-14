-- إضافة عمود cv_pdf إلى جدول المستخدمين
ALTER TABLE `users` ADD COLUMN `cv_pdf` VARCHAR(255) NULL AFTER `image`;

-- إضافة فهرس للبحث السريع
CREATE INDEX `idx_users_cv_pdf` ON `users` (`cv_pdf`);

-- تحديث التعليق على الجدول
ALTER TABLE `users` COMMENT = 'جدول المستخدمين مع دعم رفع السيرة الذاتية PDF';
