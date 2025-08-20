<?php

namespace App\Http\Controllers;

use App\Models\Skills;
use App\Templates\EmailTemplates;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use Devamirul\PhpMicro\core\Foundation\Controller\BaseController;
use Devamirul\PhpMicro\core\Foundation\Application\Mail\Mail;

class NotificationController extends BaseController
{


    public function sendEmail(Request $request){
           try {
            // جمع البيانات من الطلب
            $contactData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'message' => $request->input('message'),
                'site_name' => setting('site_name', config('app','app_name'))
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
    // public function sendEmail(Request $request)
    // {
    //     $email = $request->input('email');
    //     $name = $request->input('name');
    //     $phone = $request->input('phone');
    //     $message = $request->input('message');

    //     $body = "
    //         <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #eee; padding: 20px; background-color: #f9f9f9;'>
    //         <h2 style='color: #333; border-bottom: 2px solid #007BFF; padding-bottom: 10px;'>New Order from Your Site</h2>
            
    //         <p style='font-size: 16px; color: #555;'><strong>Name:</strong> {$name}</p>
    //         <p style='font-size: 16px; color: #555;'><strong>Phone Number:</strong> {$phone}</p>
            
    //         <div style='margin-top: 20px;'>
    //         <p style='font-size: 16px; color: #333;'><strong>Message:</strong></p>
    //         <p style='background-color: #fff; padding: 15px; border: 1px solid #ddd; border-radius: 5px; color: #444;'>
    //         {$message}
    //         </p>
    //         </div>
            
    //         <hr style='margin: 30px 0;'>
    //         <p style='font-size: 13px; color: #999; text-align: center;'>This message was sent from your site's contact form.</p>
    //         </div>
    //         ";
    //     $mailConfig = config('mail', 'smtp');

    //     try {

    //         Mail::mailer()
    //             ->setServer($mailConfig['host'], $mailConfig['port'], 'tls')
    //             ->setAuth($mailConfig['username'], $mailConfig['password'])
    //             ->setFrom(siteName(), setting('site_email'))
    //             ->addTo(setting('name'), setting('site_email'))
    //             ->setReplyTo($name, $email)
    //             ->setSubject('From ' . siteName())
    //             ->setBody($body)
    //             ->send();


    //         // // //    $myEmail = "eng.m.alshalfi@gmail.com";
    //         // $myEmail = "gamal333ge@gmail.com";
    //         // // إعدادات الخادم
    //         // $mail->isSMTP();
    //         // $mail->Host = $mailConfig['host'];             // مثال: smtp.gmail.com
    //         // $mail->SMTPAuth = true;
    //         // $mail->Username = $mailConfig['username'];   // بريدك الإلكتروني
    //         // //    $mail->Password = 'bvfq jogz pert ovbv';            // mohammed
    //         // $mail->Password = $mailConfig['password'];            // كلمة المرور أو App Password
    //         // $mail->SMTPSecure = 'tls';                    // أو ssl
    //         // $mail->Port = $mailConfig['port'];                            // أو 465 إذا كنت تستخدم ssl


    //         // // dd($email);
    //         // // المرسل والمستقبل
    //         // $mail->setFrom($email, $name);
    //         // $mail->addAddress($email, $name);

    //         // // المحتوى
    //         // $mail->isHTML(true);
    //         // $mail->Subject = config('app', 'app_name');


    //         // $mail->Body = $body;
    //         // //    $mail->Body    = "<p>$message</p>";
    //         // $mail->AltBody = 'Hello! This is a new mail notification.';

    //         // $mail->send();
    //         // flushMessage()->set('success', '✅ Notification sent successfully.');
    //         echo 'success';
    //         // return back();
    //     } catch (\Exception $e) {
    //         echo "❌ Failed to send notification: {$e->getMessage()}";
    //     }
    // }
}
