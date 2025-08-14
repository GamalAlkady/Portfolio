<?php

use Devamirul\PhpMicro\core\Foundation\Session\Session;

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

if (!function_exists('resource_path')) {
    function resource_path($path = '')
    {
        return dirname(__DIR__, 2) . '/resources' . ($path ? '/' . ltrim($path, '/') : '');
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

function uploadFile($name, $folder = 'files',$oldFile='')
{
    if (!isset($_FILES[$name]) || $_FILES[$name]['error'] !== UPLOAD_ERR_OK) {
        return null; // لا يوجد ملف أو خطأ في الرفع
    }

    // المسار الكامل داخل السيرفر
//    $uploadDir = __DIR__ . '/../../public/assets/images/' . $folder . '/';
    $uploadDir = public_path('assets/' . $folder.'/');

//    dd([$uploadDir,public_path('')]);
    // أنشئ المجلد إذا لم يكن موجودًا
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // احصل على امتداد الملف
    // $extension = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);

    // أنشئ اسم فريد للملف
    $fileName = uniqid() .$_FILES[$name]['name'];

    // المسار الفعلي للحفظ
    $targetPath = $uploadDir . $fileName;

    // نقل الملف
    if (move_uploaded_file($_FILES[$name]['tmp_name'], $targetPath)) {
        if (!empty($oldFile)) {
            $oldFileRelativePath = trim($oldFile, '/\\');
                $oldFileFullPath = public_path('assets/'.$oldFileRelativePath);
                if (file_exists($oldFileFullPath)) {
                    unlink($oldFileFullPath);
                }
        }
        // المسار النسبي داخل public لاستخدامه في العرض أو قاعدة البيانات
        return $folder . '/' . $fileName;
    }

    return null; // فشل النقل
}

function uploadImage($name, $folder = 'projects',$oldImagePath='')
{
   return uploadFile($name,'images/'. $folder,$oldImagePath);
}



if (!function_exists('removeFile')){
    function removeFile($filePath){
        $filePathFullPath = public_path('assets/'.$filePath);
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



if (!function_exists('locale')){
    function locale(){
        return session()->get('locale');
    }
}

if (!function_exists('__')) {

    function __(string $key, array $replace = []) {
        if(!session()->has('locale')){
            session()->set('locale', config('app', 'locale'));
        }
        $locale = session()->get('locale');
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
