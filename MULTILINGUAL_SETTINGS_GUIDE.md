# 🌐 دليل إعدادات الموقع متعددة اللغات

## 🎯 نظرة عامة

تم تحديث صفحة إعدادات الموقع لدعم اللغتين العربية والإنجليزية مع واجهة تبويبات متداخلة منظمة وسهلة الاستخدام.

## ✨ الميزات المضافة

### 1. **دعم اللغتين العربية والإنجليزية**
- **اسم الموقع**: حقول منفصلة للعربية والإنجليزية
- **وصف الموقع**: وصف مخصص لكل لغة
- **الكلمات المفتاحية**: كلمات مفتاحية مناسبة لكل لغة

### 2. **تبويبات متداخلة منظمة**
- تبويبات رئيسية للأقسام (عام، اتصال، وسائل التواصل، إلخ)
- تبويبات فرعية للغات داخل القسم العام
- تصميم هرمي واضح ومنطقي

### 3. **إعدادات مشتركة**
- شعار الموقع (مشترك بين اللغات)
- حقول قديمة للتوافق مع النسخة السابقة
- إعدادات النظام والاتصال

### 4. **تصميم محسن**
- تبويبات Bootstrap محسنة مع تأثيرات
- ألوان متناسقة ومتجاوبة
- تحسينات للأجهزة المحمولة

## 📁 الملفات المحدثة

### 1. **الواجهة الأمامية:**
- `resources/views/Admin/settings/index.view.php` - الملف الرئيسي
- `resources/lang/ar/messages.php` - ترجمات عربية جديدة
- `resources/lang/en/messages.php` - ترجمات إنجليزية جديدة

## 🔧 البنية الجديدة

### 1. **الحقول متعددة اللغات:**
```php
// الحقول العربية
site_name_ar         // اسم الموقع بالعربية
site_description_ar  // وصف الموقع بالعربية
site_keywords_ar     // الكلمات المفتاحية بالعربية

// الحقول الإنجليزية
site_name_en         // اسم الموقع بالإنجليزية
site_description_en  // وصف الموقع بالإنجليزية
site_keywords_en     // الكلمات المفتاحية بالإنجليزية
```

### 2. **الحقول المشتركة:**
```php
site_logo           // شعار الموقع
site_email          // بريد الموقع
site_phone          // هاتف الموقع
site_address        // عنوان الموقع
```

### 3. **الحقول القديمة (للتوافق):**
```php
site_name           // اسم الموقع (قديم)
site_description    // وصف الموقع (قديم)
site_keywords       // الكلمات المفتاحية (قديمة)
```

## 🎨 واجهة المستخدم

### 1. **التبويبات الرئيسية:**
```html
<ul class="nav nav-tabs" id="settings-tabs">
    <li class="nav-item">
        <button class="nav-link active" data-bs-target="#general">
            الإعدادات العامة
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-target="#contact">
            معلومات الاتصال
        </button>
    </li>
    <!-- المزيد من التبويبات -->
</ul>
```

### 2. **التبويبات الفرعية للغات:**
```html
<ul class="nav nav-tabs" id="generalLanguageTabs">
    <li class="nav-item">
        <button class="nav-link active" data-bs-target="#general-arabic">
            🌐 العربية
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-target="#general-english">
            🌐 English
        </button>
    </li>
</ul>
```

## 🔄 كيفية العمل

### 1. **حفظ الإعدادات متعددة اللغات:**
```php
// في Controller
$data = $request->input();

// حفظ البيانات العربية
if (isset($data['site_name_ar'])) {
    setting('site_name_ar', $data['site_name_ar']);
}

// حفظ البيانات الإنجليزية
if (isset($data['site_name_en'])) {
    setting('site_name_en', $data['site_name_en']);
}
```

### 2. **استرجاع الإعدادات حسب اللغة:**
```php
// في الواجهة الأمامية
$siteName = setting('site_name_' . locale()) ?: setting('site_name');
$siteDescription = setting('site_description_' . locale()) ?: setting('site_description');
```

## 🎯 الحقول المدعومة

### 1. **الحقول متعددة اللغات:**
| الحقل | العربي | الإنجليزي | النوع |
|-------|--------|-----------|-------|
| اسم الموقع | `site_name_ar` | `site_name_en` | نص |
| وصف الموقع | `site_description_ar` | `site_description_en` | نص طويل |
| الكلمات المفتاحية | `site_keywords_ar` | `site_keywords_en` | نص |

