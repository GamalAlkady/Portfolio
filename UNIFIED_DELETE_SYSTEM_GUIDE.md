# 🔄 دليل نظام الحذف الموحد

## 🎯 نظرة عامة

تم دمج دالة `deleteProject` مع `confirmDelete` لإنشاء نظام حذف موحد ومرن يدعم جميع أنواع العناصر والجداول.

## ✨ المزايا الجديدة

### 1. **دالة واحدة لجميع أنواع الحذف**
- حذف المشاريع، المستخدمين، الصور، إلخ
- دعم DataTable و الجداول العادية
- اكتشاف تلقائي لنوع الجدول

### 2. **مرونة في الاستخدام**
- خيارات متقدمة قابلة للتخصيص
- توافق مع الكود القديم
- إعدادات افتراضية ذكية

### 3. **تحسينات الأداء**
- كود أقل تكراراً
- معالجة أخطاء محسنة
- تأثيرات بصرية سلسة

## 🔧 الاستخدام الجديد

### 1. **الاستخدام البسيط (متوافق مع القديم):**
```javascript
// للتوافق مع الكود القديم
confirmDelete('csrf_token', '/delete/url', buttonElement, '/redirect/url');
```

### 2. **الاستخدام المتقدم (مع خيارات):**
```javascript
confirmDelete('csrf_token', '/delete/url', buttonElement, {
    tableId: 'projectsTable',        // معرف الجدول
    itemName: 'المشروع',             // اسم العنصر للرسائل
    updateCounter: true,             // تحديث العداد
    reloadPage: false,               // عدم إعادة تحميل الصفحة
    fadeEffect: true,                // تأثير fade
    showSuccessTimer: true,          // مؤقت رسالة النجاح
    targetUrl: '/redirect/url'       // رابط إعادة التوجيه
});
```

### 3. **الاستخدام التلقائي (بدون تحديد tableId):**
```javascript
// سيكتشف الجدول تلقائياً
confirmDelete('csrf_token', '/delete/url', buttonElement, {
    itemName: 'المشروع',
    updateCounter: true,
    reloadPage: false
});
```

## 📋 خيارات التخصيص

### الخيارات المتاحة:
```javascript
const options = {
    // إعدادات الجدول
    tableId: 'myTable',              // معرف الجدول (null = اكتشاف تلقائي)
    
    // إعدادات الرسائل
    itemName: 'العنصر',              // اسم العنصر في الرسائل
    
    // إعدادات السلوك
    reloadPage: true,                // إعادة تحميل الصفحة (true/false)
    targetUrl: '',                   // رابط إعادة التوجيه
    
    // إعدادات التأثيرات
    fadeEffect: true,                // تأثير fade للصف (true/false)
    showSuccessTimer: true,          // مؤقت رسالة النجاح (true/false)
    
    // إعدادات العداد
    updateCounter: false             // تحديث عداد العناصر (true/false)
};
```

## 🎨 أمثلة عملية

### 1. **حذف مشروع من DataTable:**
```html
<button onclick="confirmDelete('<?= getCsrf() ?>', '/admin/projects/123/delete', this, {
    tableId: 'projectsTable',
    itemName: 'المشروع',
    updateCounter: true,
    reloadPage: false
})" class="btn btn-danger btn-sm">
    <i class="fas fa-trash"></i>
</button>
```

### 2. **حذف مستخدم:**
```html
<button onclick="confirmDelete('<?= getCsrf() ?>', '/admin/users/456/delete', this, {
    tableId: 'usersTable',
    itemName: 'المستخدم',
    updateCounter: true,
    reloadPage: false
})" class="btn btn-danger btn-sm">
    <i class="fas fa-user-times"></i>
</button>
```

### 3. **حذف صورة (بدون جدول):**
```html
<button onclick="confirmDelete('<?= getCsrf() ?>', '/admin/images/789/delete', this, {
    itemName: 'الصورة',
    reloadPage: true
})" class="btn btn-danger btn-sm">
    <i class="fas fa-image"></i>
</button>
```

### 4. **حذف من جدول عادي (ليس DataTable):**
```html
<button onclick="confirmDelete('<?= getCsrf() ?>', '/admin/items/999/delete', this, {
    itemName: 'العنصر',
    fadeEffect: true,
    reloadPage: false
})" class="btn btn-danger btn-sm">
    <i class="fas fa-trash"></i>
</button>
```

