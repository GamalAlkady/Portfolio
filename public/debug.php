<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة اختبار النظام</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .info { color: #007bff; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .links a { display: inline-block; margin: 5px; padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .links a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 صفحة اختبار النظام</h1>
        
        <div class="section">
            <h2>📊 معلومات الخادم</h2>
            <p><strong>الوقت:</strong> <?= date('Y-m-d H:i:s') ?></p>
            <p><strong>مجلد العمل:</strong> <?= getcwd() ?></p>
            <p><strong>REQUEST_URI:</strong> <?= $_SERVER['REQUEST_URI'] ?? 'غير محدد' ?></p>
            <p><strong>REQUEST_METHOD:</strong> <?= $_SERVER['REQUEST_METHOD'] ?? 'غير محدد' ?></p>
            <p><strong>إصدار PHP:</strong> <?= phpversion() ?></p>
        </div>

        <div class="section">
            <h2>📁 فحص الملفات</h2>
            <?php
            $files = [
                '../routes/web.php' => 'ملف الروابط',
                '../app/Http/Controllers/Admin/DashboardController.php' => 'Dashboard Controller',
                '../app/Http/Controllers/Admin/SettingsController.php' => 'Settings Controller',
                '../resources/views/Admin/dashboard.view.php' => 'Dashboard View',
                '../resources/views/Admin/settings/index.view.php' => 'Settings View',
                '../app/Models/Settings.php' => 'Settings Model',
                '../public/.htaccess' => 'ملف .htaccess'
            ];
            
            foreach ($files as $file => $name) {
                if (file_exists($file)) {
                    echo "<p class='success'>✅ $name موجود</p>";
                } else {
                    echo "<p class='error'>❌ $name غير موجود</p>";
                }
            }
            ?>
        </div>

        <div class="section">
            <h2>🗄️ فحص قاعدة البيانات</h2>
            <?php
            try {
                $pdo = new PDO("mysql:host=localhost;dbname=profolio;charset=utf8mb4", "root", "");
                echo "<p class='success'>✅ الاتصال بقاعدة البيانات ناجح</p>";
                
                // فحص الجداول
                $tables = ['users', 'projects', 'skills', 'settings'];
                foreach ($tables as $table) {
                    $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
                    if ($stmt->rowCount() > 0) {
                        echo "<p class='success'>✅ جدول $table موجود</p>";
                    } else {
                        echo "<p class='error'>❌ جدول $table غير موجود</p>";
                    }
                }
                
            } catch (PDOException $e) {
                echo "<p class='error'>❌ خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage() . "</p>";
            }
            ?>
        </div>

        <div class="section">
            <h2>🔐 فحص حالة تسجيل الدخول</h2>
            <?php
            session_start();
            if (isset($_SESSION['users'])) {
                echo "<p class='success'>✅ المستخدم مسجل دخول: " . ($_SESSION['users']['name'] ?? 'غير محدد') . "</p>";
            } else {
                echo "<p class='info'>ℹ️ المستخدم غير مسجل دخول</p>";
            }
            ?>
        </div>

        <div class="section">
            <h2>🔗 روابط الاختبار</h2>
            <div class="links">
                <h3>روابط بدون تسجيل دخول:</h3>
                <a href="/test/dashboard">اختبار Dashboard</a>
                <a href="/test/settings">اختبار Settings</a>
                <a href="/login">صفحة تسجيل الدخول</a>
                <a href="/">الصفحة الرئيسية</a>
                
                <h3>روابط تتطلب تسجيل دخول:</h3>
                <a href="/admin">لوحة الإدارة</a>
                <a href="/admin/dashboard">Dashboard</a>
                <a href="/admin/settings">الإعدادات</a>
                <a href="/admin/projects">المشاريع</a>
                <a href="/logout">تسجيل خروج</a>
            </div>
        </div>

        <div class="section">
            <h2>⚙️ إعدادات الخادم</h2>
            <p><strong>Document Root:</strong> <?= $_SERVER['DOCUMENT_ROOT'] ?? 'غير محدد' ?></p>
            <p><strong>Server Name:</strong> <?= $_SERVER['SERVER_NAME'] ?? 'غير محدد' ?></p>
            <p><strong>Server Port:</strong> <?= $_SERVER['SERVER_PORT'] ?? 'غير محدد' ?></p>
            <p><strong>HTTPS:</strong> <?= isset($_SERVER['HTTPS']) ? 'مفعل' : 'غير مفعل' ?></p>
        </div>

        <div class="section">
            <h2>🔧 حلول المشاكل الشائعة</h2>
            <div style="background: #f8f9fa; padding: 15px; border-radius: 5px;">
                <h4>إذا كنت تواجه خطأ 404:</h4>
                <ol>
                    <li>تأكد من تشغيل الخادم من مجلد public: <code>cd public && php -S 127.0.0.1:8000</code></li>
                    <li>أو استخدم: <code>composer start</code></li>
                    <li>تأكد من أن ملف .htaccess صحيح</li>
                    <li>جرب الروابط بدون middleware أولاً</li>
                </ol>
                
                <h4>إذا كنت تواجه مشكلة في تسجيل الدخول:</h4>
                <ol>
                    <li>تأكد من وجود جدول users في قاعدة البيانات</li>
                    <li>تأكد من وجود مستخدم في الجدول</li>
                    <li>جرب إنشاء مستخدم جديد</li>
                </ol>
            </div>
        </div>

        <div class="section">
            <h2>📝 ملاحظات</h2>
            <ul>
                <li>استخدم روابط الاختبار أولاً للتأكد من عمل النظام</li>
                <li>بعد التأكد من عمل النظام، سجل دخولك واستخدم الروابط العادية</li>
                <li>إذا كانت صفحة الإعدادات تعمل، تأكد من تشغيل SQL لإنشاء جدول settings</li>
                <li>يمكنك حذف هذا الملف بعد انتهاء الاختبار</li>
            </ul>
        </div>
    </div>
</body>
</html>
