<?php

/**
 * مساعد الترجمة للـ JavaScript
 */
class TranslationHelper
{
    /**
     * تحميل ترجمات محددة للـ JavaScript
     */
    public static function getJavaScriptTranslations($locale = null, $keys = [])
    {
        $locale = $locale ?? locale();
        
        // إذا لم يتم تحديد مفاتيح، استخدم المفاتيح الافتراضية للـ JavaScript
        if (empty($keys)) {
            $keys = self::getDefaultJavaScriptKeys();
        }
        
        $translations = [];
        
        // تحميل ملف الترجمة
        $translationFile = APP_ROOT . "/resources/lang/{$locale}/messages.php";
        
        if (file_exists($translationFile)) {
            $allTranslations = include $translationFile;
            
            // استخراج الترجمات المطلوبة فقط
            foreach ($keys as $key) {
                if (isset($allTranslations[$key])) {
                    $translations[$key] = $allTranslations[$key];
                }
            }
        }
        
        // إضافة ترجمات افتراضية للمفاتيح المفقودة
        $defaultTranslations = self::getDefaultTranslations($locale);
        foreach ($keys as $key) {
            if (!isset($translations[$key]) && isset($defaultTranslations[$key])) {
                $translations[$key] = $defaultTranslations[$key];
            }
        }
        
        return $translations;
    }
    
    /**
     * إنشاء script tag يحتوي على الترجمات
     */
    public static function renderTranslationsScript($locale = null, $keys = [])
    {
        $translations = self::getJavaScriptTranslations($locale, $keys);
        $locale = $locale ?? locale();
        
        $translationsJson = json_encode([
            $locale => $translations
        ], JSON_UNESCAPED_UNICODE);
        
        return "<script data-translations type=\"application/json\">{$translationsJson}</script>";
    }
    
    /**
     * إنشاء meta tag يحتوي على الترجمات
     */
    public static function renderTranslationsMeta($locale = null, $keys = [])
    {
        $translations = self::getJavaScriptTranslations($locale, $keys);
        $locale = $locale ?? locale();
        
        $translationsJson = htmlspecialchars(json_encode([
            $locale => $translations
        ], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
        
        return "<meta name=\"translations\" content=\"{$translationsJson}\">";
    }
    
    /**
     * المفاتيح الافتراضية المطلوبة للـ JavaScript
     */
    private static function getDefaultJavaScriptKeys()
    {
        return [
            // رسائل عامة
            'loading',
            'please_wait',
            'processing',
            'completed',
            'failed',
            'try_again',
            
            // رسائل التأكيد
            'confirm_action',
            'are_you_sure',
            'cannot_be_undone',
            'yes_continue',
            'no_cancel',
            
            // رسائل الحذف
            'confirm_delete',
            'delete_warning',
            'delete_permanent',
            'yes_delete',
            'item_deleted',
            'delete_failed',
            
            // رسائل النجاح والخطأ
            'success',
            'error',
            'warning',
            'info',
            'saved_successfully',
            'updated_successfully',
            'deleted_successfully',
            'operation_failed',
            'unexpected_error',
            
            // رسائل النماذج
            'form_validation_failed',
            'required_fields_missing',
            'invalid_data',
            'please_check_inputs',
            
            // رسائل الشبكة
            'network_error',
            'connection_failed',
            'timeout_error',
            'server_error',
            
            // أزرار وإجراءات
            'save',
            'cancel',
            'edit',
            'delete',
            'add',
            'update',
            'submit',
            'reset',
            'close',
            'back',
            'next',
            'previous',
            'finish',
            
            // رسائل التحميل
            'uploading',
            'upload_complete',
            'upload_failed',
            'file_too_large',
            'invalid_file_type',
            
            // رسائل البحث
            'searching',
            'no_results',
            'search_placeholder',
            
            // رسائل الصفحات
            'page_not_found',
            'access_denied',
            'session_expired',
            'please_login',
            
            // رسائل المشاريع
            'project_saved_successfully',
            'project_updated_successfully',
            'project_deleted_successfully',
            'project_not_found',
            'validation_errors',
            'at_least_one_language_required',
        ];
    }
    
    /**
     * ترجمات افتراضية في حالة عدم وجود الملف
     */
    private static function getDefaultTranslations($locale)
    {
        $defaults = [
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
            ]
        ];
        
        return $defaults[$locale] ?? $defaults['en'];
    }
}

/**
 * دالة مساعدة لإنشاء script الترجمات
 */
function renderTranslations($locale = null, $keys = []) {
    return TranslationHelper::renderTranslationsScript($locale, $keys);
}

/**
 * دالة مساعدة لإنشاء meta الترجمات
 */
function renderTranslationsMeta($locale = null, $keys = []) {
    return TranslationHelper::renderTranslationsMeta($locale, $keys);
}
