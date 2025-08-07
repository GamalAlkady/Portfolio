<?php

use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\Session;

if (!function_exists('getCsrf')) {
    function getCsrf(): string {
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

if (!function_exists('includeView')) {
    function includeView($path, $data = [])
    {
        // استخراج المتغيرات كمصفوفات إلى متغيرات محلية
        extract($data);

        // تحديد المسار الكامل إلى الملف المطلوب
        $viewPath = __DIR__ . '/../../resources/views/' . str_replace('.', '/', $path) . '.php';

        // التحقق من وجود الملف
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<p style='color:red;'>View not found: $viewPath</p>";
        }
    }
}

if (!function_exists('old')){
    function old($key,$default=''){
//            dd(flushMessage()->get('old'));
        if (flushMessage()->has('old')) {
            $value = flushMessage()->get('old')[$key];
            if (!empty($value)) return $value;
        }
        return $default??'';
    }
}

if (!function_exists('destroy_old')){
    function destroy_old(){
        session()->delete('old');
        session()->delete('old_files');
    }
}

function assets($path,$default='')
{
    if (empty($path) and !empty($default)) $path=$default;
    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    $scheme = $isSecure ? 'https' : 'http';

    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $baseUrl = $scheme . '://' . $host;

    $path = ltrim($path, '/');

    return $baseUrl . '/assets/' . $path;
}

function uploadImage($fileInputName, $folder = 'projects',$oldImagePath='')
{
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return null; // لا يوجد ملف أو خطأ في الرفع
    }

    // المسار الكامل داخل السيرفر
//    $uploadDir = __DIR__ . '/../../public/assets/images/' . $folder . '/';
    $uploadDir = public_path('assets/images/' . $folder.'/');

//    dd([$uploadDir,public_path('')]);
    // أنشئ المجلد إذا لم يكن موجودًا
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // احصل على امتداد الملف
    $extension = pathinfo($_FILES[$fileInputName]['name'], PATHINFO_EXTENSION);

    // أنشئ اسم فريد للملف
    $fileName = uniqid('img_', true) . '.' . $extension;

    // المسار الفعلي للحفظ
    $targetPath = $uploadDir . $fileName;

    // نقل الملف
    if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetPath)) {
        if (!empty($oldImagePath)) {
            $oldImageRelativePath = trim($oldImagePath, '/\\');
                $oldImageFullPath = public_path('assets/'.$oldImageRelativePath);
                if (file_exists($oldImageFullPath)) {
                    unlink($oldImageFullPath);
                }
        }
        // المسار النسبي داخل public لاستخدامه في العرض أو قاعدة البيانات
        return 'images/' . $folder . '/' . $fileName;
    }

    return null; // فشل النقل
}


if (!function_exists('removeFile')){
    function removeFile($imagePath){
        $imageFullPath = public_path('assets/'.$imagePath);
        if (file_exists($imageFullPath)) {
            unlink($imageFullPath);
        }
    }
}


    function uploadMultipleImages($inputName, $folder = 'projects'): array
{
    $uploaded = [];

    if (!isset($_FILES[$inputName]) || !is_array($_FILES[$inputName]['name'])) {
        return $uploaded;
    }

    $uploadDir = __DIR__ . '/../../public/assets/images/' . $folder . '/';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    foreach ($_FILES[$inputName]['tmp_name'] as $key => $tmp_name) {
//            return [$tmp_name];
        if ($_FILES[$inputName]['error'][$key] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES[$inputName]['name'][$key], PATHINFO_EXTENSION);
            $fileName = uniqid('img_', true) . '.' . $extension;
//            $fileName = uniqid() . '_' . $_FILES[$inputName]['name'][$key][0];
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($tmp_name, $targetPath)) {
                $uploaded[] = 'images/' . $folder . '/' . $fileName;
            }
        }
    }

    return $uploaded;
}
