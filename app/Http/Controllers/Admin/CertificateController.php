<?php

namespace App\Http\Controllers\Admin;

use App\Models\Certificates;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use Devamirul\PhpMicro\core\Foundation\Controller\BaseController;
use Rakit\Validation\Validator;

class CertificateController extends BaseController
{
    protected $certificateModel;

    public function __construct()
    {
        $this->certificateModel = new Certificates();
    }

    /**
     * عرض قائمة الشهادات
     */
    public function index()
    {
        $certificates = $this->certificateModel->getAll();
        $stats = $this->certificateModel->getCertificateStats();

        $data = [
            'certificates' => $certificates,
            'stats' => $stats,
            'certificateTypes' => $this->certificateModel->getCertificateTypes()
        ];

        return viewAdmin('certificates/index', $data);
    }

    public function dataTable(Request $request)
    {
        $start = $_GET['start'] ?? 0;
        $limit = $_GET['length'] ?? 10;
        $search = $_GET['search']['value'] ?? '';

        $params = [':search' => "%$search%"];

        // ✅ حساب عدد السجلات بعد الفلترة
        $countFiltered = $this->certificateModel->count(['title[~]' => $search, 'description[~]' => $search])->getData();

        // ✅ جلب البيانات مع التقطيع
        $params[':start'] = (int)$start;
        $params[':limit'] = (int)$limit;

        $query = $this->certificateModel->getAll(" WHERE title LIKE :search OR description LIKE :search ORDER BY display_order ASC, issued_date DESC LIMIT :start, :limit", $params);


        // ✅ العدد الكلي بدون فلترة
        $total = $this->certificateModel->count()->getData();

        header('Content-Type: application/json');

        return json_encode([
            "draw" => (int) $_GET['draw'],
            "recordsTotal" => $total,
            "recordsFiltered" => $countFiltered,
            "data" => $query
        ]);
    }

    /**
     * عرض تفاصيل شهادة معينة
     */
    public function show(Request $request)
    {
        $id = $request->getParam('id');
        $certificate = $this->certificateModel->getCertificateById($id, true);

        if (!$certificate) {
            flushMessage()->set('error', __('certificate_not_found') ?: 'الشهادة غير موجودة');
            return redirect(route('certificates'));
        }

        // تحويل JSON إلى array
        // $certificate['title_data'] = json_decode($certificate['title'], true);
        // $certificate['description_data'] = json_decode($certificate['description'], true);

        // dd($certificate);
        return viewAdmin('certificates/details', ['certificate' => $certificate]);
    }

    /**
     * عرض نموذج إنشاء شهادة جديدة
     */
    public function create()
    {
        $data = [
            'certificateTypes' => $this->certificateModel->getCertificateTypes()
        ];

        return viewAdmin('certificates/create', $data);
    }

    /**
     * حفظ شهادة جديدة
     */
    public function store(Request $request)
    {
        try {

            // dd($request->input('title'));
            $certificateData = $this->validateInput($request);

            // dd($certificateData);
            // إعداد البيانات
            $certificateData['is_featured'] = $request->input('is_featured', 0);
            $certificateData['display_order'] = (int)$request->input('display_order', 0);
            $certificateData['status'] = $request->input('status', 'active');

            // رفع ملف الشهادة إن وجد
            $certificate_file = uploadFile('certificate_file', 'files/certificates');
            if ($certificate_file) {
                $certificateData['certificate_file'] = $certificate_file;
            }


            // حفظ الشهادة
            $item = $this->certificateModel->createCertificate($certificateData);

            if ($item->error()) {
                flushMessage()->set('error', $item->error());
                return back();
            } else {
                flushMessage()->set('success', __('certificate_created_successfully'));
                return redirect(route('certificates'));
            }
        } catch (\Exception $e) {
            flushMessage()->set('error', __('error_occurred') . ': ' . $e->getMessage());
            return back();
        }
    }

    /**
     * عرض نموذج تعديل شهادة
     */
    public function edit(Request $request)
    {
        $id = $request->getParam('id');
        $certificate = $this->certificateModel->getCertificateById($id, false);

        if (!$certificate) {
            flushMessage()->set('error', __('certificate_not_found') ?: 'الشهادة غير موجودة');
            return redirect(route('certificates'));
        }

        // تحويل JSON إلى array
        // $certificate['title_data'] = json_decode($certificate['title'], true);
        // $certificate['description_data'] = json_decode($certificate['description'], true);

        $data = [
            'certificate' => $certificate,
            'certificateTypes' => $this->certificateModel->getCertificateTypes()
        ];

        // dd($data);
        return viewAdmin('certificates/create', $data);
    }

