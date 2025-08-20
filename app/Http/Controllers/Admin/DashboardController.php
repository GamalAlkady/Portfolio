<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orders;
use App\Models\Projects;
use App\Models\Skills;
use App\Models\Visitors;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;

class DashboardController
{
    public function index(){
        $data = [];
        $projects = new Projects();
        $visitors = new Visitors();
        
        // إحصائيات المشاريع والطلبات والمهارات
        $data['countProjects'] = $projects->count()->getData();
        $data['countOrders'] = (new Orders())->count()->getData();
        $data['countSkills'] = (new Skills())->count()->getData();

        // إحصائيات الزوار
        $data['visitorsToday'] = $visitors->getTodayStats();
        $data['visitorsWeek'] = $visitors->getWeekStats();
        $data['visitorsMonth'] = $visitors->getMonthStats();
        $data['visitorsTotal'] = $visitors->getTotalStats();
        $data['currentVisitors'] = $visitors->getCurrentVisitors();
        
        // بيانات إضافية
        $data['projects'] = $projects->getAll('order by created_at DESC LIMIT 4');
        $data['skills'] = DB::db()->query("SELECT * FROM skills order by id DESC LIMIT 4")->fetchAll();
        
        // إحصائيات يومية للرسم البياني (آخر 7 أيام)
        $data['dailyStats'] = $visitors->getDailyStats(7);
        // dd($data['v  isitorsToday']);
        
        // أكثر الصفحات زيارة
        $data['topPages'] = $visitors->getTopPages(5);
        
        // إحصائيات الدول
        $data['countryStats'] = $visitors->getCountryStats(5);

        return viewAdmin('dashboard', $data);
    }
    
    /**
     * صفحة إحصائيات الزوار المفصلة
     */
    public function visitors(){
        $visitors = new Visitors();
        
        $data = [
            'visitorsToday' => $visitors->getTodayStats(),
            'visitorsWeek' => $visitors->getWeekStats(),
            'visitorsMonth' => $visitors->getMonthStats(),
            'visitorsTotal' => $visitors->getTotalStats(),
            'currentVisitors' => $visitors->getCurrentVisitors(),
            'dailyStats' => $visitors->getDailyStats(30), // آخر 30 يوم
            'topPages' => $visitors->getTopPages(20),
            'topReferrers' => $visitors->getTopReferrers(10),
            'countryStats' => $visitors->getCountryStats(20)
        ];
        
        return viewAdmin('visitors', $data);
    }
}