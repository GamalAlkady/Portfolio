
function assets(path) {
    const isSecure = window.location.protocol === 'https:';
    const scheme = isSecure ? 'https' : 'http';
    const host = window.location.host;

    path = path.replace(/^\/+/, ''); // إزالة أي / من بداية المسار

    return `${scheme}://${host}/assets/${path}`;
}

function tryParse(text) {
    try {
        return JSON.parse(text);
    } catch (e) {
        return null; // أو أي قيمة افتراضية لو كان النص غير صالح
    }
}

// نظام الترجمة JavaScript البسيط
class TranslationManager {
    constructor() {
        this.translations = {};
        this.currentLocale = this.detectLocale();
        this.fallbackLocale = 'en';
        this.isLoaded = false;
        this.loadTranslationsFromPage();
    }

    // اكتشاف اللغة الحالية
    detectLocale() {
        // محاولة الحصول على اللغة من HTML lang attribute
        const htmlLang = document.documentElement.lang;
        if (htmlLang) return htmlLang;

        // محاولة الحصول على اللغة من meta tag
        const metaLang = document.querySelector('meta[name="locale"]');
        if (metaLang) return metaLang.getAttribute('content');

        // محاولة الحصول على اللغة من body class
        const bodyClasses = document.body.className;
        if (bodyClasses.includes('rtl') || bodyClasses.includes('arabic')) return 'ar';
        if (bodyClasses.includes('ltr') || bodyClasses.includes('english')) return 'en';

        // محاولة الحصول على اللغة من localStorage
        const storedLang = localStorage.getItem('app_locale');
        if (storedLang) return storedLang;

        // محاولة الحصول على اللغة من المتصفح
        const browserLang = navigator.language.split('-')[0];
        return ['ar', 'en'].includes(browserLang) ? browserLang : 'en';
    }

    // تحميل الترجمات من الصفحة (إذا كانت مضمنة)
    loadTranslationsFromPage() {
        try {
            // البحث عن script tag يحتوي على الترجمات
            const translationScript = document.querySelector('script[data-translations]');
            if (translationScript) {
                const translationsData = JSON.parse(translationScript.textContent);
                this.translations = translationsData;
                this.isLoaded = true;
                return;
            }

            // البحث عن meta tag يحتوي على الترجمات
            const translationMeta = document.querySelector('meta[name="translations"]');
            if (translationMeta) {
                const translationsData = JSON.parse(translationMeta.getAttribute('content'));
                this.translations = translationsData;
                this.isLoaded = true;
                return;
            }

            // إذا لم توجد ترجمات مضمنة، استخدم الافتراضية
            this.translations[this.currentLocale] = this.getDefaultTranslations(this.currentLocale);
            this.isLoaded = true;
        } catch (error) {
            console.warn('Failed to load translations from page:', error);
            this.translations[this.currentLocale] = this.getDefaultTranslations(this.currentLocale);
            this.isLoaded = true;
        }
    }

    // ترجمات افتراضية في حالة فشل التحميل
    getDefaultTranslations(locale) {
        const defaults = {
            ar: {
                'confirm_delete': 'هل أنت متأكد؟',
                'delete_warning': 'لن تتمكن من التراجع عن هذا الإجراء!',
                'yes_delete': 'نعم، احذف!',
                'cancel': 'إلغاء',
                'deleted': 'تم الحذف!',
                'error': 'خطأ!',
                'success': 'نجح!',
                'loading': 'جاري التحميل...',
                'save': 'حفظ',
                'edit': 'تعديل',
                'delete': 'حذف',
                'add': 'إضافة',
                'write_content_here': 'اكتب المحتوى هنا'
            },
            en: {
                'confirm_delete': 'Are you sure?',
                'delete_warning': 'You won\'t be able to revert this!',
                'yes_delete': 'Yes, delete it!',
                'cancel': 'Cancel',
                'deleted': 'Deleted!',
                'error': 'Error!',
                'success': 'Success!',
                'loading': 'Loading...',
                'save': 'Save',
                'edit': 'Edit',
                'delete': 'Delete',
                'add': 'Add',
                'write_content_here': 'Write content here'
            }
        };
        return defaults[locale] || defaults.en;
    }

