# 📧 دليل قوالب البريد الإلكتروني

## 🎯 نظرة عامة

تم إنشاء نظام شامل لقوالب البريد الإلكتروني يدعم اللغتين العربية والإنجليزية مع تصاميم احترافية وسهولة في الاستخدام.

## ✨ الميزات

- **دعم متعدد اللغات** (عربي/إنجليزي)
- **تصاميم احترافية** مع CSS متقدم
- **قوالب متنوعة** لمختلف الاحتياجات
- **سهولة الاستخدام** مع دوال مساعدة
- **إرسال تلقائي** مع إعدادات SMTP
- **تصميم متجاوب** يعمل على جميع الأجهزة

## 📁 الملفات

```
app/Templates/EmailTemplates.php          # ملف القوالب الرئيسي
email_templates_usage_examples.php       # أمثلة الاستخدام
EMAIL_TEMPLATES_GUIDE.md                 # هذا الدليل
```

## 🎨 القوالب المتاحة

### 1. قالب جهة الاتصال (Contact Email)
- **الغرض:** رسائل من نموذج الاتصال
- **البيانات المطلوبة:**
  ```php
  [
      'name' => 'اسم المرسل',
      'email' => 'email@example.com',
      'phone' => '+966501234567', // اختياري
      'message' => 'نص الرسالة',
      'site_name' => 'اسم الموقع'
  ]
  ```

### 2. قالب الترحيب (Welcome Email)
- **الغرض:** ترحيب بالمستخدمين الجدد
- **البيانات المطلوبة:**
  ```php
  [
      'name' => 'اسم المستخدم',
      'site_name' => 'اسم الموقع',
      'site_url' => 'https://example.com'
  ]
  ```

### 3. قالب الإشعارات (Notification Email)
- **الغرض:** إشعارات عامة ورسائل النظام
- **البيانات المطلوبة:**
  ```php
  [
      'title' => 'عنوان الإشعار',
      'message' => 'نص الإشعار',
      'site_name' => 'اسم الموقع',
      'action_url' => 'https://example.com/action', // اختياري
      'action_text' => 'نص الزر' // اختياري
  ]
  ```

## 🚀 كيفية الاستخدام

### الطريقة الأساسية:

```php
use App\Templates\EmailTemplates;

// قالب جهة الاتصال بالعربية
$htmlContent = EmailTemplates::contactEmailArabic($data);

// قالب الترحيب بالإنجليزية
$htmlContent = EmailTemplates::welcomeEmailEnglish($data);
```

### الطريقة المتقدمة (مع اختيار اللغة):

```php
// اختيار تلقائي للغة
$htmlContent = EmailTemplates::getContactEmail($data, 'ar');
$htmlContent = EmailTemplates::getWelcomeEmail($data, 'en');
$htmlContent = EmailTemplates::getNotificationEmail($data, 'ar');
```

### الطريقة الشاملة (إرسال مباشر):

```php
$result = EmailTemplates::sendTemplatedEmail(
    'contact',                    // نوع القالب
    $data,                       // البيانات
    'recipient@example.com',     // المستقبل
    'ar'                        // اللغة
);

if ($result['success']) {
    echo "تم الإرسال بنجاح";
} else {
    echo "خطأ: " . $result['message'];
}
```

## 📝 أمثلة عملية

### مثال 1: إرسال رسالة جهة الاتصال

```php
$contactData = [
    'name' => 'أحمد محمد',
    'email' => 'ahmed@example.com',
    'phone' => '+966501234567',
    'message' => 'مرحباً، أريد الاستفسار عن خدماتكم',
    'site_name' => 'موقع البورتفوليو'
];

$result = EmailTemplates::sendTemplatedEmail(
    'contact',
    $contactData,
    'admin@example.com',
    'ar'
);
```

### مثال 2: إرسال رسالة ترحيب

```php
$welcomeData = [
    'name' => 'سارة أحمد',
    'site_name' => 'منصة التعلم',
    'site_url' => 'https://example.com'
];

$result = EmailTemplates::sendTemplatedEmail(
    'welcome',
    $welcomeData,
    'sara@example.com',
    'ar'
);
```

### مثال 3: إرسال إشعار

```php
$notificationData = [
    'title' => 'تحديث مهم',
    'message' => 'تم تحديث النظام بميزات جديدة',
    'site_name' => 'نظام الإدارة',
    'action_url' => 'https://example.com/updates',
    'action_text' => 'عرض التحديثات'
];

$result = EmailTemplates::sendTemplatedEmail(
    'notification',
    $notificationData,
    'user@example.com',
    'ar'
);
```

## 🎨 تخصيص التصميم

### الألوان المستخدمة:
- **الأساسي:** `#667eea` إلى `#764ba2`
- **النجاح:** `#4CAF50` إلى `#45a049`
- **التحذير:** `#FF9800` إلى `#F57C00`
- **الخلفية:** `#f4f4f4`
- **النص:** `#333333`

### تخصيص الألوان:
يمكنك تعديل الألوان في CSS داخل كل قالب:

```css
.header { 
    background: linear-gradient(135deg, #YOUR_COLOR1 0%, #YOUR_COLOR2 100%); 
}
```

## 🔧 إعدادات SMTP

تأكد من تكوين إعدادات SMTP في ملف `.env`:

```env
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=noreply@yoursite.com
MAIL_FROM_NAME=Your Site Name
```

## 🛠️ استكشاف الأخطاء

### مشاكل شائعة:

1. **خطأ في الإرسال:**
   - تحقق من إعدادات SMTP
   - تأكد من صحة App Password
   - راجع سجلات الخادم

2. **تصميم غير صحيح:**
   - تأكد من وجود جميع البيانات المطلوبة
   - تحقق من صحة HTML

3. **مشاكل الترميز:**
   - تأكد من استخدام UTF-8
   - استخدم `htmlspecialchars()` للنصوص

## 📱 التوافق

القوالب متوافقة مع:
- ✅ Gmail
- ✅ Outlook
- ✅ Apple Mail
- ✅ Yahoo Mail
- ✅ Thunderbird
- ✅ الهواتف المحمولة

## 🔄 التحديثات المستقبلية

يمكن إضافة:
- قوالب إضافية (فواتير، تذكيرات، إلخ)
- دعم لغات أخرى
- محرر قوالب مرئي
- إحصائيات الإيميل
- قوالب ديناميكية

## 📞 الدعم

للحصول على المساعدة:
1. راجع ملف `email_templates_usage_examples.php`
2. تحقق من إعدادات SMTP
3. راجع سجلات الخادم
4. تأكد من صحة البيانات المرسلة

---
**تم إنشاء نظام قوالب البريد الإلكتروني بنجاح! 🎉**
