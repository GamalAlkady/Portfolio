<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use HTMLPurifier;
use HTMLPurifier_Config;

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
        $settings = (new Settings());

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $isAjax = true;
        }

        $data = $_POST;

        if (isset($_POST['image'])) {
            $image = uploadImage('image', 'user', $_POST['image']);
            if ($image) $data['image'] = $image;
        }

        if (isset($_POST['site_logo'])) {
            $site_logo = uploadImage('site_logo', '', $_POST['site_logo']);
            if ($site_logo) $data['site_logo'] = $site_logo;
        }
        if(isset($_POST['cv_pdf'])){
            $cv_pdf = uploadFile('cv_pdf', 'files', $_POST['cv_pdf']);
            if ($cv_pdf) $data['cv_pdf'] = $cv_pdf;
        }

        // dd($_POST);
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

            flushMessage()->set('success', __('settings_reset_successfully'));

            return back();
        } catch (\Exception $e) {
            return back()->withError(__('error_resetting_settings') . ': ' . $e->getMessage());
        }
    }
}
