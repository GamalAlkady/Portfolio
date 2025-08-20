# دليل نظام تتبع الزوار
## Visitor Tracking System Guide

هذا الدليل يشرح كيفية استخدام نظام تتبع الزوار الذي تم إنشاؤه لموقعك الشخصي.

## المكونات المثبتة

### 1. قاعدة البيانات
- **جدول `visitors`**: لحفظ بيانات الزوار
- **إعدادات إضافية**: في جدول `settings` للتحكم في عرض عداد الزوار

### 2. الملفات المضافة
- `app/Models/Visitors.php` - نموذج البيانات
- `app/Helpers/VisitorTracker.php` - مساعد تتبع الزوار
- `resources/views/Admin/visitors.view.php` - صفحة إحصائيات الزوار في لوحة التحكم
- `database/migrations/create_visitors_table.php` - ملف إنشاء الجدول
- `database/migrations/create_visitors_table.sql` - ملف SQL لإنشاء الجدول

### 3. الملفات المحدثة
- `app/Http/Controllers/HomeController.php` - إضافة تتبع الزوار
- `app/Http/Controllers/Admin/DashboardController.php` - إضافة إحصائيات الزوار
- `app/Helpers/SettingsHelper.php` - إضافة دوال مساعدة للإحصائيات
- `resources/views/layout/footer.view.php` - عداد الزوار في الواجهة الأمامية
- `resources/views/Admin/dashboard.view.php` - عرض الإحصائيات في الداشبورد
- `routes/web.php` - إضافة route لصفحة الإحصائيات

## طريقة التثبيت

### 1. إنشاء جدول قاعدة البيانات

قم بتشغيل أحد الأوامر التالية:

**الطريقة الأولى - استخدام ملف PHP Migration:**
```bash
php -r "require 'database/migrations/create_visitors_table.php'; (new create_visitors_table())->up();"
```

**الطريقة الثانية - استخدام ملف SQL مباشرة:**
```bash
mysql -u [username] -p [database_name] < database/migrations/create_visitors_table.sql
```

**أو يدوياً من phpMyAdmin:**
- افتح phpMyAdmin
- حدد قاعدة البيانات الخاصة بك
- انسخ محتوى ملف `database/migrations/create_visitors_table.sql` ونفذه

### 2. التأكد من عمل النظام

1. **زر موقعك الرئيسي** - يجب أن يتم تسجيل الزيارة تلقائياً
2. **ادخل لوحة التحكم** (`/admin/dashboard`) - يجب أن ترى إحصائيات الزوار
3. **زر صفحة الإحصائيات المفصلة** (`/admin/visitors`)

## الميزات المتاحة

### 1. تتبع تلقائي للزوار
- **تسجيل تلقائي** لكل زائر جديد
- **تجنب تسجيل البوتات** والزيارات الوهمية
- **تتبع الصفحات المختلفة** (الرئيسية، المشاريع، إلخ)
- **تسجيل معلومات تفصيلية**: IP، المتصفح، المصدر، إلخ

### 2. إحصائيات شاملة
- **زوار اليوم** (إجمالي وفريد)
- **زوار الأسبوع** (إجمالي وفريد)
- **زوار الشهر** (إجمالي وفريد)
- **إجمالي الزوار** منذ التثبيت
- **الزوار المتصلون حالياً** (آخر 30 دقيقة)

### 3. تحليلات متقدمة
- **الصفحات الأكثر زيارة**
- **مصادر الإحالة** (الروابط المؤدية للموقع)
- **إحصائيات الدول** (إذا تم تفعيل GeoIP)
- **رسوم بيانية يومية**

### 4. عداد زوار في الواجهة الأمامية
- **عرض في Footer** الموقع
- **تحديث تلقائي** كل 5 دقائق
- **تصميم متجاوب** مع جميع الأجهزة

## واجهة لوحة التحكم

### 1. الداشبورد الرئيسي (`/admin/dashboard`)
- **بطاقات إحصائية** في أعلى الصفحة
- **نظرة عامة سريعة** على الزيارات
- **رابط للتفاصيل الكاملة**

