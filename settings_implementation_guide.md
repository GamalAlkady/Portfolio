# دليل تنفيذ صفحة الإعدادات

## 📋 ملخص ما تم إنشاؤه

### 1. الملفات المنشأة:

#### Controller
- `app/Http/Controllers/Admin/SettingsController.php` - تحكم في الإعدادات

#### Views
- `resources/views/Admin/settings/index.view.php` - صفحة الإعدادات الرئيسية

#### Models
- `app/Models/Settings.php` - نموذج قاعدة البيانات للإعدادات (محدث)

#### Database
- `database/migrations/create_settings_table.sql` - سكريبت إنشاء جدول الإعدادات

#### Helpers
- `app/Helpers/SettingsHelper.php` - دوال مساعدة للوصول للإعدادات

### 2. الملفات المحدثة:

#### Routes
- `routes/web.php` - إضافة روابط الإعدادات

#### Translations
- `resources/lang/ar/messages.php` - ترجمات عربية للإعدادات
- `resources/lang/en/messages.php` - ترجمات إنجليزية للإعدادات

#### Layout
- `resources/views/layout/admin/sidebar.view.php` - إضافة رابط الإعدادات

## 🎯 المميزات المتوفرة

### 1. الإعدادات العامة:
- اسم الموقع
- شعار الموقع (رفع صور)
- وصف الموقع
- الكلمات المفتاحية

### 2. معلومات الاتصال:
- البريد الإلكتروني
- رقم الهاتف
- العنوان

### 3. وسائل التواصل الاجتماعي:
- فيسبوك
- تويتر
- لينكد إن
- جيت هاب
- إنستغرام
- يوتيوب

### 4. إعدادات النظام:
- المنطقة الزمنية
- عدد العناصر في الصفحة
- وضع الصيانة
- السماح بالتسجيل

## 🔧 الخطوات المطلوبة لتفعيل النظام

### 1. إنشاء جدول قاعدة البيانات:

```sql
-- تشغيل هذا الكود في phpMyAdmin أو MySQL
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
('site_timezone', 'UTC', NOW(), NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();
```

### 2. تضمين ملف المساعدات:

أضف هذا السطر في ملف `bootstrap/app.php` أو في أي ملف تحميل رئيسي:

```php
require_once __DIR__ . '/../app/Helpers/SettingsHelper.php';
```

### 3. إنشاء مجلد رفع الصور:

```bash
mkdir -p public/uploads/settings
chmod 755 public/uploads/settings
```

## 🚀 كيفية الاستخدام

### 1. الوصول لصفحة الإعدادات:
```
http://yoursite.com/admin/settings
```

### 2. استخدام الدوال المساعدة في الكود:

```php
// جلب اسم الموقع
echo siteName();

// جلب شعار الموقع
echo '<img src="' . siteLogo() . '" alt="Logo">';

// جلب إعداد معين
echo setting('site_email', 'default@example.com');

// التحقق من وضع الصيانة
if (isMaintenanceMode()) {
    echo 'الموقع في وضع الصيانة';
}

// عرض روابط التواصل الاجتماعي
echo renderSocialLinks('btn btn-social');
```

### 3. استخدام الإعدادات في Views:

```php
<title><?= siteName() ?></title>
<meta name="description" content="<?= siteDescription() ?>">
<meta name="keywords" content="<?= siteKeywords() ?>">

<!-- معلومات الاتصال -->
<p>Email: <?= siteEmail() ?></p>
<p>Phone: <?= sitePhone() ?></p>
<p>Address: <?= siteAddress() ?></p>

<!-- روابط التواصل الاجتماعي -->
<div class="social-links">
    <?= renderSocialLinks('social-icon') ?>
</div>
```

## 🎨 التخصيص والتطوير

### 1. إضافة إعدادات جديدة:

```php
// في Controller
Settings::setSetting('new_setting', 'value');

// في Helper
function newSetting() {
    return setting('new_setting', 'default_value');
}
```

### 2. إضافة تبويب جديد:

1. أضف التبويب في `index.view.php`
2. أضف الحقول المطلوبة
3. أضف الترجمات في ملفات اللغة

### 3. إضافة validation:

```php
// في Controller
if (empty($data['site_name'])) {
    $_SESSION['error'] = 'اسم الموقع مطلوب';
    return back();
}
```

## 🔒 الأمان

### 1. التحقق من الصلاحيات:
- جميع الروابط محمية بـ `middleware('auth')`
- التحقق من CSRF tokens

### 2. تنظيف البيانات:
- استخدام `htmlspecialchars()` عند العرض
- التحقق من أنواع الملفات المرفوعة

### 3. حماية الملفات:
- رفع الصور في مجلد محمي
- التحقق من امتدادات الملفات

## 📱 التوافق

### 1. التصميم المتجاوب:
- يعمل على جميع الأجهزة
- استخدام Bootstrap 5

### 2. المتصفحات:
- متوافق مع جميع المتصفحات الحديثة

### 3. اللغات:
- يدعم العربية والإنجليزية
- قابل للتوسع لإضافة لغات أخرى

## 🐛 استكشاف الأخطاء

### 1. مشاكل شائعة:

#### خطأ في قاعدة البيانات:
```
تأكد من إنشاء جدول settings
تأكد من صحة بيانات الاتصال بقاعدة البيانات
```

#### مشكلة في رفع الصور:
```
تأكد من وجود مجلد uploads/settings
تأكد من صلاحيات الكتابة (755)
```

#### مشكلة في الترجمة:
```
تأكد من وجود مفاتيح الترجمة في ملفات اللغة
تأكد من تفعيل نظام الترجمة
```

### 2. تسجيل الأخطاء:

```php
// إضافة logging في Controller
try {
    // كود التحديث
} catch (Exception $e) {
    error_log('Settings Error: ' . $e->getMessage());
    $_SESSION['error'] = 'حدث خطأ غير متوقع';
}
```

## 🎉 الخلاصة

تم إنشاء نظام إعدادات شامل ومرن يتضمن:

✅ **واجهة سهلة الاستخدام** مع تبويبات منظمة
✅ **دعم كامل للترجمة** (عربي/إنجليزي)
✅ **نظام آمن** مع حماية CSRF
✅ **دوال مساعدة** للوصول السهل للإعدادات
✅ **تصميم متجاوب** يعمل على جميع الأجهزة
✅ **قابلية التوسع** لإضافة إعدادات جديدة

النظام جاهز للاستخدام ويمكن الوصول إليه من:
`http://yoursite.com/admin/settings`
