<?php

use App\Models\Settings;
use Devamirul\PhpMicro\core\Foundation\Session\Session;

if (!function_exists('setting')){
    function setting($key,$default=''){
        if (!Session::singleton()->has($key)){
            $settings = (new \App\Models\Settings())->select('*')->getData();
            foreach ($settings as $setting){
                Session::singleton()->set($setting['name'],$setting['value']);
            }
        }
        return Session::singleton()->get($key)??$default;
    }
}

/**
 * جلب اسم الموقع
 * @return string
 */
function siteName() {
    return setting('site_name', config('app', 'app_name'));
}

/**
 * جلب وصف الموقع
 * @return string
 */
function siteDescription() {
    return setting('site_description', 'Professional Portfolio Website');
}

/**
 * جلب شعار الموقع
 * @return string
 */
function siteLogo() {
    $logo = setting('site_logo', '');
    return !empty($logo) ? assets($logo) : assets('images/logo.svg');
}

/**
 * جلب بريد الموقع الإلكتروني
 * @return string
 */
function siteEmail() {
    return setting('site_email', 'admin@example.com');
}

/**
 * جلب هاتف الموقع
 * @return string
 */
function sitePhone() {
    return setting('site_phone', '+1234567890');
}

/**
 * جلب عنوان الموقع
 * @return string
 */
function siteAddress() {
    return setting('site_address', 'Your Address Here');
}

/**
 * جلب روابط وسائل التواصل الاجتماعي
 * @return array
 */
function socialLinks() {
    return [
        'facebook' => setting('facebook_url', ''),
        'twitter' => setting('twitter_url', ''),
        'linkedin' => setting('linkedin_url', ''),
        'github' => setting('github_url', ''),
        'instagram' => setting('instagram_url', ''),
        'youtube' => setting('youtube_url', '')
    ];
}

/**
 * التحقق من وضع الصيانة
 * @return bool
 */
function isMaintenanceMode() {
    return setting('maintenance_mode', '0') === '1';
}

/**
 * التحقق من السماح بالتسجيل
 * @return bool
 */
function isRegistrationAllowed() {
    return setting('allow_registration', '1') === '1';
}

/**
 * جلب عدد العناصر في الصفحة
 * @return int
 */
function itemsPerPage() {
    return (int) setting('items_per_page', 10);
}

/**
 * جلب المنطقة الزمنية
 * @return string
 */
function siteTimezone() {
    return setting('site_timezone', 'UTC');
}

/**
 * جلب تنسيق التاريخ
 * @return string
 */
function dateFormat() {
    return setting('date_format', 'Y-m-d');
}

/**
 * جلب تنسيق الوقت
 * @return string
 */
function timeFormat() {
    return setting('time_format', 'H:i:s');
}

/**
 * تنسيق التاريخ حسب إعدادات الموقع
 * @param string|int $date التاريخ
 * @return string
 */
function formatDate($date) {
    if (is_string($date)) {
        $date = strtotime($date);
    }
    return date(dateFormat(), $date);
}

/**
 * تنسيق الوقت حسب إعدادات الموقع
 * @param string|int $time الوقت
 * @return string
 */
function formatTime($time) {
    if (is_string($time)) {
        $time = strtotime($time);
    }
    return date(timeFormat(), $time);
}

/**
 * تنسيق التاريخ والوقت حسب إعدادات الموقع
 * @param string|int $datetime التاريخ والوقت
 * @return string
 */
function formatDateTime($datetime) {
    if (is_string($datetime)) {
        $datetime = strtotime($datetime);
    }
    return date(dateFormat() . ' ' . timeFormat(), $datetime);
}

/**
 * جلب الكلمات المفتاحية للموقع
 * @return string
 */
function siteKeywords() {
    return setting('site_keywords', 'portfolio, web development, programming');
}