### 2. صفحة إحصائيات الزوار (`/admin/visitors`)
- **إحصائيات شاملة** مع بطاقات ملونة
- **رسم بياني** لاتجاه الزيارات اليومية
- **جداول تفصيلية** للصفحات والمصادر والدول
- **تحديث تلقائي** كل 5 دقائق

## إعدادات النظام

يمكنك التحكم في النظام عبر جدول `settings`:

### إعدادات متاحة:
- `show_visitor_counter` (1/0): عرض/إخفاء عداد الزوار في الواجهة الأمامية
- `visitor_counter_position` (footer): موضع عداد الزوار

### تعديل الإعدادات:
```sql
-- إخفاء عداد الزوار من الواجهة الأمامية
UPDATE settings SET value = '0' WHERE name = 'show_visitor_counter';

-- إظهار عداد الزوار
UPDATE settings SET value = '1' WHERE name = 'show_visitor_counter';
```

## تخصيصات إضافية

### 1. إضافة دعم GeoIP (اختياري)
لتحديد دولة ومدينة الزائر، يمكنك:

```php
// في ملف app/Helpers/VisitorTracker.php
protected function getCountryByIp()
{
    $ip = $this->getIpAddress();
    
    // استخدام خدمة مجانية
    $response = @file_get_contents("http://ip-api.com/json/{$ip}");
    if ($response) {
        $data = json_decode($response, true);
        return $data['country'] ?? null;
    }
    
    return null;
}
```

### 2. تخصيص تصميم عداد الزوار
يمكنك تعديل CSS في ملف `resources/views/layout/footer.view.php`

### 3. إضافة إحصائيات أخرى
يمكنك توسيع النموذج `Visitors.php` لإضافة إحصائيات جديدة

## استكشاف الأخطاء

### المشاكل الشائعة:

1. **عدم ظهور الإحصائيات:**
   - تأكد من إنشاء جدول `visitors`
   - تأكد من وجود البيانات في الجدول

2. **خطأ في قاعدة البيانات:**
   ```sql
   -- تحقق من وجود الجدول
   SHOW TABLES LIKE 'visitors';
   
   -- تحقق من هيكل الجدول
   DESCRIBE visitors;
   ```

3. **عداد الزوار لا يظهر:**
   - تأكد من الإعداد: `show_visitor_counter = '1'`
   - تحقق من عدم وجود أخطاء PHP

4. **عدم تسجيل الزيارات:**
   - تأكد من استدعاء `VisitorTracker::run()` في الصفحات
   - تحقق من صحة اتصال قاعدة البيانات

## الدعم والتطوير

### إضافة صفحات جديدة للتتبع:
```php
// في أي Controller
use App\Helpers\VisitorTracker;

public function myNewPage() {
    VisitorTracker::run();
    // باقي الكود...
}
```

### إضافة إحصائيات مخصصة:
```php
// في Visitors Model
public function getCustomStats() {
    return DB::db()->query("
        SELECT COUNT(*) as visits 
        FROM {$this->table} 
        WHERE custom_condition = ?
    ", [$condition])->fetch();
}
```

## الأمان والخصوصية

- النظام **لا يحفظ معلومات شخصية**
- **IP addresses** محفوظة للإحصائيات فقط
- **كشف البوتات تلقائياً** لإحصائيات دقيقة
- **تجنب تتبع ملفات النظام** والأصول

---

## ملخص سريع للاستخدام

1. **نفذ ملف SQL** لإنشاء الجدول
2. **زر موقعك** - سيتم التتبع تلقائياً
3. **ادخل لوحة التحكم** لرؤية الإحصائيات
4. **استمتع بمعرفة عدد زوارك!** 📊

---

*تم إنشاء هذا النظام خصيصاً لموقعك الشخصي. للدعم الفني أو التطوير، يمكنك مراجعة الكود أو التواصل مع المطور.*