    /**
     * تحديث شهادة موجودة
     */
    public function update(Request $request)
    {
        try {
            $id = $request->getParam('id');
            $certificate = $this->certificateModel->getCertificateById($id);

            if (!$certificate) {
                flushMessage()->set('error', __('certificate_not_found') ?: 'الشهادة غير موجودة');
                return redirect(route('certificates'));
            }

            $updateData = $this->validateInput($request);

            // إعداد البيانات
            $updateData['is_featured'] = $request->input('is_featured', 0);
            $updateData['display_order'] = (int)$request->input('display_order', 0);
            $updateData['status'] = $request->input('status', 'active');

            // dd($updateData);
            // رفع ملف الشهادة إن وجد
            $certificate_file = uploadFile('certificate_file', 'files/certificates', $certificate['certificate_file']);
            if ($certificate_file) {
                $updateData['certificate_file'] = $certificate_file;
            }
            // رفع ملف جديد إن وجد
            // if (isset($_FILES['certificate_file']) && $_FILES['certificate_file']['error'] === UPLOAD_ERR_OK) {
            //     $fileName = $this->uploadCertificateFile($_FILES['certificate_file']);
            //     if ($fileName) {
            //         // حذف الملف القديم إن وجد
            //         if ($certificate['certificate_file']) {
            //             $this->deleteCertificateFile($certificate['certificate_file']);
            //         }
            //         $updateData['certificate_file'] = $fileName;
            //     }
            // }

            // تحديث الشهادة
            $result = $this->certificateModel->updateCertificate($id, $updateData);

            if ($result->error()) {
                // flushMessage()->set('error', __('certificate_update_failed') ?: 'فشل في تحديث الشهادة');
                return back()->withError($result->error());
            }

            flushMessage()->set('success', __('certificate_updated_successfully') ?: 'تم تحديث الشهادة بنجاح');
            return toRoute('certificates');
        } catch (\Exception $e) {
            flushMessage()->set('error', __('error_occurred') . ': ' . $e->getMessage());
            return back();
        }
    }

    /**
     * حذف شهادة
     */
    public function destroy(Request $request)
    {
        try {
            $id = $request->getParam('id');
            $certificate = $this->certificateModel->getCertificateById($id);

            if (!$certificate) {
                flushMessage()->set('error', __('certificate_not_found') ?: 'الشهادة غير موجودة');
                return redirect(route('certificates'));
            }

            // حذف ملف الشهادة إن وجد
            if ($certificate['certificate_file']) {
                removeFile($certificate['certificate_file']);
            }

            // حذف الشهادة
            $result = $this->certificateModel->deleteCertificate($id);

            if ($result->error()) {
                return json_encode([
                    'success' => false,
                    'message' => __('certificate_deletion_failed')
                ], JSON_UNESCAPED_UNICODE);
                // flushMessage()->set('error', __('certificate_deletion_failed') ?: 'فشل في حذف الشهادة');
            } else {
                return json_encode([
                    'success' => true,
                    'message' => __('certificate_deleted_successfully')
                ], JSON_UNESCAPED_UNICODE);
                // flushMessage()->set('success', __('certificate_deleted_successfully') ?: 'تم حذف الشهادة بنجاح');
            }

            return redirect(route('certificates'));
        } catch (\Exception $e) {
            flushMessage()->set('error', __('error_occurred') . ': ' . $e->getMessage());
            return redirect(route('certificates'));
        }
    }

    /**
     * تبديل حالة الشهادة المميزة
     */
    public function toggleFeatured(Request $request)
    {
        try {
            $id = $request->getParam('id');
            $result = $this->certificateModel->toggleFeatured($id);

            if ($result !== false) {
                flushMessage()->set('success', __('certificate_featured_status_updated') ?: 'تم تحديث حالة الشهادة المميزة');
            } else {
                flushMessage()->set('error', __('certificate_not_found') ?: 'الشهادة غير موجودة');
            }
        } catch (\Exception $e) {
            flushMessage()->set('error', __('error_occurred') . ': ' . $e->getMessage());
        }

        return redirect(route('certificates'));
    }

    /**
     * تبديل حالة الشهادة
     */
    public function toggleStatus(Request $request)
    {
        try {
            $id = $request->getParam('id');
            $result = $this->certificateModel->toggleStatus($id);

            if ($result !== false) {
                flushMessage()->set('success', __('certificate_status_updated') ?: 'تم تحديث حالة الشهادة');
            } else {
                flushMessage()->set('error', __('certificate_not_found') ?: 'الشهادة غير موجودة');
            }
        } catch (\Exception $e) {
            flushMessage()->set('error', __('error_occurred') . ': ' . $e->getMessage());
        }

        return redirect(route('certificates'));
    }