    // الحصول على ترجمة
    get(key, params = {}, locale = null) {
        locale = locale || this.currentLocale;

        // إذا لم يتم تحميل الترجمات بعد، استخدم الافتراضية
        if (!this.isLoaded || !this.translations[locale]) {
            const defaultTranslations = this.getDefaultTranslations(locale);
            return this.interpolate(defaultTranslations[key] || key, params);
        }

        let translation = this.translations[locale][key];

        // إذا لم توجد الترجمة، جرب اللغة الاحتياطية
        if (!translation && locale !== this.fallbackLocale) {
            translation = this.translations[this.fallbackLocale]?.[key];
        }

        // إذا لم توجد الترجمة، استخدم المفتاح نفسه
        if (!translation) {
            translation = key;
        }

        return this.interpolate(translation, params);
    }

    // استبدال المتغيرات في النص
    interpolate(text, params) {
        if (!params || Object.keys(params).length === 0) {
            return text;
        }

        return text.replace(/:(\w+)/g, (match, key) => {
            return params[key] !== undefined ? params[key] : match;
        });
    }

    // تغيير اللغة
    setLocale(locale) {
        if (locale === this.currentLocale) return;

        this.currentLocale = locale;
        localStorage.setItem('app_locale', locale);

        // تحديث اتجاه الصفحة
        document.documentElement.dir = locale === 'ar' ? 'rtl' : 'ltr';
        document.documentElement.lang = locale;

        // إعادة تحميل الصفحة لتطبيق اللغة الجديدة
        window.location.reload();
    }

    // الحصول على اللغة الحالية
    getLocale() {
        return this.currentLocale;
    }

    // التحقق من كون اللغة عربية
    isRTL() {
        return this.currentLocale === 'ar';
    }
}

// إنشاء مثيل عام للترجمة
const translator = new TranslationManager();

// دالة مختصرة للترجمة (مثل Laravel)
function __(key, params = {}, locale = null) {
    // console.log(key);

    return translator.get(key, params, locale);
}

// دالة للترجمة (نفس الدالة السابقة للتوافق)
function trans(key, params = {}, locale = null) {
    return translator.get(key, params, locale);
}

function getLocale(){
    return translator.getLocale();
}

function confirmDelete(csrf, url, buttonElement, options = {}) {
    // إعدادات افتراضية
    const settings = {
        targetUrl: '',
        tableId: null,
        itemName: '',
        reloadPage: true,
        showSuccessTimer: true,
        updateCounter: false,
        fadeEffect: true,
        ...options
    };

    // إذا كان options عبارة عن string، فهو targetUrl (للتوافق مع النسخة القديمة)
    if (typeof options === 'string') {
        settings.targetUrl = options;
    }

    const formData = new FormData();
    formData.append('csrf', csrf);
    formData.append('_method', 'DELETE');
    const successMessage = __('deleted_successfully');

    // رسائل مخصصة حسب نوع العنصر
    const confirmTitle = settings.itemName ?
        __('confirm_delete') + ' ' + settings.itemName :
        __('confirm_delete');

    const confirmText = settings.itemName ?
        __('delete_warning').replace('هذا العنصر', settings.itemName).replace('this item', settings.itemName) :
        __('delete_warning');

    Swal.fire({
        title: confirmTitle,
        text: confirmText,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: __('yes_delete'),
        cancelButtonText: __('cancel'),
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // تعطيل الزر أثناء الحذف
            if (buttonElement) {
                buttonElement.disabled = true;
                buttonElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // عرض رسالة النجاح
                        const successOptions = {
                            title: __('success'),
                            text: data.message || successMessage,
                            icon: 'success'
                        };

                        if (settings.showSuccessTimer) {
                            successOptions.timer = 2000;
                            successOptions.showConfirmButton = false;
                        }

                        Swal.fire(successOptions).then(() => {
                            // إذا كان هناك جدول محدد، احذف الصف منه
                            if (settings.tableId && buttonElement) {
                                deleteRowFromTable(settings.tableId, buttonElement, settings);
                            }
                            // أو إذا كان buttonElement موجود ولم يحدد tableId، جرب الاكتشاف التلقائي
                            else if (buttonElement && !settings.targetUrl) {
                                autoDetectAndDeleteRow(buttonElement, settings);
                            }
                            // وإلا إعادة توجيه أو تحديث الصفحة
                            else if (settings.reloadPage) {
                                if (settings.targetUrl) {
                                    location.href = settings.targetUrl;
                                } else {
                                    location.reload();
                                }
                            }
                        });
                    } else {
                        // عرض رسالة الخطأ
                        Swal.fire({
                            title: __('error'),
                            text: data.message || __('operation_failed'),
                            icon: 'error'
                        });

                        // إعادة تفعيل الزر
                        resetButton(buttonElement);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    // عرض رسالة خطأ الشبكة
                    Swal.fire({
                        title: __('error'),
                        text: __('network_error') || "Network error occurred. Please try again.",
                        icon: 'error'
                    });

                    // إعادة تفعيل الزر
                    resetButton(buttonElement);
                });
        }
    });
}

