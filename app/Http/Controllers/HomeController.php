<?php

namespace App\Http\Controllers;
use App\Models\Skills;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use Devamirul\PhpMicro\core\Foundation\Controller\BaseController;
use PHPMailer\PHPMailer\PHPMailer;

class HomeController extends BaseController {

    /**
     * View welcome page.
     */
    public function index() {
        $data = new Skills();
       $skills = $data->select('*')->getData();
        return view('index',compact('skills'));
    }

    public function showProjects() {
        $projects = DB::db()->query("
            SELECT p.*, 
                   GROUP_CONCAT(pi.path ORDER BY pi.is_main DESC, pi.id ASC) as all_images,
                   GROUP_CONCAT(pi.is_main ORDER BY pi.is_main DESC, pi.id ASC) as image_main_flags
            FROM projects p 
            LEFT JOIN project_images pi ON p.id = pi.project_id
            GROUP BY p.id
            ORDER BY p.created_at DESC
        ")->fetchAll();
        $routeName='home';
        return view('projects',compact('projects','routeName'));
    }

    public function maintenance() {
        if(!isMaintenanceMode()){
            return redirect('/');
        }
        return view('maintenance_mode');
    }

    public function sendEmail(Request $request){
        $mail = new PHPMailer(true);


        try {
//    $myEmail = "eng.m.alshalfi@gmail.com";
            $myEmail = "gamal333ge@gmail.com";
            // إعدادات الخادم
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             // مثال: smtp.gmail.com
            $mail->SMTPAuth = true;
            $mail->Username = $myEmail;   // بريدك الإلكتروني
//    $mail->Password = 'bvfq jogz pert ovbv';            // mohammed
            $mail->Password = 'bxed hnwv vqlt ddwy';            // كلمة المرور أو App Password
            $mail->SMTPSecure = 'tls';                    // أو ssl
            $mail->Port = 587;                            // أو 465 إذا كنت تستخدم ssl

            $email = $request->input('email');
            $name = $request->input('name');
            $phone = $request->input('phone');
            $message = $request->input('message');
            // المرسل والمستقبل
            $mail->setFrom($email, $name);
            $mail->addAddress($myEmail    , setting('name'));

            // المحتوى
            $mail->isHTML(true);
            $mail->Subject = env('APP_NAME','Profolio');
            $body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #eee; padding: 20px; background-color: #f9f9f9;'>
            <h2 style='color: #333; border-bottom: 2px solid #007BFF; padding-bottom: 10px;'>New Order from Your Site</h2>
            
            <p style='font-size: 16px; color: #555;'><strong>Name:</strong> {$name}</p>
            <p style='font-size: 16px; color: #555;'><strong>Phone Number:</strong> {$phone}</p>
            
            <div style='margin-top: 20px;'>
            <p style='font-size: 16px; color: #333;'><strong>Message:</strong></p>
            <p style='background-color: #fff; padding: 15px; border: 1px solid #ddd; border-radius: 5px; color: #444;'>
            {$message}
            </p>
            </div>
            
            <hr style='margin: 30px 0;'>
            <p style='font-size: 13px; color: #999; text-align: center;'>This message was sent from your site's contact form.</p>
            </div>
            ";

            $mail->Body = $body;
//    $mail->Body    = "<p>$message</p>";
            $mail->AltBody = 'Hello! This is a new mail notification.';

            $mail->send();
            flushMessage()->set('success','✅ Notification sent successfully.');
            return back();
        } catch (\Exception $e) {
            echo "❌ Failed to send notification: {$mail->ErrorInfo}";
        }
    }

}