    /**
     * البحث في الشهادات
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $type = $request->input('type', '');

        if (empty($searchTerm) && empty($type)) {
            return redirect(route('certificates'));
        }

        $certificates = [];

        if (!empty($searchTerm)) {
            $certificates = $this->certificateModel->searchCertificates($searchTerm, locale());
        } elseif (!empty($type)) {
            $certificates = $this->certificateModel->getCertificatesByType($type, locale());
        }

        $stats = $this->certificateModel->getCertificateStats();

        $data = [
            'certificates' => $certificates,
            'stats' => $stats,
            'certificateTypes' => $this->certificateModel->getCertificateTypes(),
            'searchTerm' => $searchTerm,
            'selectedType' => $type
        ];

        return viewAdmin('certificates/index', $data);
    }

    /**
     * رفع ملف الشهادة
     */
    private function uploadCertificateFile($file)
    {
        try {
            // التحقق من نوع الملف
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

            // إنشاء اسم ملف فريد
            $fileName = 'certificate_' . uniqid() . '.' . $fileExtension;

            // مسار حفظ الملف
            $uploadPath = __DIR__ . '/../../../../public/assets/files/certificates/';

            // إنشاء المجلد إن لم يكن موجوداً
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // نقل الملف
            if (move_uploaded_file($file['tmp_name'], $uploadPath . $fileName)) {
                return 'certificates/' . $fileName;
            }

            return false;
        } catch (\Exception $e) {
            flushMessage()->set('error', __('file_upload_failed') . ': ' . $e->getMessage());
            return false;
        }
    }

    /**
     * حذف ملف الشهادة
     */
    private function deleteCertificateFile($fileName)
    {
        try {
            $filePath = __DIR__ . '/../../../../public/assets/files/' . $fileName;
            if (file_exists($filePath)) {
                unlink($filePath);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * التحقق من صحة البيانات
     */
    private function validateInput($request)
    {
        $data = $request->except('_method', 'csrf');

        // dd($data);
        // رسائل التحقق بالعربية والإنجليزية
        $messages = [
            // رسائل العنوان - عربي
            'title.ar:required' => __('required_field'),
            'title.ar:min' => __('min_number', ['number' => 3]),
            'title.ar:max' => __('max_number', ['number' => 255]),

            // رسائل العنوان - إنجليزي
            'title.en:required' => __('required_field'),
            'title.en:min' => __('min_number', ['number' => 3]),
            'title.en:max' => __('max_number', ['number' => 255]),

            // رسائل الوصف - عربي
            // 'description.ar:required' => __('required_field'),
            'description.ar:min' => __('min_number', ['number' => 10]),
            'description.ar:max' => __('max_number', ['number' => 5000]),

            // رسائل الوصف - إنجليزي
            // 'description.en:required' => __('required_field'),
            'description.en:min' => __('min_number', ['number' => 10]),
            'description.en:max' => __('max_number', ['number' => 5000]),

            // رسائل التصنيف
            'certificate_type:required' => __('required_field'),

            // رسائل التقنيات
            'issuer:required' => __('required_field'),

            // رسائل التقنيات
            'issued_date:required' => __('required_field')
        ];

        $validator = new Validator($messages);

        // قواعد التحقق الأساسية
        $rules = [
            'title' => 'array',
            'description' => 'array',
            'certificate_type' => 'required',
            'issuer' => 'required|min:3',
            'issued_date' => 'required|date',
        ];

        // قواعد حسب اللغة الحالية
        if (locale() == 'en') {
            $rules['title.en'] = 'required|min:3|max:255';
            $rules['description.en'] = 'nullable|min:10|max:5000';
        } else {
            $rules['title.ar'] = 'required|min:3|max:255';
            $rules['description.ar'] = 'nullable|min:10|max:5000';
        }

        // التحقق من وجود محتوى بلغة واحدة على الأقل
        $hasArabicContent = !empty($data['title']['ar']) || !empty($data['description']['ar']);
        $hasEnglishContent = !empty($data['title']['en']) || !empty($data['description']['en']);

        if (!$hasArabicContent && !$hasEnglishContent) {
            return back()->withError(__('at_least_one_language_required'));
        }

        $validation = $validator->validate($data + $_FILES, $rules);

        if ($validation->fails()) {
            flushMessage()->set('old', $data);
            $errors = $validation->errors();
            return back()->withError($errors);
        }

        // dd($validation->getValidatedData());

        $data['title'] = json_encode($data['title']);
        $data['description'] = json_encode($data['description']);
        return $data;
    }
}
