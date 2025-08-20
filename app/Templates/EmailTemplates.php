<?php

namespace App\Templates;

use Devamirul\PhpMicro\core\Foundation\Application\Mail\Mail;

class EmailTemplates
{
    /**
     * قالب إيميل جهة الاتصال - عربي
     */
    public static function contactEmailArabic($data)
    {
        $name = htmlspecialchars($data['name'] ?? '');
        $email = htmlspecialchars($data['email'] ?? '');
        $phone = htmlspecialchars($data['phone'] ?? '');
        $message = nl2br(htmlspecialchars($data['message'] ?? ''));
        $siteName = htmlspecialchars($data['site_name'] ?? 'الموقع');
        $currentTime = date('Y-m-d H:i:s');

        return "
        <!DOCTYPE html>
        <html dir='rtl' lang='ar'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>رسالة جديدة من موقع {$siteName}</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; direction: rtl; }
                .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
                .header h1 { margin: 0; font-size: 24px; font-weight: 600; }
                .header p { margin: 10px 0 0 0; opacity: 0.9; font-size: 14px; }
                .content { padding: 30px; }
                .info-section { background-color: #f8f9fa; border-radius: 8px; padding: 20px; margin: 20px 0; border-right: 4px solid #667eea; }
                .info-row { display: flex; margin-bottom: 15px; align-items: center; }
                .info-label { font-weight: 600; color: #333; min-width: 100px; margin-left: 15px; }
                .info-value { color: #555; flex: 1; }
                .message-section { background-color: #fff; border: 1px solid #e9ecef; border-radius: 8px; padding: 20px; margin: 20px 0; }
                .message-title { font-weight: 600; color: #333; margin-bottom: 15px; font-size: 16px; }
                .message-content { line-height: 1.6; color: #555; }
                .footer { background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #e9ecef; }
                .footer p { margin: 5px 0; color: #666; font-size: 12px; }
                .icon { width: 16px; height: 16px; margin-left: 8px; vertical-align: middle; }
                .timestamp { background-color: #e3f2fd; padding: 10px; border-radius: 5px; font-size: 12px; color: #1976d2; text-align: center; margin: 20px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>📧 رسالة جديدة من الموقع</h1>
                    <p>تم استلام رسالة جديدة من نموذج الاتصال</p>
                </div>
                
                <div class='content'>
                    <div class='info-section'>
                        <div class='info-row'>
                            <span class='info-label'>👤 الاسم:</span>
                            <span class='info-value'>{$name}</span>
                        </div>
                        <div class='info-row'>
                            <span class='info-label'>📧 البريد:</span>
                            <span class='info-value'><a href='mailto:{$email}' style='color: #667eea; text-decoration: none;'>{$email}</a></span>
                        </div>
                        " . ($phone ? "<div class='info-row'><span class='info-label'>📱 الهاتف:</span><span class='info-value'><a href='tel:{$phone}' style='color: #667eea; text-decoration: none;'>{$phone}</a></span></div>" : "") . "
                    </div>
                    
                    <div class='message-section'>
                        <div class='message-title'>💬 نص الرسالة:</div>
                        <div class='message-content'>{$message}</div>
                    </div>
                    
                    <div class='timestamp'>
                        🕐 تاريخ الاستلام: {$currentTime}
                    </div>
                </div>
                
                <div class='footer'>
                    <p><strong>{$siteName}</strong></p>
                    <p>هذه الرسالة تم إرسالها تلقائياً من نموذج الاتصال في الموقع</p>
                    <p style='color: #999;'>يرجى عدم الرد على هذا البريد الإلكتروني</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * قالب إيميل جهة الاتصال - إنجليزي
     */
    public static function contactEmailEnglish($data)
    {
        $name = htmlspecialchars($data['name'] ?? '');
        $email = htmlspecialchars($data['email'] ?? '');
        $phone = htmlspecialchars($data['phone'] ?? '');
        $message = nl2br(htmlspecialchars($data['message'] ?? ''));
        $siteName = htmlspecialchars($data['site_name'] ?? 'Website');
        $currentTime = date('Y-m-d H:i:s');

        return "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>New Message from {$siteName}</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
                .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
                .header h1 { margin: 0; font-size: 24px; font-weight: 600; }
                .header p { margin: 10px 0 0 0; opacity: 0.9; font-size: 14px; }
                .content { padding: 30px; }
                .info-section { background-color: #f8f9fa; border-radius: 8px; padding: 20px; margin: 20px 0; border-left: 4px solid #667eea; }
                .info-row { display: flex; margin-bottom: 15px; align-items: center; }
                .info-label { font-weight: 600; color: #333; min-width: 100px; margin-right: 15px; }
                .info-value { color: #555; flex: 1; }
                .message-section { background-color: #fff; border: 1px solid #e9ecef; border-radius: 8px; padding: 20px; margin: 20px 0; }
                .message-title { font-weight: 600; color: #333; margin-bottom: 15px; font-size: 16px; }
                .message-content { line-height: 1.6; color: #555; }
                .footer { background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #e9ecef; }
                .footer p { margin: 5px 0; color: #666; font-size: 12px; }
                .timestamp { background-color: #e3f2fd; padding: 10px; border-radius: 5px; font-size: 12px; color: #1976d2; text-align: center; margin: 20px 0; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>📧 New Contact Message</h1>
                    <p>A new message has been received from your contact form</p>
                </div>
                
                <div class='content'>
                    <div class='info-section'>
                        <div class='info-row'>
                            <span class='info-label'>👤 Name:</span>
                            <span class='info-value'>{$name}</span>
                        </div>
                        <div class='info-row'>
                            <span class='info-label'>📧 Email:</span>
                            <span class='info-value'><a href='mailto:{$email}' style='color: #667eea; text-decoration: none;'>{$email}</a></span>
                        </div>
                        " . ($phone ? "<div class='info-row'><span class='info-label'>📱 Phone:</span><span class='info-value'><a href='tel:{$phone}' style='color: #667eea; text-decoration: none;'>{$phone}</a></span></div>" : "") . "
                    </div>
                    
                    <div class='message-section'>
                        <div class='message-title'>💬 Message:</div>
                        <div class='message-content'>{$message}</div>
                    </div>
                    
                    <div class='timestamp'>
                        🕐 Received: {$currentTime}
                    </div>
                </div>
                
                <div class='footer'>
                    <p><strong>{$siteName}</strong></p>
                    <p>This message was sent automatically from your website contact form</p>
                    <p style='color: #999;'>Please do not reply to this email</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * قالب إيميل الترحيب - عربي
     */
    public static function welcomeEmailArabic($data)
    {
        $name = htmlspecialchars($data['name'] ?? '');
        $siteName = htmlspecialchars($data['site_name'] ?? 'الموقع');
        $siteUrl = htmlspecialchars($data['site_url'] ?? '#');

        return "
        <!DOCTYPE html>
        <html dir='rtl' lang='ar'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>مرحباً بك في {$siteName}</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; direction: rtl; }
                .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); color: white; padding: 40px 30px; text-align: center; }
                .header h1 { margin: 0; font-size: 28px; font-weight: 600; }
                .content { padding: 40px 30px; text-align: center; }
                .welcome-text { font-size: 18px; color: #333; margin-bottom: 30px; line-height: 1.6; }
                .cta-button { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: 600; margin: 20px 0; transition: transform 0.3s ease; }
                .cta-button:hover { transform: translateY(-2px); }
                .features { text-align: right; margin: 30px 0; }
                .feature { margin: 15px 0; padding: 15px; background-color: #f8f9fa; border-radius: 8px; border-right: 4px solid #4CAF50; }
                .footer { background-color: #f8f9fa; padding: 30px; text-align: center; border-top: 1px solid #e9ecef; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🎉 مرحباً بك {$name}!</h1>
                    <p>نحن سعداء لانضمامك إلينا</p>
                </div>

                <div class='content'>
                    <div class='welcome-text'>
                        <p>أهلاً وسهلاً بك في <strong>{$siteName}</strong></p>
                        <p>نحن متحمسون لوجودك معنا ونتطلع إلى تقديم أفضل الخدمات لك</p>
                    </div>

                    <a href='{$siteUrl}' class='cta-button'>🚀 ابدأ الاستكشاف</a>

                    <div class='features'>
                        <div class='feature'>
                            <strong>✨ خدمات متميزة</strong><br>
                            نقدم لك أفضل الحلول والخدمات المتطورة
                        </div>
                        <div class='feature'>
                            <strong>🛡️ أمان وموثوقية</strong><br>
                            بياناتك آمنة معنا ونحافظ على خصوصيتك
                        </div>
                        <div class='feature'>
                            <strong>📞 دعم فني متواصل</strong><br>
                            فريق الدعم متاح لمساعدتك في أي وقت
                        </div>
                    </div>
                </div>

                <div class='footer'>
                    <p><strong>{$siteName}</strong></p>
                    <p>شكراً لك على ثقتك بنا</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * قالب إيميل الترحيب - إنجليزي
     */
    public static function welcomeEmailEnglish($data)
    {
        $name = htmlspecialchars($data['name'] ?? '');
        $siteName = htmlspecialchars($data['site_name'] ?? 'Website');
        $siteUrl = htmlspecialchars($data['site_url'] ?? '#');

        return "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Welcome to {$siteName}</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
                .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); color: white; padding: 40px 30px; text-align: center; }
                .header h1 { margin: 0; font-size: 28px; font-weight: 600; }
                .content { padding: 40px 30px; text-align: center; }
                .welcome-text { font-size: 18px; color: #333; margin-bottom: 30px; line-height: 1.6; }
                .cta-button { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: 600; margin: 20px 0; transition: transform 0.3s ease; }
                .cta-button:hover { transform: translateY(-2px); }
                .features { text-align: left; margin: 30px 0; }
                .feature { margin: 15px 0; padding: 15px; background-color: #f8f9fa; border-radius: 8px; border-left: 4px solid #4CAF50; }
                .footer { background-color: #f8f9fa; padding: 30px; text-align: center; border-top: 1px solid #e9ecef; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🎉 Welcome {$name}!</h1>
                    <p>We're excited to have you on board</p>
                </div>

                <div class='content'>
                    <div class='welcome-text'>
                        <p>Welcome to <strong>{$siteName}</strong></p>
                        <p>We're thrilled to have you with us and look forward to providing you with the best services</p>
                    </div>

                    <a href='{$siteUrl}' class='cta-button'>🚀 Start Exploring</a>

                    <div class='features'>
                        <div class='feature'>
                            <strong>✨ Premium Services</strong><br>
                            We provide you with the best solutions and advanced services
                        </div>
                        <div class='feature'>
                            <strong>🛡️ Security & Reliability</strong><br>
                            Your data is safe with us and we protect your privacy
                        </div>
                        <div class='feature'>
                            <strong>📞 24/7 Support</strong><br>
                            Our support team is available to help you anytime
                        </div>
                    </div>
                </div>

                <div class='footer'>
                    <p><strong>{$siteName}</strong></p>
                    <p>Thank you for trusting us</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * قالب إيميل إشعار عام - عربي
     */
    public static function notificationEmailArabic($data)
    {
        $title = htmlspecialchars($data['title'] ?? 'إشعار جديد');
        $message = nl2br(htmlspecialchars($data['message'] ?? ''));
        $siteName = htmlspecialchars($data['site_name'] ?? 'الموقع');
        $actionUrl = htmlspecialchars($data['action_url'] ?? '');
        $actionText = htmlspecialchars($data['action_text'] ?? 'عرض التفاصيل');

        return "
        <!DOCTYPE html>
        <html dir='rtl' lang='ar'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$title}</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; direction: rtl; }
                .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%); color: white; padding: 30px; text-align: center; }
                .header h1 { margin: 0; font-size: 24px; font-weight: 600; }
                .content { padding: 30px; }
                .message-content { font-size: 16px; line-height: 1.6; color: #333; margin-bottom: 30px; }
                .cta-button { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; text-decoration: none; border-radius: 20px; font-weight: 600; margin: 20px 0; }
                .footer { background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #e9ecef; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🔔 {$title}</h1>
                </div>

                <div class='content'>
                    <div class='message-content'>
                        {$message}
                    </div>

                    " . ($actionUrl ? "<a href='{$actionUrl}' class='cta-button'>{$actionText}</a>" : "") . "
                </div>

                <div class='footer'>
                    <p><strong>{$siteName}</strong></p>
                    <p>هذا إشعار تلقائي من النظام</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * قالب إيميل إشعار عام - إنجليزي
     */
    public static function notificationEmailEnglish($data)
    {
        $title = htmlspecialchars($data['title'] ?? 'New Notification');
        $message = nl2br(htmlspecialchars($data['message'] ?? ''));
        $siteName = htmlspecialchars($data['site_name'] ?? 'Website');
        $actionUrl = htmlspecialchars($data['action_url'] ?? '');
        $actionText = htmlspecialchars($data['action_text'] ?? 'View Details');

        return "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$title}</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
                .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%); color: white; padding: 30px; text-align: center; }
                .header h1 { margin: 0; font-size: 24px; font-weight: 600; }
                .content { padding: 30px; }
                .message-content { font-size: 16px; line-height: 1.6; color: #333; margin-bottom: 30px; }
                .cta-button { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; text-decoration: none; border-radius: 20px; font-weight: 600; margin: 20px 0; }
                .footer { background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #e9ecef; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🔔 {$title}</h1>
                </div>

                <div class='content'>
                    <div class='message-content'>
                        {$message}
                    </div>

                    " . ($actionUrl ? "<a href='{$actionUrl}' class='cta-button'>{$actionText}</a>" : "") . "
                </div>

                <div class='footer'>
                    <p><strong>{$siteName}</strong></p>
                    <p>This is an automated notification from the system</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * دالة مساعدة لاختيار القالب المناسب حسب اللغة
     */
    public static function getContactEmail($data, $language = 'ar')
    {
        return $language === 'ar'
            ? self::contactEmailArabic($data)
            : self::contactEmailEnglish($data);
    }

    /**
     * دالة مساعدة لاختيار قالب الترحيب حسب اللغة
     */
    public static function getWelcomeEmail($data, $language = 'ar')
    {
        return $language === 'ar'
            ? self::welcomeEmailArabic($data)
            : self::welcomeEmailEnglish($data);
    }

    /**
     * دالة مساعدة لاختيار قالب الإشعار حسب اللغة
     */
    public static function getNotificationEmail($data, $language = 'ar')
    {
        return $language === 'ar'
            ? self::notificationEmailArabic($data)
            : self::notificationEmailEnglish($data);
    }

    /**
     * دالة لجلب بيانات الموقع الافتراضية
     */
    public static function getDefaultSiteData()
    {
        return [
            'site_name' => setting('site_name', 'الموقع'),
            'site_url' => env('APP_URL', 'http://localhost'),
            'site_email' => setting('site_email', 'admin@example.com'),
        ];
    }

    /**
     * دالة شاملة لإرسال إيميل مع القالب المناسب
     */
    public static function sendTemplatedEmail($type, $data, $toEmail, $language = 'ar')
    {
        // دمج البيانات الافتراضية
        $data = array_merge(self::getDefaultSiteData(), $data);

        // اختيار القالب المناسب
        switch ($type) {
            case 'contact':
                $htmlContent = self::getContactEmail($data, $language);
                $subject = $language === 'ar' ? 'رسالة جديدة من الموقع' : 'New Contact Message';
                break;

            case 'welcome':
                $htmlContent = self::getWelcomeEmail($data, $language);
                $subject = $language === 'ar' ? 'مرحباً بك في ' . $data['site_name'] : 'Welcome to ' . $data['site_name'];
                break;

            case 'notification':
                $htmlContent = self::getNotificationEmail($data, $language);
                $subject = $data['title'] ?? ($language === 'ar' ? 'إشعار جديد' : 'New Notification');
                break;

            default:
                throw new \InvalidArgumentException("Unknown email template type: $type");
        }

        try {
            // // استخدام PHPMailer لإرسال الإيميل
            // $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

            // // إعدادات SMTP
            // $mail->isSMTP();
            // $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
            // $mail->SMTPAuth = true;
            // $mail->Username = env('MAIL_USERNAME', '');
            // $mail->Password = env('MAIL_PASSWORD', '');
            // $mail->SMTPSecure = env('MAIL_PORT', '587') == '465' ? 'ssl' : 'tls';
            // $mail->Port = (int)env('MAIL_PORT', 587);

            // // إعدادات الرسالة
            // $mail->setFrom(env('MAIL_FROM_ADDRESS', 'noreply@example.com'), env('MAIL_FROM_NAME', $data['site_name']));
            // $mail->addAddress($toEmail);

            // $mail->isHTML(true);
            // $mail->Subject = $subject;
            // $mail->Body = $htmlContent;
            // $mail->CharSet = 'UTF-8';

            // $mail->send();

            $mailConfig = config('mail', 'smtp');

            $mail = Mail::mailer()
                ->setServer($mailConfig['host'], $mailConfig['port'], 'tls')
                ->setAuth($mailConfig['username'], $mailConfig['password'])
                ->setFrom(siteName(), $mailConfig['username'])
                ->addTo(setting('name'), setting('site_email'));
                
                if($type == 'contact') $mail->setReplyTo($data['name'], $data['email']);

                $mail->setSubject($subject)
                ->setBody($htmlContent)
                ->send();


            return [
                'success' => true,
                'message' => $language === 'ar' ? 'تم إرسال الإيميل بنجاح' : 'Email sent successfully'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $language === 'ar' ? 'فشل في إرسال الإيميل: ' . $e->getMessage() : 'Failed to send email: ' . $e->getMessage()
            ];
        }
    }
}
