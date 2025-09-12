<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use HTMLPurifier;
use HTMLPurifier_Config;

// Include the EnvHelper
require_once APP_ROOT . '/app/Helpers/EnvHelper.php';

class SettingController
{
    // private $settingsModel;
    // public function  __construct()
    // {
    //     $this->settingsModel = new Settings();
    // }

    public function index()
    {
        return viewAdmin('settings/index');
    }

    public function update(Request $request)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        // var_dump($_SERVER['HTTP_REFERER']);
        // die;
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $isAjax = true;
        }

        $data = $_POST;

        if (isset($_POST['image'])) {
            $image = uploadImage('image', 'user', $_POST['image']);
            if ($image) $data['image'] = $image;
        }

        // dd($_POST);
        if (isset($_POST['logo_light'])) {
            $logo_light = uploadImage('logo_light', '', $_POST['logo_light']);
            if ($logo_light) $data['logo_light'] = $logo_light;
        }
        if (isset($_POST['logo_dark'])) {
            $logo_dark = uploadImage('logo_dark', '', $_POST['logo_dark']);
            if ($logo_dark) $data['logo_dark'] = $logo_dark;
        }
        
        if(isset($_POST['cv_pdf'])){
            $cv_pdf = uploadFile('cv_pdf', 'files', $_POST['cv_pdf']);
            if ($cv_pdf) $data['cv_pdf'] = $cv_pdf;
        }

        // Handle email settings separately (save to .env file)
        $emailSettings = [];
        $emailFields = ['mail_host', 'mail_port', 'mail_username', 'mail_password'];

        foreach ($emailFields as $field) {
            if (isset($data[$field])) {
                $emailSettings[strtoupper($field)] = $data[$field];
                unset($data[$field]); // Remove from regular settings
            }
        }

        // Update .env file with email settings
        if (!empty($emailSettings)) {
            if (!updateEnvFile($emailSettings)) {
                if (isset($isAjax))
                    return json_encode(['success' => false, 'message' => __('error_updating_email_settings')]);
                return back()->withError(__('error_updating_email_settings'));
            }
        }

        $data['maintenance_mode'] = $request->input('maintenance_mode',0);
        $data['allow_registration'] = $request->input('allow_registration',0);
        foreach ($data as $name => $value) {
            $val = $purifier->purify($value);
            $p = Settings::setSetting($name, $val);
            if ($p->error() != null) {
                if (isset($isAjax))
                    return json_encode(['success' => false, 'message' => $p->error()]);
                return back()->withError($p->error());
            }
            \Devamirul\PhpMicro\core\Foundation\Session\Session::singleton()->set($name, $value);
        }

        if (isset($isAjax))
            return json_encode(['success' => true, 'message' => "Profile updated successfully."]);
        flushMessage()->set('success', 'Skill updated successfully.');
        return back();
    }

    /**
     * إعادة تعيين الإعدادات إلى القيم الافتراضية
     */
    public function reset()
    {
        try {
            $defaultSettings = [
                'site_name' => 'Profolio',
                'site_description' => 'Professional Portfolio Website',
                'site_keywords' => 'portfolio, web development, programming',
                'site_email' => 'admin@example.com',
                'site_phone' => '+1234567890',
                'site_address' => 'Your Address Here',
                'facebook_url' => '',
                'twitter_url' => '',
                'linkedin_url' => '',
                'github_url' => '',
                'instagram_url' => '',
                'youtube_url' => '',
                'maintenance_mode' => '0',
                'allow_registration' => '1',
                'items_per_page' => '10',
                'site_timezone' => 'UTC'
            ];

            foreach ($defaultSettings as $name => $value) {
                Settings::setSetting($name, $value);
            }


              // reset file .env
            $envData = [
                'MAIL_HOST' => 'smtp.gmail.com',
                'MAIL_PORT' => '587',
                'MAIL_USERNAME' => 'your-email@gmail.com',
                'MAIL_PASSWORD' => 'your-email-password',
                'MAIL_FROM_ADDRESS' => 'example@yoursite.com',
                'MAIL_FROM_NAME' => 'Your Site Name'
            ];

            updateEnvFile($envData);
            
            flushMessage()->set('success', __('settings_reset_successfully'));

            return back();
        } catch (\Exception $e) {
            return back()->withError(__('error_resetting_settings') . ': ' . $e->getMessage());
        }
    }
}
