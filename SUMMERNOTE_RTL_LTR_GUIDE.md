# 📝 دليل Summernote متعدد الاتجاهات (RTL/LTR)

## 🎯 نظرة عامة

تم تحسين محرر Summernote ليدعم الكتابة بالاتجاهين العربي (RTL) والإنجليزي (LTR) مع إعدادات مخصصة لكل لغة.

## ✨ الميزات المضافة

### 1. **دعم الاتجاهات المختلفة**
- **RTL للعربية**: اتجاه من اليمين لليسار مع خطوط عربية
- **LTR للإنجليزية**: اتجاه من اليسار لليمين مع خطوط إنجليزية
- **تبديل تلقائي**: حسب اللغة المحددة

### 2. **خطوط مخصصة**
- **للعربية**: Cairo, Tajawal, Amiri, Noto Sans Arabic
- **للإنجليزية**: Roboto, Open Sans, Lato
- **خطوط احتياطية**: Arial, Times New Roman

### 3. **أشرطة أدوات محسنة**
- شريط أدوات كامل مع جميع الخيارات
- أنماط مخصصة لكل لغة
- ألوان وتنسيقات متقدمة

### 4. **ترجمة كاملة**
- واجهة عربية للمحرر العربي
- واجهة إنجليزية للمحرر الإنجليزي
- نصوص مساعدة مترجمة

## 🔧 الإعدادات المطبقة

### 1. **المحرر العربي (RTL):**
```javascript
$('#site_description_ar').summernote({
    height: 200,
    direction: 'rtl',
    lang: 'ar-AR',
    fontNames: ['Arial', 'Cairo', 'Tajawal', 'Amiri', 'Noto Sans Arabic'],
    toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'strikethrough']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['forecolor', 'backcolor']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
    ],
    styleTags: [
        'p',
        { title: 'عنوان رئيسي', tag: 'h1' },
        { title: 'عنوان فرعي', tag: 'h2' },
        { title: 'عنوان صغير', tag: 'h3' },
        { title: 'اقتباس', tag: 'blockquote' }
    ],
    placeholder: 'اكتب وصف الموقع بالعربية هنا...'
});
```

### 2. **المحرر الإنجليزي (LTR):**
```javascript
$('#site_description_en').summernote({
    height: 200,
    direction: 'ltr',
    lang: 'en-US',
    fontNames: ['Arial', 'Roboto', 'Open Sans', 'Lato'],
    toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'strikethrough']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['forecolor', 'backcolor']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
    ],
    styleTags: [
        'p',
        { title: 'Main Heading', tag: 'h1' },
        { title: 'Sub Heading', tag: 'h2' },
        { title: 'Small Heading', tag: 'h3' },
        { title: 'Quote', tag: 'blockquote' }
    ],
    placeholder: 'Write site description in English here...'
});
```

## 🎨 التصميم والأنماط

### 1. **CSS للدعم RTL:**
```css
.note-editor.rtl-editor {
    direction: rtl;
    text-align: right;
}

.note-editor.rtl-editor .note-editable {
    direction: rtl;
    text-align: right;
    font-family: 'Cairo', 'Tajawal', 'Amiri', Arial, sans-serif;
}

.note-editor.rtl-editor .note-editable h1,
.note-editor.rtl-editor .note-editable h2,
.note-editor.rtl-editor .note-editable h3 {
    font-family: 'Cairo', 'Tajawal', Arial, sans-serif;
    font-weight: bold;
}
```

### 2. **CSS للدعم LTR:**
```css
.note-editor.ltr-editor {
    direction: ltr;
    text-align: left;
}

.note-editor.ltr-editor .note-editable {
    direction: ltr;
    text-align: left;
    font-family: 'Roboto', 'Open Sans', 'Lato', Arial, sans-serif;
}
```

## 📁 الملفات المطلوبة

### 1. **ملفات JavaScript:**
```html
<script src="assets/plugins/summernote/summernote-bs4.min.js"></script>
<script src="assets/plugins/summernote/lang/summernote-ar-AR.min.js"></script>
```

### 2. **ملفات CSS:**
```html
<link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">
```

## 🔄 كيفية التطبيق

### 1. **للحقول الجديدة:**
```javascript
// للعربية
$('#new_field_ar').summernote({
    direction: 'rtl',
    lang: 'ar-AR',
    // باقي الإعدادات...
});

// للإنجليزية
$('#new_field_en').summernote({
    direction: 'ltr',
    lang: 'en-US',
    // باقي الإعدادات...
});
```

