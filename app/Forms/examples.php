<?php
// تأكد من تضمين جميع الكلاسات والدوال المساعدة
require_once 'Toaster.php';
require_once 'Field.php';
require_once 'Input.php';
require_once 'Textarea.php';
require_once 'Select.php';

// إنشاء كائن Form واحد (أو يمكنك جعله ثابتًا إذا أردت)
$form = new Form();

// مثال على فتح نموذج
echo $form->openForm(['action' => 'submit.php', 'method' => 'post', 'class' => 'my-form'])->render();

// استخدام كلاس Input لحقل نصي
echo $form->input('username', 'اسم المستخدم')
          ->value('جون دو')
          ->type('text')
          ->attrs(['required' => true, 'placeholder' => 'أدخل اسم المستخدم'])
          ->formGroupClass('col-md-6')
          ->class('custom-input')
          ->render();

// استخدام كلاس Input لحقل كلمة مرور
echo $form->input('password', 'كلمة المرور')
          ->type('password')
          ->attrs(['required' => true])
          ->render();

// استخدام كلاس Input لحقل ملف
echo $form->fileInput('profile_picture', 'صورة الملف الشخصي')
          ->value('صورة_شخصية.jpg')
          ->render();

// استخدام كلاس Input لحقل اختيار لون
echo $form->colorPicker('header_color', 'لون الترويسة')
          ->value('#3498db')
          ->render();

// استخدام كلاس Input لحقل تاريخ
echo $form->dateInput('event_date', 'تاريخ الحدث')
          ->value('2024-08-15')
          ->render();

// استخدام كلاس Input لحقل تاريخ ووقت
echo $form->datetimeInput('appointment_time', 'وقت الموعد')
          ->value('2024-08-15 10:00')
          ->render();

// استخدام كلاس Textarea
echo $form->textarea('description', 'الوصف التفصيلي')
          ->value('هذا وصف مفصل للمنتج أو الخدمة التي تقدمها.')
          ->attrs(['rows' => 5, 'data-maxlength' => 500])
          ->textareaClass('tinymce') // إذا كنت تستخدم TinyMCE
          ->render();

// استخدام كلاس Select

$categories = ['Web Development', 'Mobile App', 'Desktop App', 'UI/UX Design', 'Other'];

// استخدام Select مع المصفوفة البسيطة مباشرةً
echo $form->select(
    'category_selection', // اسم حقل الـ select
    $categories, // المصفوفة البسيطة مباشرةً
    [], // لا حاجة لتحديد option_attrs إذا كانت بسيطة (ستفترض 'id' و 'name' بنفس القيمة)
    'اختر الفئة' // تسمية الحقل
)->selected('Mobile App') // اختيار قيمة افتراضية (يجب أن تتطابق مع قيمة في المصفوفة الأصلية)
->attrs(['data-live-search' => 'true']) // سمات إضافية
->render();

// مثال آخر مع مصفوفة ترابطية (لا يزال يعمل كما كان)
$users = [
    ['id' => 1, 'name' => 'أحمد', 'email' => 'ahmed@example.com'],
    ['id' => 2, 'name' => 'فاطمة', 'email' => 'fatma@example.com'],
];
echo $form->select(
    'user_id',
    $users,
    ['id', 'name', 'email'], // قيمة، نص، نص فرعي
    'اختر المستخدم'
)->selected(2)
    ->render();

$countries = [
    ['id' => 'sa', 'name' => 'المملكة العربية السعودية'],
    ['id' => 'eg', 'name' => 'مصر'],
    ['id' => 'jo', 'name' => 'الأردن']
];
echo $form->select('country', $countries, ['id', 'name'], 'اختر البلد')
          ->selected('eg')
          ->attrs(['data-live-search' => 'true'])
          ->formGroupClass('col-md-4')
          ->render();

// استخدام Select مع input group
echo $form->select('currency', [['id' => 'usd', 'name' => 'دولار أمريكي'], ['id' => 'eur', 'name' => 'يورو']], ['id', 'name'], 'العملة')
          ->selected('usd')
          ->withInputGroup('<span class="input-group-text">$</span>')
          ->render();

// استخدام حقل حالة طلب التقدير (لا يزال في Form لأنه يتعامل مع منطق خاص بالبيانات)
$statuses = [
    ['id' => 1, 'name' => 'معلق', 'flag' => 'pending'],
    ['id' => 2, 'name' => 'قيد المعالجة', 'flag' => 'processing'],
    ['id' => 3, 'name' => 'مكتمل', 'flag' => 'completed']
];
echo $form->estimateRequestStatusSelect($statuses, '', 'حالة الطلب', 'request_status')->render();

// حقل Checkbox (لا يزال في Form لأنه مجموعة من العناصر وليس عنصر واحد)
$checkbox_items = ['apple' => 'تفاح', 'banana' => 'موز', 'orange' => 'برتقال'];
$checked_fruits = ['banana', 'orange'];
echo $form->checkbox(
    ['class' => 'form-check-input'],
    $checkbox_items,
    $checked_fruits,
    'class="form-check"'
)->render();

// حقل Yes/No Option (لا يزال في Form لأنه يتعامل مع منطق خاص بالراديو بوتون)
echo $form->yesNoOption(
    'send_notifications',
    'إرسال الإشعارات',
    'هل تريد تلقي إشعارات؟',
    false,
    'نعم',
    'لا',
    '1'
)->render();


// زر الإرسال
echo $form->button(['type' => 'submit', 'class' => 'btn btn-primary mt-3'], 'إرسال النموذج', '<i class="fas fa-paper-plane me-2"></i>')->render();

// إغلاق النموذج
echo $form->closeForm()->render();

?>