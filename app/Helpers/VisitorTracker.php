<?php

namespace App\Helpers;

use App\Models\Visitors;

class VisitorTracker
{
    protected $visitorModel;
    
    public function __construct()
    {
        $this->visitorModel = new Visitors();
    }

    /**
     * تتبع زيارة جديدة
     */
    public function track()
    {
        // جمع بيانات الزائر
        $visitorData = $this->collectVisitorData();
        
        // تسجيل الزيارة
        return $this->visitorModel->recordVisit($visitorData);
    }

    /**
     * جمع بيانات الزائر
     */
    protected function collectVisitorData()
    {
        return [
            'ip_address' => $this->getIpAddress(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'page_url' => $this->getCurrentUrl(),
            'referer' => $_SERVER['HTTP_REFERER'] ?? null,
            'session_id' => session_id(),
            'visit_date' => date('Y-m-d'),
            'visit_time' => date('H:i:s'),
            'country' => $this->getCountryByIp(),
            'city' => $this->getCityByIp(),
        ];
    }

    /**
     * الحصول على عنوان IP الحقيقي
     */
    protected function getIpAddress()
    {
        $ipKeys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    /**
     * الحصول على URL الحالي
     */
    protected function getCurrentUrl()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        return $protocol . '://' . $host . $uri;
    }

    /**
     * الحصول على الدولة من IP (يمكن تطويرها لاحقاً باستخدام خدمة GeoIP)
     */
    protected function getCountryByIp()
    {
        $ip = $this->getIpAddress();
        
        // للاختبار المحلي
        if ($ip === '127.0.0.1' || $ip === '::1' || strpos($ip, '192.168.') === 0) {
            return 'Local';
        }
        
        // يمكن إضافة خدمة GeoIP هنا لاحقاً
        // مثل: http://ip-api.com/json/ أو MaxMind GeoIP
        
        return null;
    }

    /**
     * الحصول على المدينة من IP
     */
    protected function getCityByIp()
    {
        $ip = $this->getIpAddress();
        
        // للاختبار المحلي
        if ($ip === '127.0.0.1' || $ip === '::1' || strpos($ip, '192.168.') === 0) {
            return 'Local';
        }
        
        // يمكن إضافة خدمة GeoIP هنا لاحقاً
        return null;
    }

    /**
     * التحقق من أن الزائر ليس بوت
     */
    public function isBot()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        $bots = [
            'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider',
            'yandexbot', 'facebookexternalhit', 'twitterbot', 'rogerbot',
            'linkedinbot', 'embedly', 'quora link preview', 'showyoubot',
            'outbrain', 'pinterest/0.', 'developers.google.com/+/web/snippet',
            'slackbot', 'vkshare', 'w3c_validator', 'redditbot', 'applebot',
            'whatsapp', 'flipboard', 'tumblr', 'bitlybot', 'skypeuripreview',
            'nuzzel', 'discordbot', 'google page speed', 'qwantbot', 'pinterestbot',
            'bitrix link preview', 'xing-contenttabreceiver', 'chrome-lighthouse',
            'telegrambot'
        ];

        $userAgent = strtolower($userAgent);
        foreach ($bots as $bot) {
            if (strpos($userAgent, $bot) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * التحقق من أن الطلب صالح للتتبع
     */
    public function shouldTrack()
    {
        // لا تتبع البوتات
        if ($this->isBot()) {
            return false;
        }

        // لا تتبع طلبات AJAX
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            return false;
        }

        // لا تتبع ملفات الأصول
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $assetExtensions = ['.css', '.js', '.jpg', '.jpeg', '.png', '.gif', '.ico', '.svg', '.woff', '.woff2', '.ttf'];
        
        foreach ($assetExtensions as $ext) {
            if (substr($uri, -strlen($ext)) === $ext) {
                return false;
            }
        }

        return true;
    }

    /**
     * تشغيل تتبع الزوار
     */
    public static function run()
    {
        $tracker = new self();
        
        if ($tracker->shouldTrack()) {
            try {
                $tracker->track();
            } catch (\Exception $e) {
                // تسجيل الخطأ دون إيقاف الموقع
                error_log("Visitor tracking error: " . $e->getMessage());
            }
        }
    }
}