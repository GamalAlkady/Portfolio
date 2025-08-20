# 🌐 دليل نظام الترجمة JavaScript

## 🎯 نظرة عامة

تم إنشاء نظام ترجمة بسيط وفعال يستخدم ملفات الترجمة الموجودة في مجلد `resources/lang` مباشرة، بدون الحاجة لـ API إضافي.

## 📁 الملفات المضافة/المحدثة

### 1. JavaScript
- `public/assets/js/utils.js` - نظام الترجمة الأساسي

### 2. PHP Helpers
- `app/Helpers/TranslationHelper.php` - مساعد تمرير الترجمات للـ JavaScript
- `app/Helpers/General.php` - تحديث لتحميل المساعد

### 3. ملفات الترجمة
- `resources/lang/ar/messages.php` - إضافة ترجمات JavaScript
- `resources/lang/en/messages.php` - إضافة ترجمات JavaScript

## 🚀 كيفية الاستخدام

### 1. في ملفات PHP (Views)

#### إضافة الترجمات للصفحة:
```php
<!DOCTYPE html>
<html lang="<?= locale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('page_title') ?></title>
    
    <!-- إضافة الترجمات للـ JavaScript -->
    <?= renderTranslations() ?>
    
    <!-- أو تحديد ترجمات محددة -->
    <?= renderTranslations(locale(), ['save', 'cancel', 'delete', 'confirm_delete']) ?>
</head>
<body>
    <!-- محتوى الصفحة -->
    
    <script src="<?= assets('js/utils.js') ?>"></script>
</body>
</html>
```

#### استخدام meta tag بدلاً من script:
```php
<head>
    <!-- إضافة الترجمات كـ meta tag -->
    <?= renderTranslationsMeta() ?>
</head>
```

### 2. في JavaScript

#### الاستخدام الأساسي:
```javascript
// استخدام دالة __ (مثل Laravel)
alert(__('save')); // سيعرض "حفظ" أو "Save" حسب اللغة

// رسائل التأكيد
if (confirm(__('are_you_sure'))) {
    // تنفيذ الإجراء
}

// رسائل الخطأ
console.error(__('operation_failed'));
```

#### استخدام مع متغيرات:
```javascript
// استخدام متغيرات في الترجمة
const message = __('welcome_user', {name: 'أحمد'});
// إذا كانت الترجمة: "مرحباً :name"
// النتيجة: "مرحباً أحمد"
```

#### التحقق من اللغة:
```javascript
// التحقق من اللغة الحالية
if (translator.getLocale() === 'ar') {
    // كود خاص بالعربية
}

// التحقق من اتجاه النص
if (translator.isRTL()) {
    // كود خاص بـ RTL
}
```

#### تغيير اللغة:
```javascript
// تغيير اللغة (سيعيد تحميل الصفحة)
translator.setLocale('en');
```

### 3. أمثلة عملية

#### مثال: تأكيد الحذف
```javascript
function deleteItem(id) {
    if (confirm(__('delete_warning'))) {
        // تنفيذ الحذف
        fetch(`/delete/${id}`, {method: 'DELETE'})
            .then(response => {
                if (response.ok) {
                    alert(__('deleted_successfully'));
                } else {
                    alert(__('delete_failed'));
                }
            })
            .catch(() => {
                alert(__('network_error'));
            });
    }
}
```

#### مثال: نموذج مع تحقق
```javascript
function validateForm() {
    const name = document.getElementById('name').value;
    
    if (!name.trim()) {
        alert(__('required_fields_missing'));
        return false;
    }
    
    // عرض رسالة تحميل
    showLoading(__('processing'));
    
    return true;
}

function showLoading(message) {
    const loader = document.createElement('div');
    loader.textContent = message || __('loading');
    loader.className = 'loading-message';
    document.body.appendChild(loader);
}
```

#### مثال: رفع ملف
```javascript
function uploadFile(file) {
    const formData = new FormData();
    formData.append('file', file);
    
    // التحقق من حجم الملف
    if (file.size > 2 * 1024 * 1024) { // 2MB
        alert(__('file_too_large'));
        return;
    }
    
    // عرض رسالة رفع
    showProgress(__('uploading'));
    
    fetch('/upload', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(__('upload_complete'));
        } else {
            alert(__('upload_failed'));
        }
    })
    .catch(() => {
        alert(__('network_error'));
    })
    .finally(() => {
        hideProgress();
    });
}
```