### 2. **الحقول المشتركة:**
| الحقل | المفتاح | النوع |
|-------|---------|-------|
| شعار الموقع | `site_logo` | ملف صورة |
| بريد الموقع | `site_email` | بريد إلكتروني |
| هاتف الموقع | `site_phone` | نص |
| عنوان الموقع | `site_address` | نص طويل |

### 3. **الحقول القديمة (للتوافق):**
| الحقل | المفتاح | الحالة |
|-------|---------|--------|
| اسم الموقع | `site_name` | قديم |
| وصف الموقع | `site_description` | قديم |
| الكلمات المفتاحية | `site_keywords` | قديم |

## 🎨 التصميم والتأثيرات

### 1. **CSS للتبويبات المتداخلة:**
```css
#generalLanguageTabs .nav-link {
    border: 1px solid transparent;
    border-radius: 0.375rem;
    color: #6c757d;
    background-color: #f8f9fa;
    margin-right: 5px;
    font-size: 0.9rem;
    padding: 8px 16px;
    transition: all 0.3s ease;
}

#generalLanguageTabs .nav-link.active {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
}
```

### 2. **تأثيرات الحركة:**
```css
.tab-pane {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
```

### 3. **تصميم الحقول القديمة:**
```css
#site_name.form-control {
    background-color: #f8f9fa;
    border: 1px dashed #dee2e6;
}
```

## 🔧 التخصيص والتطوير

### 1. **إضافة حقل جديد متعدد اللغات:**

#### في الواجهة:
```php
// إضافة في التبويب العربي
<div class="mb-3">
    <label for="new_field_ar" class="form-label">
        <i class="fas fa-icon me-1"></i><?= __("new_field") ?> (<?= __("ar") ?>)
    </label>
    <input type="text" class="form-control" id="new_field_ar" name="new_field_ar"
        value="<?= htmlspecialchars(setting('new_field_ar')) ?>"
        placeholder="<?= __("enter_new_field_ar") ?>">
</div>

// إضافة في التبويب الإنجليزي
<div class="mb-3">
    <label for="new_field_en" class="form-label">
        <i class="fas fa-icon me-1"></i><?= __("new_field") ?> (<?= __("en") ?>)
    </label>
    <input type="text" class="form-control" id="new_field_en" name="new_field_en"
        value="<?= htmlspecialchars(setting('new_field_en')) ?>"
        placeholder="<?= __("enter_new_field_en") ?>">
</div>
```

#### في Controller:
```php
// حفظ الحقل الجديد
if (isset($data['new_field_ar'])) {
    setting('new_field_ar', $data['new_field_ar']);
}
if (isset($data['new_field_en'])) {
    setting('new_field_en', $data['new_field_en']);
}
```

### 2. **إضافة ترجمات جديدة:**
```php
// في resources/lang/ar/messages.php
'enter_new_field_ar' => 'أدخل الحقل الجديد بالعربية',

// في resources/lang/en/messages.php
'enter_new_field_en' => 'Enter new field in English',
```

## 📱 التوافق مع الأجهزة

### 1. **الشاشات الصغيرة:**
```css
@media (max-width: 768px) {
    #generalLanguageTabs .nav-link {
        font-size: 0.8rem;
        padding: 6px 12px;
        margin-right: 3px;
    }
    
    #generalLanguageTabsContent {
        padding: 15px;
    }
}
```

### 2. **الأجهزة اللوحية:**
- تبويبات متجاوبة
- أزرار بحجم مناسب للمس
- تخطيط محسن للشاشات المتوسطة

## 🔍 استكشاف الأخطاء

### 1. **مشاكل شائعة:**

#### التبويبات المتداخلة لا تعمل:
```javascript
// تأكد من تحميل Bootstrap JS
// تأكد من وجود data-bs-toggle="tab"
```

#### البيانات لا تُحفظ:
```php
// تأكد من أسماء الحقول في النموذج
// تأكد من معالجة البيانات في Controller
```

#### التصميم غير صحيح:
```css
// تأكد من تحميل CSS المخصص
// تأكد من عدم تعارض الأنماط
```

## 🚀 التطوير المستقبلي

### ميزات مخططة:
1. **دعم لغات إضافية**
2. **معاينة مباشرة للتغييرات**
3. **تصدير/استيراد الإعدادات**
4. **قوالب جاهزة للإعدادات**

---
**إعدادات الموقع متعددة اللغات جاهزة للاستخدام! 🎉**

يوفر تجربة إدارة محسنة مع دعم كامل للغتين العربية والإنجليزية.
