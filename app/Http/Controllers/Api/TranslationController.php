<?php

namespace App\Http\Controllers\Api;

use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;

class TranslationController
{
    /**
     * إرجاع الترجمات للغة المحددة
     */
    public function getTranslations(Request $request)
    {
        $locale = $request->getParam('locale') ?? 'en';
        
        // التأكد من أن اللغة مدعومة
        $supportedLocales = ['ar', 'en'];
        if (!in_array($locale, $supportedLocales)) {
            $locale = 'en';
        }
        
        try {
            // تحميل ملف الترجمة
            $translationFile = APP_ROOT . "/resources/lang/{$locale}/messages.php";
            
            if (!file_exists($translationFile)) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Translation file not found',
                    'translations' => $this->getDefaultTranslations($locale)
                ], 404);
            }
            
            // تحميل الترجمات
            $translations = include $translationFile;
            
            // إضافة ترجمات إضافية للـ JavaScript
            $jsTranslations = $this->getJavaScriptTranslations($locale);
            $translations = array_merge($translations, $jsTranslations);
            
            return $this->jsonResponse([
                'success' => true,
                'locale' => $locale,
                'translations' => $translations,
                'count' => count($translations)
            ]);
            
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Error loading translations: ' . $e->getMessage(),
                'translations' => $this->getDefaultTranslations($locale)
            ], 500);
        }
    }
    
    /**
     * ترجمات خاصة بـ JavaScript
     */
    private function getJavaScriptTranslations($locale)
    {
        $jsTranslations = [
            'ar' => [
                // رسائل عامة
                'loading' => 'جاري التحميل...',
                'please_wait' => 'يرجى الانتظار...',
                'processing' => 'جاري المعالجة...',
                'completed' => 'تم بنجاح',
                'failed' => 'فشل',
                'try_again' => 'حاول مرة أخرى',
                
                // رسائل التأكيد
                'confirm_action' => 'تأكيد الإجراء',
                'are_you_sure' => 'هل أنت متأكد؟',
                'cannot_be_undone' => 'لا يمكن التراجع عن هذا الإجراء',
                'yes_continue' => 'نعم، متابعة',
                'no_cancel' => 'لا، إلغاء',
                
                // رسائل الحذف
                'confirm_delete' => 'تأكيد الحذف',
                'delete_warning' => 'هل أنت متأكد من حذف هذا العنصر؟',
                'delete_permanent' => 'سيتم حذف العنصر نهائياً',
                'yes_delete' => 'نعم، احذف',
                'item_deleted' => 'تم حذف العنصر',
                'delete_failed' => 'فشل في حذف العنصر',
                
                // رسائل النجاح والخطأ
                'success' => 'نجح',
                'error' => 'خطأ',
                'warning' => 'تحذير',
                'info' => 'معلومات',
                'saved_successfully' => 'تم الحفظ بنجاح',
                'updated_successfully' => 'تم التحديث بنجاح',
                'deleted_successfully' => 'تم الحذف بنجاح',
                'operation_failed' => 'فشلت العملية',
                'unexpected_error' => 'حدث خطأ غير متوقع',
                
                // رسائل النماذج
                'form_validation_failed' => 'فشل في التحقق من صحة البيانات',
                'required_fields_missing' => 'حقول مطلوبة مفقودة',
                'invalid_data' => 'بيانات غير صحيحة',
                'please_check_inputs' => 'يرجى مراجعة المدخلات',
                
                // رسائل الشبكة
                'network_error' => 'خطأ في الشبكة',
                'connection_failed' => 'فشل في الاتصال',
                'timeout_error' => 'انتهت مهلة الاتصال',
                'server_error' => 'خطأ في الخادم',
                
                // أزرار وإجراءات
                'save' => 'حفظ',
                'cancel' => 'إلغاء',
                'edit' => 'تعديل',
                'delete' => 'حذف',
                'add' => 'إضافة',
                'update' => 'تحديث',
                'submit' => 'إرسال',
                'reset' => 'إعادة تعيين',
                'close' => 'إغلاق',
                'back' => 'رجوع',
                'next' => 'التالي',
                'previous' => 'السابق',
                'finish' => 'إنهاء',
                
                // رسائل التحميل
                'uploading' => 'جاري الرفع...',
                'upload_complete' => 'تم الرفع بنجاح',
                'upload_failed' => 'فشل في الرفع',
                'file_too_large' => 'حجم الملف كبير جداً',
                'invalid_file_type' => 'نوع الملف غير مدعوم',
                
                // رسائل البحث
                'searching' => 'جاري البحث...',
                'no_results' => 'لا توجد نتائج',
                'search_placeholder' => 'ابحث هنا...',
                
                // رسائل الصفحات
                'page_not_found' => 'الصفحة غير موجودة',
                'access_denied' => 'الوصول مرفوض',
                'session_expired' => 'انتهت جلسة العمل',
                'please_login' => 'يرجى تسجيل الدخول',
            ],
            
            'en' => [
                // General messages
                'loading' => 'Loading...',
                'please_wait' => 'Please wait...',
                'processing' => 'Processing...',
                'completed' => 'Completed successfully',
                'failed' => 'Failed',
                'try_again' => 'Try again',
                
                // Confirmation messages
                'confirm_action' => 'Confirm Action',
                'are_you_sure' => 'Are you sure?',
                'cannot_be_undone' => 'This action cannot be undone',
                'yes_continue' => 'Yes, continue',
                'no_cancel' => 'No, cancel',
                
                // Delete messages
                'confirm_delete' => 'Confirm Delete',
                'delete_warning' => 'Are you sure you want to delete this item?',
                'delete_permanent' => 'This item will be permanently deleted',
                'yes_delete' => 'Yes, delete it',
                'item_deleted' => 'Item deleted',
                'delete_failed' => 'Failed to delete item',
                
                // Success and error messages
                'success' => 'Success',
                'error' => 'Error',
                'warning' => 'Warning',
                'info' => 'Information',
                'saved_successfully' => 'Saved successfully',
                'updated_successfully' => 'Updated successfully',
                'deleted_successfully' => 'Deleted successfully',
                'operation_failed' => 'Operation failed',
                'unexpected_error' => 'An unexpected error occurred',
                
                // Form messages
                'form_validation_failed' => 'Form validation failed',
                'required_fields_missing' => 'Required fields are missing',
                'invalid_data' => 'Invalid data',
                'please_check_inputs' => 'Please check your inputs',
                
                // Network messages
                'network_error' => 'Network error',
                'connection_failed' => 'Connection failed',
                'timeout_error' => 'Connection timeout',
                'server_error' => 'Server error',
                
                // Buttons and actions
                'save' => 'Save',
                'cancel' => 'Cancel',
                'edit' => 'Edit',
                'delete' => 'Delete',
                'add' => 'Add',
                'update' => 'Update',
                'submit' => 'Submit',
                'reset' => 'Reset',
                'close' => 'Close',
                'back' => 'Back',
                'next' => 'Next',
                'previous' => 'Previous',
                'finish' => 'Finish',
                
                // Upload messages
                'uploading' => 'Uploading...',
                'upload_complete' => 'Upload completed',
                'upload_failed' => 'Upload failed',
                'file_too_large' => 'File is too large',
                'invalid_file_type' => 'Invalid file type',
                
                // Search messages
                'searching' => 'Searching...',
                'no_results' => 'No results found',
                'search_placeholder' => 'Search here...',
                
                // Page messages
                'page_not_found' => 'Page not found',
                'access_denied' => 'Access denied',
                'session_expired' => 'Session expired',
                'please_login' => 'Please login',
            ]
        ];
        
        return $jsTranslations[$locale] ?? $jsTranslations['en'];
    }
    
    /**
     * ترجمات افتراضية في حالة الخطأ
     */
    private function getDefaultTranslations($locale)
    {
        $defaults = [
            'ar' => [
                'error' => 'خطأ',
                'success' => 'نجح',
                'loading' => 'جاري التحميل...',
                'save' => 'حفظ',
                'cancel' => 'إلغاء',
                'delete' => 'حذف',
                'edit' => 'تعديل',
                'add' => 'إضافة'
            ],
            'en' => [
                'error' => 'Error',
                'success' => 'Success',
                'loading' => 'Loading...',
                'save' => 'Save',
                'cancel' => 'Cancel',
                'delete' => 'Delete',
                'edit' => 'Edit',
                'add' => 'Add'
            ]
        ];
        
        return $defaults[$locale] ?? $defaults['en'];
    }
    
    /**
     * إرجاع استجابة JSON
     */
    private function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