// دالة مساعدة للاكتشاف التلقائي وحذف الصف
function autoDetectAndDeleteRow(buttonElement, settings) {
    try {
        const row = buttonElement.closest('tr');
        if (row) {
            const table = row.closest('table');
            if (table) {
                // التحقق من وجود DataTable
                if ($.fn.DataTable && $(table).hasClass('dataTable')) {
                    const tableId = table.id;
                    if (tableId) {
                        deleteRowFromTable(tableId, buttonElement, settings);
                        return;
                    }
                }

                // حذف الصف مباشرة مع تأثير بصري
                if (settings.fadeEffect) {
                    $(row).fadeOut(400, function () {
                        row.remove();
                        if (settings.updateCounter) {
                            updatePageCounter();
                        }
                    });
                } else {
                    row.remove();
                    if (settings.updateCounter) {
                        updatePageCounter();
                    }
                }
                return;
            }
        }

        // إذا لم يتم العثور على صف، أعد تحميل الصفحة
        if (settings.reloadPage) {
            location.reload();
        }
    } catch (error) {
        console.error('Error in autoDetectAndDeleteRow:', error);
        if (settings.reloadPage) {
            location.reload();
        }
    }
}

// دالة مساعدة لحذف الصف من الجدول
function deleteRowFromTable(tableId, buttonElement, settings) {
    try {
        const table = $(`#${tableId}`).DataTable();
        const row = $(buttonElement).closest('tr');

        // تأثير بصري قبل الحذف
        if (settings.fadeEffect) {
            row.fadeOut(400, function () {
                table.row(row).remove().draw(false);

                // تحديث العداد إذا كان مطلوب
                if (settings.updateCounter) {
                    updateItemsCount(tableId, table);
                }
            });
        } else {
            table.row(row).remove().draw(false);
            if (settings.updateCounter) {
                updateItemsCount(tableId, table);
            }
        }
    } catch (error) {
        console.error('Error removing row from table:', error);
        // في حالة الخطأ، جرب الحذف المباشر
        autoDetectAndDeleteRow(buttonElement, settings);
    }
}

// دالة مساعدة لإعادة تفعيل الزر
function resetButton(buttonElement) {
    if (buttonElement) {
        buttonElement.disabled = false;
        buttonElement.innerHTML = '<i class="fas fa-trash"></i>';
    }
}