## 🔄 التحديث من النظام القديم

### قبل التحديث:
```javascript
// الطريقة القديمة
function deleteProject(projectId, buttonElement) {
    // كود طويل ومكرر...
}

// في HTML
<button onclick="deleteProject(123, this)">حذف</button>
```

### بعد التحديث:
```javascript
// لا حاجة لدالة منفصلة - استخدم confirmDelete مباشرة

// في HTML
<button onclick="confirmDelete('<?= getCsrf() ?>', '/admin/projects/123/delete', this, {
    tableId: 'projectsTable',
    itemName: 'المشروع',
    updateCounter: true,
    reloadPage: false
})">حذف</button>
```

## 🛠️ الدوال المساعدة الجديدة

### 1. **autoDetectAndDeleteRow():**
- تكتشف نوع الجدول تلقائياً
- تحذف الصف بالطريقة المناسبة
- تطبق التأثيرات البصرية

### 2. **deleteRowFromTable():**
- تحذف الصف من DataTable
- تحدث العداد
- تعرض الحالة الفارغة عند الحاجة

### 3. **resetButton():**
- تعيد تفعيل الزر بعد الخطأ
- تستعيد النص الأصلي للزر

### 4. **updateItemsCount():**
- تحدث عداد العناصر
- تحدث عنوان الصفحة
- تعرض الحالة الفارغة

### 5. **showEmptyState():**
- تعرض رسالة عندما لا توجد عناصر
- تصميم جذاب ومتجاوب

## 📊 مقارنة الأداء

### قبل التحديث:
- ✅ دالة منفصلة لكل نوع حذف
- ❌ كود مكرر (200+ سطر لكل دالة)
- ❌ صعوبة في الصيانة
- ❌ رسائل غير موحدة

### بعد التحديث:
- ✅ دالة واحدة لجميع أنواع الحذف
- ✅ كود مشترك (50 سطر لكل استخدام)
- ✅ سهولة في الصيانة
- ✅ رسائل موحدة ومترجمة

## 🔒 الأمان والموثوقية

### 1. **معالجة الأخطاء:**
```javascript
// معالجة شاملة للأخطاء
.catch(error => {
    console.error('Error:', error);
    Swal.fire(__('error'), __('network_error'), 'error');
    resetButton(buttonElement);
});
```

### 2. **التحقق من الوجود:**
```javascript
// التحقق من وجود العناصر قبل التعامل معها
if (buttonElement) {
    buttonElement.disabled = true;
}

if ($.fn.DataTable && $(table).hasClass('dataTable')) {
    // كود DataTable
}
```

### 3. **التراجع الآمن:**
```javascript
// في حالة فشل الحذف من DataTable، جرب الحذف المباشر
catch (error) {
    console.error('Error removing row from table:', error);
    autoDetectAndDeleteRow(buttonElement, settings);
}
```

## 🎯 أفضل الممارسات

### 1. **استخدم أسماء واضحة للعناصر:**
```javascript
itemName: 'المشروع'     // ✅ واضح
itemName: 'العنصر'      // ❌ عام
```

### 2. **حدد tableId عند الإمكان:**
```javascript
tableId: 'projectsTable'  // ✅ محدد
tableId: null             // ❌ يعتمد على الاكتشاف التلقائي
```

### 3. **استخدم updateCounter للجداول:**
```javascript
updateCounter: true       // ✅ للجداول
updateCounter: false      // ✅ للعناصر المفردة
```

### 4. **اختر reloadPage بحكمة:**
```javascript
reloadPage: false         // ✅ للجداول (أسرع)
reloadPage: true          // ✅ للصفحات البسيطة
```

## 🚀 التطوير المستقبلي

### ميزات مخططة:
1. **دعم التراجع (Undo):**
   ```javascript
   showUndoOption: true
   ```

2. **حذف متعدد:**
   ```javascript
   multiSelect: true
   ```

3. **تأكيد مزدوج للعناصر المهمة:**
   ```javascript
   doubleConfirm: true
   ```

4. **إحصائيات الحذف:**
   ```javascript
   trackDeletion: true
   ```

---
**نظام الحذف الموحد جاهز للاستخدام! 🎉**

دالة واحدة، إمكانيات لا محدودة، وتجربة مستخدم محسنة.
