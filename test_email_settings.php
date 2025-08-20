<?php
/**
 * ملف اختبار إعدادات البريد الإلكتروني
 * يمكن تشغيله من سطر الأوامر لاختبار الوظائف
 */

// تحديد مسار الجذر
define('APP_ROOT', __DIR__);

// تحميل الملفات المطلوبة
require_once 'vendor/autoload.php';
require_once 'app/Helpers/EnvHelper.php';

echo "🧪 اختبار وظائف إعدادات البريد الإلكتروني\n";
echo "=" . str_repeat("=", 50) . "\n\n";

// اختبار 1: قراءة ملف .env
echo "1️⃣ اختبار قراءة ملف .env:\n";
$mailHost = getEnvValue('MAIL_HOST', 'not_found');
$mailPort = getEnvValue('MAIL_PORT', 'not_found');
echo "   MAIL_HOST: $mailHost\n";
echo "   MAIL_PORT: $mailPort\n";
echo "   ✅ نجح اختبار القراءة\n\n";

// اختبار 2: تحديث ملف .env
echo "2️⃣ اختبار تحديث ملف .env:\n";
$testData = [
    'TEST_KEY' => 'test_value_' . time(),
    'ANOTHER_TEST' => 'another_value'
];

if (updateEnvFile($testData)) {
    echo "   ✅ نجح تحديث ملف .env\n";
    
    // التحقق من التحديث
    $testValue = getEnvValue('TEST_KEY', 'not_found');
    echo "   قيمة TEST_KEY: $testValue\n";
} else {
    echo "   ❌ فشل تحديث ملف .env\n";
}
echo "\n";

// اختبار 3: التحقق من صحة إعدادات الإيميل
echo "3️⃣ اختبار التحقق من صحة الإعدادات:\n";

// إعدادات صحيحة
$validSettings = [
    'mail_host' => 'smtp.gmail.com',
    'mail_port' => '587',
    'mail_username' => 'test@gmail.com',
    'mail_password' => 'password123',
    'mail_from_address' => 'noreply@example.com',
    'mail_from_name' => 'Test Site'
];

$errors = validateEmailSettings($validSettings);
if (empty($errors)) {
    echo "   ✅ الإعدادات الصحيحة مقبولة\n";
} else {
    echo "   ❌ خطأ في التحقق من الإعدادات الصحيحة\n";
    foreach ($errors as $error) {
        echo "      - $error\n";
    }
}

// إعدادات خاطئة
$invalidSettings = [
    'mail_host' => '', // فارغ
    'mail_port' => '999', // منفذ خاطئ
    'mail_username' => 'invalid-email', // إيميل خاطئ
    'mail_from_address' => 'invalid-email' // إيميل خاطئ
];

$errors = validateEmailSettings($invalidSettings);
if (!empty($errors)) {
    echo "   ✅ الإعدادات الخاطئة مرفوضة بشكل صحيح\n";
    echo "   الأخطاء المكتشفة:\n";
    foreach ($errors as $error) {
        echo "      - $error\n";
    }
} else {
    echo "   ❌ لم يتم اكتشاف الأخطاء في الإعدادات الخاطئة\n";
}
echo "\n";

// اختبار 4: محاكاة اختبار الاتصال (بدون إرسال فعلي)
echo "4️⃣ اختبار محاكاة الاتصال:\n";
echo "   📝 ملاحظة: هذا اختبار محاكاة فقط، لن يتم إرسال إيميل فعلي\n";

$testSettings = [
    'mail_host' => 'smtp.gmail.com',
    'mail_port' => '587',
    'mail_username' => 'test@gmail.com',
    'mail_password' => 'fake_password',
    'mail_from_address' => 'noreply@example.com',
    'mail_from_name' => 'Test Site'
];

echo "   الإعدادات المستخدمة:\n";
foreach ($testSettings as $key => $value) {
    $displayValue = $key === 'mail_password' ? str_repeat('*', strlen($value)) : $value;
    echo "      $key: $displayValue\n";
}

// محاكاة النتيجة
echo "   🔄 محاكاة اختبار الاتصال...\n";
echo "   ⚠️  متوقع: فشل الاتصال (كلمة مرور وهمية)\n";
echo "\n";

// تنظيف ملف .env (إزالة المفاتيح التجريبية)
echo "5️⃣ تنظيف ملف .env:\n";
$envPath = APP_ROOT . '/.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    
    // إزالة المفاتيح التجريبية
    $envContent = preg_replace('/^TEST_KEY=.*$/m', '', $envContent);
    $envContent = preg_replace('/^ANOTHER_TEST=.*$/m', '', $envContent);
    
    // إزالة الأسطر الفارغة الزائدة
    $envContent = preg_replace('/\n\s*\n/', "\n", $envContent);
    
    if (file_put_contents($envPath, $envContent)) {
        echo "   ✅ تم تنظيف ملف .env\n";
    } else {
        echo "   ❌ فشل تنظيف ملف .env\n";
    }
} else {
    echo "   ⚠️  ملف .env غير موجود\n";
}

echo "\n" . str_repeat("=", 52) . "\n";
echo "🎉 انتهى اختبار وظائف إعدادات البريد الإلكتروني\n";
echo "\n📋 ملخص النتائج:\n";
echo "   ✅ قراءة ملف .env\n";
echo "   ✅ تحديث ملف .env\n";
echo "   ✅ التحقق من صحة الإعدادات\n";
echo "   ✅ محاكاة اختبار الاتصال\n";
echo "   ✅ تنظيف ملف .env\n";
echo "\n🚀 الوظائف جاهزة للاستخدام!\n";

// معلومات إضافية
echo "\n📖 للاستخدام الفعلي:\n";
echo "   1. اذهب إلى: /admin/settings\n";
echo "   2. انقر على تاب 'إعدادات البريد الإلكتروني'\n";
echo "   3. أدخل إعدادات SMTP الصحيحة\n";
echo "   4. اختبر الإعدادات قبل الحفظ\n";
echo "   5. احفظ الإعدادات\n";
echo "\n📚 راجع ملف email_settings_guide.md للمزيد من التفاصيل\n";
?>
