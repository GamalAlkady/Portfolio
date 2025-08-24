class TranslationManager {
    constructor() {
        this.translations = {};
        this.currentLocale = this.detectLocale();
        this.fallbackLocale = 'en';
        this.isLoaded = false;
        // this.loadTranslationsFromPage();
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
            this.translations[this.currentLocale] = this.getDefaultTranslations(this.currentLocale);
            const translationScript = document.querySelector('script[data-translations]');
            if (translationScript) {
                const translationsData = JSON.parse(translationScript.textContent);
                this.translations[this.currentLocale] = {
                    ...this.translations[this.currentLocale],
                    ...translationsData[this.currentLocale]
                };
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
                'confirm_delete': 'تأكيد حذف ',
                'delete_warning': 'هل أنت متأكد أنك تريد حذف هذا العنصر؟',
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
                'confirm_delete': 'Confirm Delete',
                'delete_warning': 'Are you sure you want to delete this item?',
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
        if (!this.isLoaded) {
            this.loadTranslationsFromPage();
        }

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
            translation = key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
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

function getLocale() {
    return translator.getLocale();
}

function isRTL() {
    return translator.isRTL();
}