## 🔧 الترجمات المتاحة

### رسائل عامة:
- `loading` - جاري التحميل...
- `please_wait` - يرجى الانتظار...
- `processing` - جاري المعالجة...
- `completed` - تم بنجاح
- `failed` - فشل
- `try_again` - حاول مرة أخرى

### رسائل التأكيد:
- `confirm_action` - تأكيد الإجراء
- `are_you_sure` - هل أنت متأكد؟
- `cannot_be_undone` - لا يمكن التراجع عن هذا الإجراء
- `yes_continue` - نعم، متابعة
- `no_cancel` - لا، إلغاء

### رسائل الحذف:
- `confirm_delete` - تأكيد الحذف
- `delete_warning` - هل أنت متأكد من حذف هذا العنصر؟
- `yes_delete` - نعم، احذف
- `deleted_successfully` - تم الحذف بنجاح
- `delete_failed` - فشل في حذف العنصر

### رسائل النجاح والخطأ:
- `success` - نجح
- `error` - خطأ
- `warning` - تحذير
- `info` - معلومات
- `saved_successfully` - تم الحفظ بنجاح
- `updated_successfully` - تم التحديث بنجاح
- `operation_failed` - فشلت العملية
- `unexpected_error` - حدث خطأ غير متوقع

### أزرار وإجراءات:
- `save` - حفظ
- `cancel` - إلغاء
- `edit` - تعديل
- `delete` - حذف
- `add` - إضافة
- `update` - تحديث
- `submit` - إرسال
- `close` - إغلاق

## 🎨 تخصيص النظام

### إضافة ترجمات جديدة:

#### 1. في ملفات اللغة:
```php
// resources/lang/ar/messages.php
'my_custom_message' => 'رسالتي المخصصة',

// resources/lang/en/messages.php
'my_custom_message' => 'My custom message',
```

#### 2. تمرير الترجمة للـ JavaScript:
```php
<?= renderTranslations(locale(), ['my_custom_message']) ?>
```

#### 3. استخدامها في JavaScript:
```javascript
alert(__('my_custom_message'));
```

### تخصيص الترجمات الافتراضية:

يمكنك تعديل الترجمات الافتراضية في `TranslationHelper.php`:

```php
private static function getDefaultTranslations($locale)
{
    $defaults = [
        'ar' => [
            'my_default' => 'قيمة افتراضية',
            // ...
        ],
        'en' => [
            'my_default' => 'Default value',
            // ...
        ]
    ];
    
    return $defaults[$locale] ?? $defaults['en'];
}
```

## 🔍 استكشاف الأخطاء

### مشاكل شائعة:

#### 1. الترجمات لا تظهر:
- تأكد من إضافة `<?= renderTranslations() ?>` في الصفحة
- تحقق من وجود الترجمة في ملف اللغة
- تأكد من تحميل `utils.js`

#### 2. اللغة خاطئة:
- تحقق من `locale()` في PHP
- تأكد من وجود `lang` attribute في HTML
- راجع `detectLocale()` في JavaScript

#### 3. الترجمات لا تتحدث:
- تأكد من إعادة تحميل الصفحة بعد تغيير الترجمات
- امسح cache المتصفح
- تحقق من Console للأخطاء

## 📊 الأداء

### نصائح للأداء:
1. **حدد الترجمات المطلوبة فقط**: استخدم المعامل الثاني في `renderTranslations()`
2. **استخدم meta tag للترجمات القليلة**: أسرع من script tag
3. **تجنب تحميل جميع الترجمات**: حمل ما تحتاجه فقط

### مثال محسن:
```php
<!-- بدلاً من تحميل جميع الترجمات -->
<?= renderTranslations() ?>

<!-- حمل الترجمات المطلوبة فقط -->
<?= renderTranslations(locale(), [
    'save', 'cancel', 'delete', 'confirm_delete',
    'loading', 'success', 'error'
]) ?>
```

---
**نظام الترجمة JavaScript جاهز للاستخدام! 🎉**

يمكنك الآن استخدام الترجمات في JavaScript بنفس سهولة PHP، مع الاعتماد على ملفات الترجمة الموجودة بدون تعقيد إضافي.
