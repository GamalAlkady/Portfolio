# دليل تطبيق دالة الترجمة

## ما تم إنجازه

### 1. تحديث ملفات الترجمة
- ✅ تم تحديث `resources/lang/ar/messages.php` بإضافة ترجمات جديدة
- ✅ تم تحديث `resources/lang/en/messages.php` بإضافة ترجمات جديدة

### 2. تطبيق دالة الترجمة على الملفات
- ✅ `resources/views/Admin/projects/add.view.php` - كان يستخدم الترجمة مسبقاً
- ✅ `resources/views/Admin/projects/edit.view.php` - تم تطبيق الترجمة
- ✅ `resources/views/Admin/projects/index.view.php` - تم تطبيق الترجمة جزئياً

## الملفات التي تحتاج تطبيق الترجمة

### ملفات المشاريع
- `resources/views/Admin/projects/details.view.php`

### ملفات أخرى في Admin
- `resources/views/Admin/dashboard.view.php`
- `resources/views/Admin/profile.view.php`
- `resources/views/Admin/skills/` (جميع الملفات)

### ملفات العرض العامة
- `resources/views/index.view.php`
- `resources/views/projects.view.php`
- `resources/views/projects/show.view.php`
- `resources/views/login.view.php`

### ملفات الأخطاء
- `resources/views/errors/401.view.php`
- `resources/views/errors/403.view.php`
- `resources/views/errors/404.view.php`
- `resources/views/errors/419.view.php`
- `resources/views/errors/429.view.php`
- `resources/views/errors/500.view.php`
- `resources/views/errors/503.view.php`

### ملفات التخطيط (Layout)
- `resources/views/layout/header.view.php` - تم تطبيق الترجمة جزئياً
- `resources/views/layout/footer.view.php`
- `resources/views/layout/admin/navbar.view.php` - تم تطبيق الترجمة جزئياً
- `resources/views/layout/admin/sidebar.view.php`

## كيفية تطبيق الترجمة

### الخطوات الأساسية:

1. **تحديد النصوص التي تحتاج ترجمة**
   - النصوص المكتوبة مباشرة في HTML
   - النصوص في placeholder
   - النصوص في value
   - النصوص في title و alt

2. **استبدال النص بدالة الترجمة**
   ```php
   // قبل
   <h1>Add Project</h1>
   
   // بعد
   <h1><?= __("add_project") ?></h1>
   ```

3. **إضافة الترجمة إلى ملفات اللغة**
   ```php
   // في resources/lang/ar/messages.php
   'add_project' => 'إضافة مشروع',
   
   // في resources/lang/en/messages.php
   'add_project' => 'Add Project',
   ```

### أمثلة شائعة:

#### النصوص في العناوين
```php
// قبل
<title>Projects</title>

// بعد
<title><?= __("projects") ?></title>
```

#### النصوص في الأزرار
```php
// قبل
<button>Save</button>

// بعد
<button><?= __("save") ?></button>
```

#### النصوص في placeholder
```php
// قبل
<input placeholder="Enter your name">

// بعد
<input placeholder="<?= __("enter_your_name") ?>">
```

#### النصوص في جداول البيانات
```php
// قبل
<th>Title</th>
<th>Description</th>

// بعد
<th><?= __("title") ?></th>
<th><?= __("Description") ?></th>
```

## الترجمات المتوفرة حالياً

### الترجمات العامة
- `home` - الرئيسية / Home
- `about` - عنا / About
- `contact` - اتصل بنا / Contact
- `projects` - المشاريع / Projects
- `dashboard` - لوحة التحكم / Dashboard
- `settings` - الإعدادات / Settings
- `profile` - الملف الشخصي / Profile

### ترجمات المشاريع
- `add_project` - إضافة مشروع / Add Project
- `edit_project` - تعديل مشروع / Edit Project
- `title` - العنوان / Title
- `Description` - الوصف / Description
- `category` - التصنيف / Category
- `actions` - الإجراءات / Actions
- `save` - حفظ / Save

### ترجمات التقنيات
- `technologies_used` - التقنيات المستخدمة / Technologies Used
- `host_url` - رابط الاستضافة / Host URL
- `github_url` - رابط GitHub / GitHub URL

## نصائح مهمة

1. **استخدم مفاتيح واضحة ومفهومة**
   - `add_project` أفضل من `ap`
   - `enter_project_title` أفضل من `ept`

2. **حافظ على التناسق**
   - استخدم نفس المفتاح للنص نفسه في جميع الملفات

3. **تجنب الترجمة المزدوجة**
   - لا تضع `__()` داخل `__()`

4. **اختبر الترجمة**
   - تأكد من عمل تبديل اللغة بشكل صحيح

## الخطوات التالية

1. **تطبيق الترجمة على الملفات المتبقية**
2. **إضافة الترجمات المفقودة إلى ملفات اللغة**
3. **اختبار جميع الصفحات مع اللغتين**
4. **إضافة ترجمات JavaScript إذا لزم الأمر**

## أدوات مساعدة

- `translation_helper.php` - يحتوي على قائمة بالترجمات الشائعة
- يمكن استخدامه للحصول على مفاتيح الترجمة المناسبة

## مثال كامل

```php
<?php setTitle(__("add_project")); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= __("add_project") ?></h1>
                </div>
            </div>
        </div>
    </div>
    
    <section class="content">
        <div class="container-fluid">
            <div class="card p-5">
                <form>
                    <input type="text" 
                           name="title" 
                           placeholder="<?= __("enter_project_title") ?>"
                           required>
                    
                    <button type="submit">
                        <?= __("save") ?>
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
```
