<?php

use Devamirul\PhpMicro\core\Foundation\Session\Session;

// تحميل مساعد الترجمة
require_once __DIR__ . '/TranslationHelper.php';

if (!function_exists('getCsrf')) {
    function getCsrf(): string
    {
        if (!Session::singleton()->has('csrf')) {
            Session::singleton()->set('csrf', bin2hex(random_bytes(50)));
        }
        return Session::singleton()->get('csrf');
    }
}

if (!function_exists('public_path')) {
    function public_path($path = '')
    {
        return dirname(__DIR__, 2) . '/public' . ($path ? '/' . ltrim($path, '/') : '');
    }
}

if (!function_exists('resource_path')) {
    function resource_path($path = '')
    {
        return dirname(__DIR__, 2) . '/resources' . ($path ? '/' . ltrim($path, '/') : '');
    }
}

if (!function_exists('includeView')) {
    /**
     * This function loads a view and extracts an array of data
     * into local variables.
     *
     * @param string $path The path to the view, relative to the resources/views directory.
     * @param array $data An optional array of data to be extracted into local variables.
     */
    function includeView($path, $data = [])
    {
        // استخراج المتغيرات كمصفوفات إلى متغيرات محلية
        extract($data);

        // تحديد المسار الكامل إلى الملف المطلوب
        $viewPath = resource_path('views/'.$path) . '.php';

        // التحقق من وجود الملف
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<p style='color:red;'>View not found: $viewPath</p>";
        }
    }
}

if (!function_exists('array_get')) {

    function array_get($array, $key)
    {
        // أولاً: لو المفتاح موجود مباشرة (بدون دوت) رجّع قيمته
        if (isset($array[$key])) {
            return $array[$key];
        }

        // ثانياً: لو المفتاح يحتوي على دوت (nested)
        if (strpos($key, '.') !== false) {
            foreach (explode('.', $key) as $segment) {
                if (is_array($array) && isset($array[$segment])) {
                    $array = $array[$segment];
                } else {
                    return null;
                }
            }
            return $array;
        }

        return null;
    }
}
if (!function_exists('old')) {
    function old($key, $default = '')
    {
        //    dd(flushMessage()->get('old'));
        if (flushMessage()->has('old')) {
            $value = array_get(flushMessage()->get('old'), $key);
            if (!empty($value)) return $value;
        }
        return $default ?? '';
    }
}

if (!function_exists('destroy_old')) {
    function destroy_old()
    {
        session()->delete('old');
        session()->delete('old_files');
    }
}

function assets($path, $default = '')
{
    if (empty($path) and !empty($default)) $path = $default;
    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    $scheme = $isSecure ? 'https' : 'http';

    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $baseUrl = $scheme . '://' . $host;

    $path = ltrim($path, '/');

    return $baseUrl . '/assets/' . $path;
}

function uploadFile($name, $path = 'files', $oldFile = '')
{
    try {
        if (!isset($_FILES[$name]) || $_FILES[$name]['error'] !== UPLOAD_ERR_OK) {
            return null; // لا يوجد ملف أو خطأ في الرفع
        }

        $file = $_FILES[$name];
        $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
        $fileInfo = pathinfo($file['name']);
        $fileExtension = strtolower($fileInfo['extension']);

        if (!in_array($fileExtension, $allowedTypes)) {
            flushMessage()->set('error', __('invalid_file_type') ?: 'نوع الملف غير مدعوم');
            return false;
        }

        // التحقق من حجم الملف (5MB max)
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($file['size'] > $maxSize) {
            flushMessage()->set('error', __('file_too_large') ?: 'الملف كبير جداً');
            return false;
        }


        // المسار الكامل داخل السيرفر
        //    $uploadDir = __DIR__ . '/../../public/assets/images/' . $folder . '/';
        $uploadDir = public_path('assets/' . $path . '/');

        //    dd([$uploadDir,public_path('')]);
        // أنشئ المجلد إذا لم يكن موجودًا
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid($name) . '.' . $fileExtension;

        // احصل على امتداد الملف
        // $extension = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);

        // أنشئ اسم فريد للملف
        // $fileName = uniqid() . $_FILES[$name]['name'];

        // المسار الفعلي للحفظ
        $targetPath = $uploadDir . $fileName;

        // نقل الملف
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            if (!empty($oldFile)) {
                $oldFileRelativePath = trim($oldFile, '/\\');
                $oldFileFullPath = public_path('assets/' . $oldFileRelativePath);
                if (file_exists($oldFileFullPath)) {
                    unlink($oldFileFullPath);
                }
            }
            // المسار النسبي داخل public لاستخدامه في العرض أو قاعدة البيانات
            return $path . '/' . $fileName;
        }

        return false; // فشل النقل
    } catch (\Exception $e) {
        flushMessage()->set('error', __('file_upload_failed') . ': ' . $e->getMessage());
        return false;
    }
}

