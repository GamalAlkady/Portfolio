<?php

// ملف اختبار الروابط
echo "<h1>اختبار الروابط</h1>";

echo "<h2>الروابط المتاحة:</h2>";
echo "<ul>";
echo "<li><a href='/admin'>/admin</a></li>";
echo "<li><a href='/admin/dashboard'>/admin/dashboard</a></li>";
echo "<li><a href='/admin/settings'>/admin/settings</a></li>";
echo "<li><a href='/admin/projects'>/admin/projects</a></li>";
echo "<li><a href='/login'>/login</a></li>";
echo "</ul>";

echo "<h2>معلومات الطلب الحالي:</h2>";
echo "<p>REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p>REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "</p>";
echo "<p>PHP_SELF: " . $_SERVER['PHP_SELF'] . "</p>";

echo "<h2>ملفات الروابط:</h2>";
if (file_exists('routes/web.php')) {
    echo "<p>✅ ملف routes/web.php موجود</p>";
} else {
    echo "<p>❌ ملف routes/web.php غير موجود</p>";
}

echo "<h2>Controllers:</h2>";
if (file_exists('app/Http/Controllers/Admin/DashboardController.php')) {
    echo "<p>✅ DashboardController موجود</p>";
} else {
    echo "<p>❌ DashboardController غير موجود</p>";
}

if (file_exists('app/Http/Controllers/Admin/SettingsController.php')) {
    echo "<p>✅ SettingsController موجود</p>";
} else {
    echo "<p>❌ SettingsController غير موجود</p>";
}

echo "<h2>Views:</h2>";
if (file_exists('resources/views/Admin/dashboard.view.php')) {
    echo "<p>✅ dashboard.view.php موجود</p>";
} else {
    echo "<p>❌ dashboard.view.php غير موجود</p>";
}

if (file_exists('resources/views/Admin/settings/index.view.php')) {
    echo "<p>✅ settings/index.view.php موجود</p>";
} else {
    echo "<p>❌ settings/index.view.php غير موجود</p>";
}

?>
