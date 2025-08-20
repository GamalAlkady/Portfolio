# 🌐 دليل الملف الشخصي متعدد اللغات

## 🎯 نظرة عامة

تم تحديث صفحة الملف الشخصي لدعم اللغتين العربية والإنجليزية مع واجهة تبويبات منظمة وسهلة الاستخدام.

## ✨ الميزات المضافة

### 1. **دعم اللغتين العربية والإنجليزية**
- حقول منفصلة لكل لغة
- واجهة تبويبات منظمة
- حفظ مستقل لكل لغة

### 2. **تبويبات منظمة**
- تبويب للمعلومات الأساسية (اسم، تخصص، موقع)
- تبويب للمحتوى التفصيلي (وصف، تعليم، خبرة)
- حقول مشتركة (إيميل، هاتف)

### 3. **محررات نصوص متقدمة**
- Summernote editor لكل حقل نص
- دعم التنسيق الغني
- حفظ تلقائي مع AJAX

### 4. **تصميم محسن**
- تبويبات Bootstrap محسنة
- تأثيرات بصرية جذابة
- تصميم متجاوب

## 📁 الملفات المحدثة

### 1. **الواجهة الأمامية:**
- `resources/views/Admin/profile.view.php` - الملف الرئيسي
- `resources/lang/ar/messages.php` - ترجمات عربية
- `resources/lang/en/messages.php` - ترجمات إنجليزية

## 🔧 البنية الجديدة

### 1. **المعلومات الأساسية:**
```php
// تبويبات اللغة للمعلومات الأساسية
- name[ar] / name[en]           // الاسم
- specialization[ar] / specialization[en]  // التخصص
- location[ar] / location[en]   // الموقع
```

### 2. **المحتوى التفصيلي:**
```php
// تبويبات اللغة للمحتوى
- description_ar / description_en    // الوصف
- education_ar / education_en        // التعليم
- experience_ar / experience_en      // الخبرة
```

### 3. **الحقول المشتركة:**
```php
- email    // البريد الإلكتروني
- phone    // رقم الهاتف
- image    // الصورة الشخصية
- cv_pdf   // ملف السيرة الذاتية
```

## 🎨 واجهة المستخدم

### 1. **تبويبات المعلومات الأساسية:**
```html
<ul class="nav nav-tabs" id="languageTabs">
    <li class="nav-item">
        <button class="nav-link active" data-bs-target="#arabic-profile">
            العربية
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-target="#english-profile">
            English
        </button>
    </li>
</ul>
```

### 2. **تبويبات المحتوى التفصيلي:**
```html
<ul class="nav nav-tabs" id="aboutLanguageTabs">
    <li class="nav-item">
        <button class="nav-link active" data-bs-target="#about-arabic">
            العربية
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-target="#about-english">
            English
        </button>
    </li>
</ul>
```

## 🔄 كيفية العمل

### 1. **حفظ المعلومات الأساسية:**
```php
// في Controller
$data = $request->input();

// حفظ البيانات العربية
if (isset($data['name']['ar'])) {
    setting('name_ar', $data['name']['ar']);
}

// حفظ البيانات الإنجليزية
if (isset($data['name']['en'])) {
    setting('name_en', $data['name']['en']);
}
```

