<?php
require_once 'check_auth.php';
require_once '../DB/db.php';
// التحقق من وجود معرف المشروع
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // جلب مسارات الصور قبل حذف المشروع
        $stmt = $pdo->prepare('SELECT image_url, other_images FROM projects WHERE id = ?');
        $stmt->execute([$id]);
        $project = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($project) {
            $image = "..\\" . $project['image_url'];
            // حذف الصورة الرئيسية
            if (!empty($image) && file_exists($image)) {
                unlink($image);
            }

            // حذف الصور الأخرى (إذا كانت موجودة)
            if (!empty($project['other_images'])) {
                $other_images = json_decode($project['other_images'], true);
                if (is_array($other_images)) {
                    foreach ($other_images as $image_path) {
                        if (file_exists('..\\' . $image_path)) {
                            unlink('..\\' . $image_path);
                        }
                    }
                }
            }
        }

        // حذف المشروع من قاعدة البيانات
        $stmt = $pdo->prepare('DELETE FROM projects WHERE id = ?');
        $stmt->execute([$id]);

        // إعادة التوجيه إلى صفحة المشاريع مع رسالة نجاح
        header('Location: view_projects.php?delete_success=1');
        exit();
    } catch (PDOException $e) {
        // في حالة حدوث خطأ، إعادة التوجيه مع رسالة خطأ
        header('Location: view_projects.php?delete_error=1');
        exit();
    }
} else {
    // إذا لم يتم تقديم معرف المشروع
    header('Location: view_projects.php');
    exit();
}
