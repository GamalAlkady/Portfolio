<?php

namespace App\Http\Controllers\Admin;

use App\Models\Users;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;


class ProfileController
{
    public function index()
    {
        $user = (new Users())->get('*',['id'=>auth()->user()['id']])->getData();
        return viewAdmin('profile',compact('user'));
    }

    public function update(Request $request)
    {
        $id = auth()->user()['id'];
        $users = (new Users());

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $isAjax=true;
        }

        $data = $request->except('_method','csrf');

        if (isset($_POST['image'])) {
            $image = uploadImage('image', 'user', $_POST['image']);
            if ($image) $data['image'] = $image;
        }

        // Handle PDF upload
        if (isset($_FILES['cv_pdf']) && $_FILES['cv_pdf']['error'] === UPLOAD_ERR_OK) {
            $pdfResult = $this->uploadPDF($_FILES['cv_pdf']);
            if ($pdfResult['success']) {
                $data['cv_pdf'] = $pdfResult['path'];
            } else {
                if (isset($isAjax))
                    return json_encode(['success' => false, 'message' => $pdfResult['message']]);
                return back()->withError($pdfResult['message']);
            }
        }

        // Handle PDF deletion
        if (isset($_POST['delete_pdf']) && $_POST['delete_pdf'] === '1') {
            $currentPdf = $users->get('cv_pdf', ['id' => $id])->getData();
            if ($currentPdf && !empty($currentPdf['cv_pdf'])) {
                $this->deletePDF($currentPdf['cv_pdf']);
            }
            $data['cv_pdf'] = '';
        }
        $p = $users->update($data, ['id' => $id]);
        if ($p->error() != null) {
            if (isset($isAjax))
                return json_encode(['success'=>false,'message'=>$p->error()]);
            return back()->withError($p->error());
        }
        if (isset($isAjax))
            return json_encode(['success'=>true,'message'=>"Profile updated successfully."]);
        flushMessage()->set('success','Skill updated successfully.');
        return back();
    }

    /**
     * Upload PDF file
     * @param array $file
     * @return array
     */
    private function uploadPDF($file)
    {
        try {
            // Validate file type
            $allowedTypes = ['application/pdf'];
            $fileType = $file['type'];

            // Additional validation using file extension
            $fileName = $file['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($fileType, $allowedTypes) || $fileExtension !== 'pdf') {
                return ['success' => false, 'message' => __('only_pdf_allowed')];
            }

            // Validate file size (10MB max)
            $maxSize = 10 * 1024 * 1024; // 10MB in bytes
            if ($file['size'] > $maxSize) {
                return ['success' => false, 'message' => __('file_too_large')];
            }

            // Check if file was uploaded without errors
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return ['success' => false, 'message' => __('upload_error')];
            }

        // Create upload directory if it doesn't exist
        $uploadDir = APP_ROOT . '/public/uploads/cv/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate unique filename
        $fileName = 'cv_' . auth()->user()['id'] . '_' . time() . '.pdf';
        $filePath = $uploadDir . $fileName;

            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                return ['success' => true, 'path' => 'uploads/cv/' . $fileName];
            } else {
                return ['success' => false, 'message' => __('upload_error')];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => __('upload_error') . ': ' . $e->getMessage()];
        }
    }

    /**
     * Delete PDF file
     * @param string $filePath
     * @return bool
     */
    private function deletePDF($filePath)
    {
        if (!empty($filePath)) {
            $fullPath = APP_ROOT . '/public/' . $filePath;
            if (file_exists($fullPath)) {
                return unlink($fullPath);
            }
        }
        return false;
    }


//    public function destroy(Request $request)
//    {
//        $id = auth()->user()['id'];
//
//        $skills = new Skills();
//        $skill = $skills->delete(['id'=>$id]);
//        if ($skill->error()!=null){
//            return json_encode(['success'=>false,'message'=>$skill->error()]);
//        }
//        // flushMessage()->set("success","Skill deleted successfully.");
//        return json_encode(['success'=>true,'message'=>"Skill deleted successfully."]);
//    }
}