### 2. **حفظ المحتوى التفصيلي (AJAX):**
```javascript
// JavaScript للحفظ التلقائي
function editSave(fieldName) {
    const saveBtn = $(`#${fieldName}Save`);
    const editBtn = $(`#${fieldName}Edit`);
    
    saveBtn.on("click", function() {
        var editorContent = $(`#${fieldName}`).summernote('code');
        
        const formData = new FormData();
        formData.append('csrf', "<?= getCsrf() ?>");
        formData.append(fieldName, editorContent);
        formData.append('_method', 'PUT');
        
        fetch("<?= route('updateSetting') ?>", {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
            }
        });
    });
}
```

## 🎯 الحقول المدعومة

### 1. **الحقول متعددة اللغات:**
| الحقل | العربي | الإنجليزي | النوع |
|-------|--------|-----------|-------|
| الاسم | `name_ar` | `name_en` | نص |
| التخصص | `specialization_ar` | `specialization_en` | نص |
| الموقع | `location_ar` | `location_en` | نص |
| الوصف | `description_ar` | `description_en` | HTML |
| التعليم | `education_ar` | `education_en` | HTML |
| الخبرة | `experience_ar` | `experience_en` | HTML |

### 2. **الحقول المشتركة:**
| الحقل | المفتاح | النوع |
|-------|---------|-------|
| الإيميل | `email` | نص |
| الهاتف | `phone` | نص |
| الصورة | `image` | ملف |
| السيرة الذاتية | `cv_pdf` | PDF |

## 🎨 التصميم والتأثيرات

### 1. **CSS للتبويبات:**
```css
.nav-tabs .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
    color: #495057;
    background-color: #f8f9fa;
    margin-right: 2px;
}

.nav-tabs .nav-link.active {
    color: #495057;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}

.tab-content {
    border: 1px solid #dee2e6;
    border-top: none;
    padding: 20px;
    border-radius: 0 0 0.375rem 0.375rem;
    background-color: #fff;
}
```

### 2. **تأثيرات الأزرار:**
```css
.btn-info:hover, .btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
```

## 🔧 التخصيص والتطوير

### 1. **إضافة حقل جديد متعدد اللغات:**

#### في الواجهة:
```php
// إضافة في التبويب العربي
echo $form->input('new_field[ar]', __('new_field') . ' (' . __('arabic') . ')', 
    old('new_field.ar', setting('new_field_ar')))
    ->attrs(['placeholder' => __('enter_new_field_ar')])
    ->render();

// إضافة في التبويب الإنجليزي
echo $form->input('new_field[en]', __('new_field') . ' (' . __('english') . ')', 
    old('new_field.en', setting('new_field_en')))
    ->attrs(['placeholder' => __('enter_new_field_en')])
    ->render();
```

#### في Controller:
```php
// حفظ الحقل الجديد
if (isset($data['new_field']['ar'])) {
    setting('new_field_ar', $data['new_field']['ar']);
}
if (isset($data['new_field']['en'])) {
    setting('new_field_en', $data['new_field']['en']);
}
```

### 2. **إضافة محرر نص جديد:**
```javascript
// إضافة في JavaScript
editSave('new_content_ar');
editSave('new_content_en');
```

```php
// إضافة في HTML
<div id="new_content_ar"><?= setting('new_content_ar') ?></div>
<button id="new_content_arEdit" class="btn btn-info">تعديل</button>
<button id="new_content_arSave" class="btn btn-primary">حفظ</button>
```

## 📱 التوافق مع الأجهزة

### 1. **الشاشات الصغيرة:**
```css
@media (max-width: 768px) {
    .nav-tabs .nav-link {
        font-size: 14px;
        padding: 8px 12px;
    }
    
    .tab-content {
        padding: 15px;
    }
}
```

### 2. **الأجهزة اللوحية:**
- تبويبات متجاوبة
- أزرار بحجم مناسب للمس
- محررات نصوص محسنة

## 🔍 استكشاف الأخطاء

### 1. **مشاكل شائعة:**

#### التبويبات لا تعمل:
```javascript
// تأكد من تحميل Bootstrap JS
// تأكد من وجود data-bs-toggle="tab"
```

#### المحررات لا تظهر:
```javascript
// تأكد من تحميل Summernote
// تأكد من استدعاء editSave() للحقول الجديدة
```

#### البيانات لا تُحفظ:
```php
// تأكد من أسماء الحقول في النموذج
// تأكد من معالجة البيانات في Controller
```

## 🚀 التطوير المستقبلي

### ميزات مخططة:
1. **دعم لغات إضافية**
2. **معاينة مباشرة للتغييرات**
3. **تصدير الملف الشخصي**
4. **قوالب جاهزة للملف الشخصي**

---
**الملف الشخصي متعدد اللغات جاهز للاستخدام! 🎉**

يوفر تجربة مستخدم محسنة مع دعم كامل للغتين العربية والإنجليزية.
