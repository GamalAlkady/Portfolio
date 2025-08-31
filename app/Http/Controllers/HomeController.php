<?php

namespace App\Http\Controllers;

use App\Models\Skills;
use App\Models\Certificates;
use App\Templates\EmailTemplates;
use App\Helpers\VisitorTracker;
use App\Models\Projects;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use Devamirul\PhpMicro\core\Foundation\Controller\BaseController;

class HomeController extends BaseController
{

    /**
     * View welcome page.
     */
    public function index()
    {
        // تتبع زيارة الصفحة الرئيسية
        VisitorTracker::run();
        
        $data = new Skills();
        $skills = $data->getAll();

        // الحصول على الشهادات المميزة
        $certificatesModel = new Certificates();
        $featuredCertificates = $certificatesModel->getFeaturedCertificates();

        // dd($featuredCertificates);
        $routeName = 'home';
        return view('index', compact('skills', 'featuredCertificates', 'routeName'));
    }

    public function showProjects()
    {
        // تتبع زيارة صفحة المشاريع
        VisitorTracker::run();
        $projects=new Projects();
        $data['projects']=$projects->getWithImages();
        $data['categories'] = $projects->getCategories();
        // dd(count($data['projects']));
        return view('projects', $data);
    }

    public function showCertificates()
    {
        // تتبع زيارة صفحة الشهادات
        VisitorTracker::run();
        
        $certificatesModel = new Certificates();
        $certificates = $certificatesModel->getAll();
        $featuredCertificates = $certificatesModel->getFeaturedCertificates();
        $certificateTypes = $certificatesModel->getCertificateTypes();
        
        return view('certificates', compact('certificates', 'featuredCertificates', 'certificateTypes'));
    }

    public function maintenance()
    {
        if(!isMaintenanceMode()){
            return redirect('/');
        }
        return view('maintenance_mode');
    }

    public function sendEmail(Request $request)
    {
        try {
            // جمع البيانات من الطلب
            $contactData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'message' => $request->input('message'),
                'site_name' => setting('site_name', env('APP_NAME', 'Profolio'))
            ];

            // تحديد اللغة (يمكن تحسينها لاحقاً)
            $language = locale() ?? 'ar';

            // البريد الإلكتروني المستقبل
            $recipientEmail = env('MAIL_USERNAME', 'gamal333ge@gmail.com');

            // إرسال الإيميل باستخدام القالب الجديد
            $result = EmailTemplates::sendTemplatedEmail(
                'contact',
                $contactData,
                $recipientEmail,
                $language
            );

            if ($result['success']) {
                flushMessage()->set('success', '✅ ' . __('message_sent_successfully'));
            } else {
                flushMessage()->set('error', '❌ ' . $result['message']);
            }

            return back();
        } catch (\Exception $e) {
            flushMessage()->set('error', '❌ ' . __('error_sending_message') . ': ' . $e->getMessage());
            return back();
        }
    }
}
