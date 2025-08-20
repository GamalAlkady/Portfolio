# دليل إعدادات البريد الإلكتروني

## 📧 نظرة عامة

تم إضافة قسم جديد لإعدادات البريد الإلكتروني في لوحة التحكم يتيح لك:
- تكوين إعدادات SMTP
- حفظ الإعدادات في ملف .env
- اختبار الإعدادات قبل الحفظ
- إرسال رسائل تجريبية

## 🚀 الملفات المضافة/المحدثة

### ملفات جديدة:
- `app/Helpers/EnvHelper.php` - دوال مساعدة لإدارة ملف .env
- `email_settings_guide.md` - هذا الدليل

### ملفات محدثة:
- `resources/views/Admin/settings/index.view.php` - إضافة تاب إعدادات الإيميل
- `app/Http/Controllers/Admin/SettingController.php` - إضافة وظائف إدارة الإيميل
- `resources/lang/ar/messages.php` - ترجمات عربية
- `resources/lang/en/messages.php` - ترجمات إنجليزية
- `routes/web.php` - إضافة روت اختبار الإيميل
- `public/index.php` - تضمين EnvHelper
- `.env` - تحديث إعدادات البريد الافتراضية

## ⚙️ كيفية الاستخدام

### 1. الوصول لإعدادات البريد الإلكتروني:
```
http://yoursite.com/admin/settings
```
ثم انقر على تاب "إعدادات البريد الإلكتروني"

### 2. تكوين إعدادات SMTP:

#### للـ Gmail:
- **SMTP Host:** smtp.gmail.com
- **SMTP Port:** 587 (TLS) أو 465 (SSL)
- **Username:** your-email@gmail.com
- **Password:** App Password (ليس كلمة مرور Gmail العادية)

#### للـ Outlook/Hotmail:
- **SMTP Host:** smtp-mail.outlook.com
- **SMTP Port:** 587
- **Username:** your-email@outlook.com
- **Password:** كلمة مرور الحساب

#### للـ Yahoo:
- **SMTP Host:** smtp.mail.yahoo.com
- **SMTP Port:** 587 أو 465
- **Username:** your-email@yahoo.com
- **Password:** App Password

### 3. إنشاء App Password للـ Gmail:

1. اذهب إلى [Google Account Settings](https://myaccount.google.com/)
2. انقر على "Security"
3. فعّل "2-Step Verification" إذا لم يكن مفعلاً
4. انقر على "App passwords"
5. اختر "Mail" و "Other (Custom name)"
6. أدخل اسماً مثل "My Website"
7. انسخ كلمة المرور المُنشأة واستخدمها في الإعدادات

## 🧪 اختبار الإعدادات

1. أدخل جميع إعدادات SMTP
2. في قسم "اختبار البريد الإلكتروني"، أدخل بريد إلكتروني للاختبار
3. انقر على "إرسال رسالة تجريبية"
4. ستظهر رسالة نجاح أو فشل
5. تحقق من البريد الإلكتروني المُرسل إليه

## 💾 حفظ الإعدادات

- الإعدادات تُحفظ تلقائياً في ملف `.env`
- لا تحتاج لإعادة تشغيل الخادم
- الإعدادات آمنة ولا تظهر في قاعدة البيانات

## 🔧 الدوال المساعدة الجديدة

### في EnvHelper.php:

```php
// تحديث ملف .env
updateEnvFile([
    'MAIL_HOST' => 'smtp.gmail.com',
    'MAIL_PORT' => '587'
]);

// جلب قيمة من .env
$host = getEnvValue('MAIL_HOST', 'localhost');

// التحقق من صحة إعدادات الإيميل
$errors = validateEmailSettings($settings);

// اختبار الاتصال
$result = testEmailConnection($settings, 'test@example.com');
```

## 🛠️ استكشاف الأخطاء

### مشاكل شائعة:

#### 1. "Authentication failed":
- تأكد من صحة اسم المستخدم وكلمة المرور
- استخدم App Password للـ Gmail
- تأكد من تفعيل "Less secure app access" إذا لزم الأمر

#### 2. "Connection timeout":
- تحقق من إعدادات الـ Firewall
- تأكد من صحة SMTP Host والـ Port
- جرب منافذ مختلفة (587, 465, 25)

#### 3. "SSL/TLS errors":
- استخدم المنفذ الصحيح للتشفير
- 587 للـ TLS
- 465 للـ SSL

#### 4. "From address not allowed":
- تأكد من أن "From Email" مطابق لحساب SMTP
- أو مُصرح له بالإرسال

## 📝 ملاحظات مهمة

1. **الأمان**: لا تشارك إعدادات SMTP مع أحد
2. **App Passwords**: استخدم App Passwords بدلاً من كلمات المرور العادية
3. **التشفير**: استخدم دائماً TLS أو SSL
4. **الاختبار**: اختبر الإعدادات قبل الاعتماد عليها
5. **النسخ الاحتياطي**: احتفظ بنسخة احتياطية من ملف .env

## 🔄 التحديثات المستقبلية

يمكن إضافة المزيد من الميزات مثل:
- دعم مزودي خدمة إضافيين
- قوالب رسائل مخصصة
- سجل رسائل البريد الإلكتروني
- إعدادات متقدمة للتشفير

## 📞 الدعم

إذا واجهت مشاكل:
1. تحقق من سجلات الخادم
2. اختبر الإعدادات خطوة بخطوة
3. راجع وثائق مزود خدمة البريد الإلكتروني
4. تأكد من صحة جميع الإعدادات