/**
 * إنشاء meta tags للصفحة
 * @param string $title عنوان الصفحة
 * @param string $description وصف الصفحة
 * @param string $keywords كلمات مفتاحية إضافية
 * @return string
 */
function generateMetaTags($title = '', $description = '', $keywords = '') {
    $siteTitle = siteName();
    $siteDesc = siteDescription();
    $siteKeys = siteKeywords();
    
    $fullTitle = !empty($title) ? $title . ' - ' . $siteTitle : $siteTitle;
    $fullDescription = !empty($description) ? $description : $siteDesc;
    $fullKeywords = !empty($keywords) ? $keywords . ', ' . $siteKeys : $siteKeys;
    
    $meta = '<title>' . htmlspecialchars($fullTitle) . '</title>' . "\n";
    $meta .= '<meta name="description" content="' . htmlspecialchars($fullDescription) . '">' . "\n";
    $meta .= '<meta name="keywords" content="' . htmlspecialchars($fullKeywords) . '">' . "\n";
    $meta .= '<meta property="og:title" content="' . htmlspecialchars($fullTitle) . '">' . "\n";
    $meta .= '<meta property="og:description" content="' . htmlspecialchars($fullDescription) . '">' . "\n";
    $meta .= '<meta property="og:type" content="website">' . "\n";
    
    return $meta;
}

/**
 * عرض روابط وسائل التواصل الاجتماعي
 * @param string $class كلاس CSS للروابط
 * @return string
 */
function renderSocialLinks($class = 'social-link') {
    $links = socialLinks();
    $html = '';
    
    $icons = [
        'facebook' => 'fab fa-facebook-f',
        'twitter' => 'fab fa-twitter',
        'linkedin' => 'fab fa-linkedin-in',
        'github' => 'fab fa-github',
        'instagram' => 'fab fa-instagram',
        'youtube' => 'fab fa-youtube'
    ];
    
    foreach ($links as $platform => $url) {
        if (!empty($url)) {
            $icon = $icons[$platform] ?? 'fas fa-link';
            $html .= '<a href="' . htmlspecialchars($url) . '" class="' . $class . '" target="_blank" rel="noopener">';
            $html .= '<i class="' . $icon . '"></i>';
            $html .= '</a>';
        }
    }
    
    return $html;
}

/**
 * عرض عداد الزوار
 * @return string
 */
function renderVisitorCounter() {
    if (setting('show_visitor_counter', '1') !== '1') {
        return '';
    }
    
    try {
        $visitors = new \App\Models\Visitors();
        $todayStats = $visitors->getTodayStats();
        $totalStats = $visitors->getTotalStats();
        
        $html = '<div class="visitor-counter">';
        $html .= '<div class="counter-item">';
        $html .= '<i class="fas fa-eye"></i> ';
        $html .= '<span>' . (__('visitors_today') ?: 'زوار اليوم') . ': <strong>' . ($todayStats['total_visits'] ?? 0) . '</strong></span>';
        $html .= '</div>';
        $html .= '<div class="counter-item">';
        $html .= '<i class="fas fa-users"></i> ';
        $html .= '<span>' . (__('total_visitors') ?: 'إجمالي الزوار') . ': <strong>' . ($totalStats['total_visits'] ?? 0) . '</strong></span>';
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    } catch (\Exception $e) {
        // في حالة الخطأ، لا نعرض شيئاً
        return '';
    }
}

/**
 * الحصول على إحصائيات الزوار للواجهة الأمامية
 * @return array
 */
function getVisitorStats() {
    try {
        $visitors = new \App\Models\Visitors();
        return [
            'today' => $visitors->getTodayStats(),
            'total' => $visitors->getTotalStats(),
            'online' => $visitors->getCurrentVisitors()
        ];
    } catch (\Exception $e) {
        return [
            'today' => ['total_visits' => 0, 'unique_visitors' => 0],
            'total' => ['total_visits' => 0, 'unique_visitors' => 0],
            'online' => 0
        ];
    }
}