function uploadImage($name, $folder = 'projects', $oldImagePath = '')
{
    return uploadFile($name, 'images/' . $folder, $oldImagePath);
}



if (!function_exists('removeFile')) {
    function removeFile($filePath)
    {
        $filePathFullPath = public_path('assets/' . $filePath);
        if (file_exists($filePathFullPath)) {
            unlink($filePathFullPath);
        }
    }
}


function uploadMultipleImages($inputName, $folder = 'projects'): array
{
    $uploaded = [];
    if (!isset($_FILES[$inputName]) || !is_array($_FILES[$inputName]['name'])) {
        return $uploaded;
    }

    $uploadDir = public_path('assets/images/' . $folder . '/');

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    foreach ($_FILES[$inputName]['tmp_name'] as $key => $tmp_name) {
        if ($_FILES[$inputName]['error'][$key] === UPLOAD_ERR_OK) {
            // $extension = pathinfo($_FILES[$inputName]['name'][$key], PATHINFO_EXTENSION);
            // $fileName = uniqid('img_', true) . '.' . $extension;
            $fileName = uniqid() . '_' . $_FILES[$inputName]['name'][$key];
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($tmp_name, $targetPath)) {
                $uploaded[] = 'images/' . $folder . '/' . $fileName;
            }
        }
    }

    return $uploaded;
}



if (!function_exists('locale')) {
    function locale()
    {
        if (!session()->has('locale')) {
            session()->set('locale', config('app', 'locale'));
        }
        return session()->get('locale');
    }
}

if (!function_exists('unLocale')) {
    function unLocale()
    {
        return locale() === 'ar' ? 'en' : 'ar';
    }
}

if (!function_exists('__')) {

    function __(string $key, array $replace = [], $locale = '')
    {
        if (empty($locale)) {
            $locale = locale();
        }

        // die(config('app', 'locale'));

        $path = resource_path("lang/{$locale}/messages.php");

        // var_dump(file_exists($path));
        // die();
        if (!file_exists($path)) {
            return $key;
        }

        $messages = require $path;
        $translation = $messages[$key] ?? $key;
        if (!empty($replace)) {
            foreach ($replace as $key => $value) {
                $translation = str_replace(":$key", $value, $translation);
            }
        }

        return $translation;
    }
}

if (!function_exists('renderLangTabs')) {
    function renderLangTabs(string $prefix, callable $callback, $data = null)
    {
        $langs = ['en', 'ar'];
        if (locale() == 'ar') {
            $langs = array_reverse($langs);
        }
?>
        <!-- Tabs -->
        <div class="tab-pane fade show active" id="<?= $prefix ?>" role="tabpanel">
            <ul class="nav nav-tabs mb-3" id="<?= $prefix ?>LanguageTabs" role="tablist">
                <?php foreach ($langs as $i => $lang): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $i === 0 ? 'active' : '' ?>"
                            id="<?= $prefix ?>-<?= $lang ?>-tab"
                            data-toggle="tab"
                            data-target="#<?= $prefix ?>-<?= $lang ?>"
                            type="button" role="tab">
                            <i class="fas fa-globe me-2"></i><?= __($lang) ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="<?= $prefix ?>LanguageTabsContent">
                <?php foreach ($langs as $i => $lang): ?>
                    <div class="<?= $lang ?> tab-pane fade <?= $i === 0 ? 'show active' : '' ?>"
                        id="<?= $prefix ?>-<?= $lang ?>" role="tabpanel">
                        <div class="row">
                            <?php
                            // هنا نستدعي الكولباك ونمرر له اللغة
                            $callback($lang, $data);
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
<?php
    }
}
