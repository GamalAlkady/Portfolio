<?php
/**
 * أمثلة على استخدام قوالب الإيميل
 * Email Templates Usage Examples
 */

require_once 'app/Templates/EmailTemplates.php';

use App\Templates\EmailTemplates;

echo "📧 أمثلة على استخدام قوالب الإيميل\n";
echo "=" . str_repeat("=", 50) . "\n\n";

// مثال 1: إرسال إيميل جهة الاتصال
echo "1️⃣ مثال إيميل جهة الاتصال:\n";
echo "=" . str_repeat("-", 30) . "\n";

$contactData = [
    'name' => 'أحمد محمد',
    'email' => 'ahmed@example.com',
    'phone' => '+966501234567',
    'message' => 'مرحباً، أريد الاستفسار عن خدماتكم المتاحة. هل يمكنكم تزويدي بمزيد من المعلومات؟',
    'site_name' => 'موقع البورتفوليو'
];

// إنشاء الإيميل بالعربية
$arabicContactEmail = EmailTemplates::contactEmailArabic($contactData);

// إنشاء الإيميل بالإنجليزية
$englishContactData = [
    'name' => 'Ahmed Mohammed',
    'email' => 'ahmed@example.com',
    'phone' => '+966501234567',
    'message' => 'Hello, I would like to inquire about your available services. Can you provide me with more information?',
    'site_name' => 'Portfolio Website'
];
$englishContactEmail = EmailTemplates::contactEmailEnglish($englishContactData);

echo "✅ تم إنشاء قالب إيميل جهة الاتصال بالعربية والإنجليزية\n\n";

// مثال 2: إرسال إيميل ترحيب
echo "2️⃣ مثال إيميل الترحيب:\n";
echo "=" . str_repeat("-", 30) . "\n";

$welcomeData = [
    'name' => 'سارة أحمد',
    'site_name' => 'منصة التعلم الإلكتروني',
    'site_url' => 'https://example.com'
];

$arabicWelcomeEmail = EmailTemplates::welcomeEmailArabic($welcomeData);

$englishWelcomeData = [
    'name' => 'Sarah Ahmed',
    'site_name' => 'E-Learning Platform',
    'site_url' => 'https://example.com'
];
$englishWelcomeEmail = EmailTemplates::welcomeEmailEnglish($englishWelcomeData);

echo "✅ تم إنشاء قالب إيميل الترحيب بالعربية والإنجليزية\n\n";

// مثال 3: إرسال إيميل إشعار
echo "3️⃣ مثال إيميل الإشعار:\n";
echo "=" . str_repeat("-", 30) . "\n";

$notificationData = [
    'title' => 'تحديث مهم في النظام',
    'message' => 'تم تحديث النظام بميزات جديدة. يرجى مراجعة التحديثات الجديدة والاستفادة من الميزات المضافة.',
    'site_name' => 'نظام الإدارة',
    'action_url' => 'https://example.com/updates',
    'action_text' => 'عرض التحديثات'
];

$arabicNotificationEmail = EmailTemplates::notificationEmailArabic($notificationData);

$englishNotificationData = [
    'title' => 'Important System Update',
    'message' => 'The system has been updated with new features. Please review the new updates and take advantage of the added features.',
    'site_name' => 'Management System',
    'action_url' => 'https://example.com/updates',
    'action_text' => 'View Updates'
];
$englishNotificationEmail = EmailTemplates::notificationEmailEnglish($englishNotificationData);

echo "✅ تم إنشاء قالب إيميل الإشعار بالعربية والإنجليزية\n\n";

// مثال 4: استخدام الدوال المساعدة
echo "4️⃣ مثال استخدام الدوال المساعدة:\n";
echo "=" . str_repeat("-", 30) . "\n";

// استخدام دالة مساعدة لاختيار اللغة
$contactEmailAuto = EmailTemplates::getContactEmail($contactData, 'ar');
$welcomeEmailAuto = EmailTemplates::getWelcomeEmail($welcomeData, 'en');
$notificationEmailAuto = EmailTemplates::getNotificationEmail($notificationData, 'ar');

echo "✅ تم استخدام الدوال المساعدة لاختيار القوالب حسب اللغة\n\n";

// مثال 5: إرسال إيميل كامل (محاكاة)
echo "5️⃣ مثال إرسال إيميل كامل:\n";
echo "=" . str_repeat("-", 30) . "\n";

echo "📝 ملاحظة: هذا مثال محاكاة، لن يتم إرسال إيميل فعلي\n";

// بيانات الإرسال
$emailData = [
    'name' => 'محمد علي',
    'email' => 'mohammed@example.com',
    'message' => 'شكراً لكم على الخدمة الممتازة'
];

$recipientEmail = 'admin@example.com';
$language = 'ar';

echo "البيانات:\n";
echo "- النوع: contact\n";
echo "- المستقبل: $recipientEmail\n";
echo "- اللغة: $language\n";
echo "- الاسم: {$emailData['name']}\n";

// محاكاة الإرسال
echo "🔄 محاكاة إرسال الإيميل...\n";

try {
    // هنا يمكن استخدام:
    // $result = EmailTemplates::sendTemplatedEmail('contact', $emailData, $recipientEmail, $language);
    
    echo "✅ تم إنشاء الإيميل بنجاح (محاكاة)\n";
    echo "📧 الموضوع: رسالة جديدة من الموقع\n";
    echo "📤 المرسل إليه: $recipientEmail\n";
    
} catch (Exception $e) {
    echo "❌ خطأ في الإرسال: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("=", 52) . "\n";
echo "🎉 انتهت أمثلة استخدام قوالب الإيميل\n";

echo "\n📋 ملخص القوالب المتاحة:\n";
echo "   ✅ قالب جهة الاتصال (عربي/إنجليزي)\n";
echo "   ✅ قالب الترحيب (عربي/إنجليزي)\n";
echo "   ✅ قالب الإشعارات (عربي/إنجليزي)\n";
echo "   ✅ دوال مساعدة لاختيار اللغة\n";
echo "   ✅ دالة إرسال شاملة\n";

echo "\n🚀 كيفية الاستخدام في المشروع:\n";
echo "   1. تضمين ملف القوالب\n";
echo "   2. تحضير البيانات المطلوبة\n";
echo "   3. اختيار نوع القالب واللغة\n";
echo "   4. إرسال الإيميل\n";

echo "\n📖 مثال سريع:\n";
echo "   \$result = EmailTemplates::sendTemplatedEmail(\n";
echo "       'contact',\n";
echo "       ['name' => 'أحمد', 'email' => 'ahmed@example.com'],\n";
echo "       'admin@example.com',\n";
echo "       'ar'\n";
echo "   );\n";

echo "\n📚 راجع ملف EmailTemplates.php للمزيد من التفاصيل\n";
?>
