<?php

namespace App\Models;

use Devamirul\PhpMicro\core\Foundation\Models\BaseModel;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;

class Visitors extends BaseModel 
{
    public $table = 'visitors';

    /**
     * تسجيل زيارة جديدة
     */
    public function recordVisit($data)
    {
        // التحقق من وجود زيارة بنفس الـ IP في نفس اليوم
        $existingVisit = $this->getVisitorToday($data['ip_address']);
        
        if (!$existingVisit) {
            // زيارة فريدة جديدة
            $data['is_unique'] = true;
        } else {
            // زيارة متكررة في نفس اليوم
            $data['is_unique'] = false;
        }
        
        return $this->insert($data)->getData();
    }

    /**
     * الحصول على زيارة اليوم لنفس الـ IP
     */
    public function getVisitorToday($ip)
    {
        return DB::db()->query(
            "SELECT * FROM {$this->table} WHERE ip_address = :ip AND visit_date = CURDATE() LIMIT 1",
            [':ip' => $ip]
        )->fetch();
    }

    /**
     * إحصائيات الزوار اليوم
     */
    public function getTodayStats()
    {
        $result = DB::db()->query(
            "SELECT 
                COUNT(*) as total_visits,
                COUNT(DISTINCT ip_address) as unique_visitors
             FROM {$this->table} 
             WHERE visit_date = CURDATE()"
        )->fetch();

        return $result ?: ['total_visits' => 0, 'unique_visitors' => 0];
    }

    /**
     * إحصائيات الزوار هذا الأسبوع
     */
    public function getWeekStats()
    {
        $result = DB::db()->query(
            "SELECT 
                COUNT(*) as total_visits,
                COUNT(DISTINCT ip_address) as unique_visitors
             FROM {$this->table} 
             WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)"
        )->fetch();

        return $result ?: ['total_visits' => 0, 'unique_visitors' => 0];
    }

    /**
     * إحصائيات الزوار هذا الشهر
     */
    public function getMonthStats()
    {
        $result = DB::db()->query(
            "SELECT 
                COUNT(*) as total_visits,
                COUNT(DISTINCT ip_address) as unique_visitors
             FROM {$this->table} 
             WHERE YEAR(visit_date) = YEAR(CURDATE()) 
             AND MONTH(visit_date) = MONTH(CURDATE())"
        )->fetch();

        return $result ?: ['total_visits' => 0, 'unique_visitors' => 0];
    }

    /**
     * إحصائيات الزوار الإجمالية
     */
    public function getTotalStats()
    {
        $result = DB::db()->query(
            "SELECT 
                COUNT(*) as total_visits,
                COUNT(DISTINCT ip_address) as unique_visitors
             FROM {$this->table}"
        )->fetch();

        return $result ?: ['total_visits' => 0, 'unique_visitors' => 0];
    }

    /**
     * إحصائيات يومية لآخر 7 أيام
     */
    public function getDailyStats($days = 7)
    {
        return DB::db()->query(
            "SELECT 
                visit_date,
                COUNT(*) as total_visits,
                COUNT(DISTINCT ip_address) as unique_visitors
             FROM {$this->table} 
             WHERE visit_date >= DATE_SUB(CURDATE(), INTERVAL :day DAY)
             GROUP BY visit_date 
             ORDER BY visit_date DESC",
            [':day' => $days]
        )->fetchAll();
    }

    /**
     * أكثر الصفحات زيارة
     */
    public function getTopPages($limit = 10)
    {
        return DB::db()->query(
            "SELECT 
                page_url,
                COUNT(*) as visits
             FROM {$this->table} 
             WHERE page_url IS NOT NULL
             GROUP BY page_url 
             ORDER BY visits DESC 
             LIMIT :limit",
            [':limit' => $limit]
        )->fetchAll();
    }

    /**
     * المصادر الأكثر إحالة
     */
    public function getTopReferrers($limit = 10)
    {
        return DB::db()->query(
            "SELECT 
                referer,
                COUNT(*) as visits
             FROM {$this->table} 
             WHERE referer IS NOT NULL AND referer != ''
             GROUP BY referer 
             ORDER BY visits DESC 
             LIMIT :limit",
            [':limit' => $limit]
        )->fetchAll();
    }

    /**
     * إحصائيات الدول
     */
    public function getCountryStats($limit = 10)
    {
        return DB::db()->query(
            "SELECT 
                country,
                COUNT(*) as visits,
                COUNT(DISTINCT ip_address) as unique_visitors
             FROM {$this->table} 
             WHERE country IS NOT NULL
             GROUP BY country 
             ORDER BY visits DESC 
             LIMIT :limit",
            [':limit' => $limit]
        )->fetchAll();
    }

    /**
     * الحصول على الزوار الحاليين (آخر 30 دقيقة)
     */
    public function getCurrentVisitors()
    {
        $result = DB::db()->query(
            "SELECT COUNT(DISTINCT ip_address) as online_visitors
             FROM {$this->table} 
             WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 MINUTE)"
        )->fetch();

        return $result ? $result['online_visitors'] : 0;
    }
}