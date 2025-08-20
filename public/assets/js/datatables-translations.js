/**
 * DataTables Translations
 * ترجمات جداول البيانات
 */

// Arabic translations for DataTables
const datatablesArabic = {
    "decimal": "",
    "emptyTable": "لا توجد بيانات متاحة في الجدول",
    "info": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
    "infoEmpty": "إظهار 0 إلى 0 من أصل 0 مدخل",
    "infoFiltered": "(منقح من _MAX_ مدخل إجمالي)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "إظهار _MENU_ مدخلات",
    "loadingRecords": "جاري التحميل...",
    "processing": "جاري المعالجة...",
    "search": "البحث:",
    "zeroRecords": "لم يعثر على أية سجلات",
    "paginate": {
        "first": "الأول",
        "last": "الأخير",
        "next": "التالي",
        "previous": "السابق"
    },
    "aria": {
        "sortAscending": ": تفعيل لترتيب العمود تصاعدياً",
        "sortDescending": ": تفعيل لترتيب العمود تنازلياً"
    }
};

// English translations for DataTables (default)
const datatablesEnglish = {
    "decimal": "",
    "emptyTable": "No data available in table",
    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
    "infoEmpty": "Showing 0 to 0 of 0 entries",
    "infoFiltered": "(filtered from _MAX_ total entries)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Show _MENU_ entries",
    "loadingRecords": "Loading...",
    "processing": "Processing...",
    "search": "Search:",
    "zeroRecords": "No matching records found",
    "paginate": {
        "first": "First",
        "last": "Last",
        "next": "Next",
        "previous": "Previous"
    },
    "aria": {
        "sortAscending": ": activate to sort column ascending",
        "sortDescending": ": activate to sort column descending"
    }
};

/**
 * Get DataTables language configuration based on current locale
 * @param {string} locale - Current locale (ar, en)
 * @returns {object} Language configuration object
 */
function getDatatablesLanguage(locale = 'en') {
    switch (locale) {
        case 'ar':
            return datatablesArabic;
        case 'en':
        default:
            return datatablesEnglish;
    }
}

/**
 * Initialize DataTable with proper language support
 * @param {string} selector - Table selector
 * @param {object} options - DataTable options
 * @param {string} locale - Current locale
 * @returns {object} DataTable instance
 */
function initDataTableWithLanguage(selector, options = {}, locale = 'en') {
    const defaultOptions = {
        language: getDatatablesLanguage(locale),
        responsive: true,
        autoWidth: false,
        processing: true,
        serverSide: true,
        paging: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        // dom: 'Bfrtip',
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ]
    };
    
    // Merge user options with default options
    const finalOptions = Object.assign({}, defaultOptions, options);
    
    return $(selector).DataTable(finalOptions);
}

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        getDatatablesLanguage,
        initDataTableWithLanguage,
        datatablesArabic,
        datatablesEnglish
    };
}