### 2. **في HTML:**
```html
<!-- الحقل العربي -->
<textarea id="description_ar" name="description_ar" class="form-control">
    <?= setting('description_ar') ?>
</textarea>

<!-- الحقل الإنجليزي -->
<textarea id="description_en" name="description_en" class="form-control">
    <?= setting('description_en') ?>
</textarea>
```

## 🎯 الخصائص المتقدمة

### 1. **شريط الأدوات الكامل:**
- **التنسيق**: عريض، مائل، تحته خط، يتوسطه خط
- **الخطوط**: اختيار نوع وحجم الخط
- **الألوان**: لون النص والخلفية
- **القوائم**: مرقمة وغير مرقمة
- **الجداول**: إدراج وتحرير الجداول
- **الوسائط**: روابط، صور، فيديو
- **العرض**: ملء الشاشة، عرض الكود

### 2. **الأنماط المخصصة:**
```javascript
styleTags: [
    'p',
    { title: 'عنوان رئيسي', tag: 'h1', className: 'h1' },
    { title: 'عنوان فرعي', tag: 'h2', className: 'h2' },
    { title: 'عنوان صغير', tag: 'h3', className: 'h3' },
    { title: 'نص مميز', tag: 'h4', className: 'h4' },
    { title: 'اقتباس', tag: 'blockquote', className: 'blockquote' }
]
```

### 3. **Callbacks مخصصة:**
```javascript
callbacks: {
    onInit: function() {
        $('.note-editor').addClass('rtl-editor');
        $('.note-editable').attr('dir', 'rtl');
    },
    onChange: function(contents) {
        // حفظ تلقائي أو معالجة التغييرات
    }
}
```

## 🔧 التخصيص المتقدم

### 1. **إضافة خطوط جديدة:**
```javascript
fontNames: [
    'Arial', 'Times New Roman', 'Helvetica',
    // خطوط عربية
    'Cairo', 'Tajawal', 'Amiri', 'Noto Sans Arabic', 'Scheherazade',
    // خطوط إنجليزية
    'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Source Sans Pro'
]
```

### 2. **تخصيص شريط الأدوات:**
```javascript
toolbar: [
    ['style', ['style']],
    ['font', ['bold', 'italic', 'underline', 'clear']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['forecolor', 'backcolor']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['table', ['table']],
    ['insert', ['link', 'picture', 'video', 'hr']],
    ['view', ['fullscreen', 'codeview', 'help']],
    ['misc', ['undo', 'redo']]
]
```

### 3. **إعدادات الصور:**
```javascript
popover: {
    image: [
        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
        ['float', ['floatLeft', 'floatRight', 'floatNone']],
        ['remove', ['removeMedia']]
    ]
}
```

## 📱 التوافق مع الأجهزة

### 1. **الشاشات الصغيرة:**
```css
@media (max-width: 768px) {
    .note-editor {
        font-size: 14px;
    }
    
    .note-toolbar {
        flex-wrap: wrap;
    }
    
    .note-btn {
        padding: 5px 8px;
        font-size: 12px;
    }
}
```

### 2. **الأجهزة اللوحية:**
- أزرار بحجم مناسب للمس
- شريط أدوات متجاوب
- محرر قابل للتمرير

## 🔍 استكشاف الأخطاء

### 1. **مشاكل الاتجاه:**
```javascript
// التأكد من تطبيق الاتجاه
callbacks: {
    onInit: function() {
        $('.note-editable').attr('dir', 'rtl');
        $('.note-editable').css('text-align', 'right');
    }
}
```

### 2. **مشاكل الخطوط:**
```css
/* التأكد من تحميل الخطوط */
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap');
```

### 3. **مشاكل الترجمة:**
```html
<!-- التأكد من تحميل ملف الترجمة -->
<script src="assets/plugins/summernote/lang/summernote-ar-AR.min.js"></script>
```

## 🚀 التطوير المستقبلي

### ميزات مخططة:
1. **دعم لغات إضافية** (فرنسية، ألمانية، إلخ)
2. **قوالب جاهزة** للمحتوى
3. **حفظ تلقائي** للمسودات
4. **معاينة مباشرة** للتنسيق
5. **تصدير** إلى PDF/Word

---
**محرر Summernote متعدد الاتجاهات جاهز للاستخدام! 🎉**

يوفر تجربة كتابة محسنة للغتين العربية والإنجليزية مع دعم كامل للاتجاهات والخطوط.