// دالة مساعدة لتحديث عداد العناصر
function updateItemsCount(tableId, table) {
    const totalItems = table.rows().count();

    // تحديث العداد في الصفحة إذا كان موجود
    const countElement = document.querySelector('.items-count, .projects-count, .users-count');
    if (countElement) {
        countElement.textContent = totalItems;
    }

    // تحديث عنوان الصفحة
    updatePageTitle(totalItems);

    // إذا لم تعد هناك عناصر، عرض رسالة فارغة
    if (totalItems === 0) {
        showEmptyState(tableId);
    }
}

// دالة تحديث عنوان الصفحة
function updatePageTitle(count) {
    const pageTitle = document.querySelector('.content-header h1');
    if (pageTitle && count >= 0) {
        const titleText = pageTitle.textContent.split('(')[0].trim();
        pageTitle.innerHTML = `${titleText} <small>(${count})</small>`;
    }
}

// دالة تحديث العداد العام للصفحة
function updatePageCounter() {
    const tables = document.querySelectorAll('table.dataTable');
    if (tables.length > 0) {
        const table = $(tables[0]).DataTable();
        const totalItems = table.rows().count();
        updatePageTitle(totalItems);

        if (totalItems === 0) {
            showEmptyState(tables[0].id);
        }
    }
}

// دالة عرض الحالة الفارغة
function showEmptyState(tableId) {
    const tableContainer = document.querySelector(`#${tableId}_wrapper`);
    if (tableContainer) {
        const emptyMessage = __('no_items_found') || __('no_projects_found') || 'لا توجد عناصر';
        const addMessage = __('add_first_item') || __('add_first_project') || 'أضف العنصر الأول';

        tableContainer.innerHTML = `
            <div class="text-center p-4 empty-state">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">${emptyMessage}</h4>
                <p class="text-muted">${addMessage}</p>
            </div>
        `;
    }
}

function summerNote(id, dir = 'ltr') {
    $('#' + id).summernote({ // تعيين التراجع إلى اليمين كافتراضي
        height: 200,
  
        fontSizeUnits: ['px', 'pt'],
        // fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana', 'Amiri', 'Cairo', 'Noto Sans Arabic', 'Tajawal'],
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana', 'Roboto', 'Open Sans', 'Lato'],
      toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['forecolor', 'backcolor']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['view', ['fullscreen', 'codeview', 'help']],
            ['height', ['height']]
        ],
        styleTags: [
            'p',
            { title: 'Main Heading', tag: 'h1', className: 'h1', value: 'h1' },
            { title: 'Sub Heading', tag: 'h2', className: 'h2', value: 'h2' },
            { title: 'Small Heading', tag: 'h3', className: 'h3', value: 'h3' },
            { title: 'Highlighted Text', tag: 'h4', className: 'h4', value: 'h4' },
            { title: 'Quote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' }
        ],
        placeholder: __('write_content_here'),
        callbacks: {
            onInit: function () {
                $(`#${id}`).siblings('.note-editor').addClass(`${dir}-editor`);
                $(`#${id} .note-editable`).attr('dir', dir);

            }
        }
    });

    // $('#'+id).summernote(dir=='rtl'?'justifyRight':'justifyLeft');

}

function ChangeTabs(url){
         var hash = window.location.hash;
        if (hash) {
            var tabId = hash.substring(1);
            var tabButton = document.getElementById(tabId + '-tab');

            if (tabButton) {
                var tab = new bootstrap.Tab(tabButton);
                tab.show();
                tabId0 = tabId.split('-');
                $(`#${tabId0[0]}LanguageTabsContent .tab-pane.show`).removeClass('show active');
                $('#' + tabId0[0]).addClass('show active');

                if (tabId == 'general' && tabId0.length == 1) tabId = tabId + '-' + getLocale();
                console.log(tabId);
                $('#' + tabId).addClass('show active');
                $('.settings-form').attr('action', url+'#' + tabId);
            }
        }

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            const tabId = e.target.id.replace('-tab', '');
            history.replaceState(null, '', window.location.pathname + '#' + tabId);
            $('.settings-form').attr('action', url+'#' + tabId);
        });
}
