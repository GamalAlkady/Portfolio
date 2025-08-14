<?php

namespace App\Models;

use Devamirul\PhpMicro\core\Foundation\Models\BaseModel;

class Settings extends BaseModel {
    public $table = "settings";

    protected $fillable = [
        'name',
        'value',
        'created_at',
        'updated_at'
    ];

    /**
     * جلب قيمة إعداد معين
     * @param string $name اسم الإعداد
     * @param mixed $default القيمة الافتراضية
     * @return mixed
     */
    public static function getSetting($name, $default = null)
    {
        $instance = new static();
        $setting = $instance->select('*',['name' => $name])
                          ->getData();

        return !empty($setting) ? $setting[0]['value'] : $default;
    }

    /**
     * تعيين قيمة إعداد
     * @param string $name اسم الإعداد
     * @param mixed $value القيمة
     * @return self
     */
    public static function setSetting($name, $value):self
    {
        $instance = new static();

        // التحقق من وجود الإعداد
        $existing = $instance->select('*',['name' => $name])
                            ->getData();

        if (!empty($existing)) {
            // تحديث الإعداد الموجود
            return $instance->update([
                               'value' => $value
                           ],['name' => $name]);
        } else {
            // إنشاء إعداد جديد
            return $instance->insert([
                'name' => $name,
                'value' => $value
            ]);
        }
    }

    /**
     * جلب جميع الإعدادات كمصفوفة
     * @return array
     */
    public static function getAll()
    {
        $instance = new static();
        $settings = $instance->select('name, value')->getData();

        $result = [];
        foreach ($settings as $setting) {
            $result[$setting['name']] = $setting['value'];
        }

        return $result;
    }

    /**
     * التحقق من وضع الصيانة
     * @return bool
     */
    public static function isMaintenanceMode()
    {
        return self::getSetting('maintenance_mode', '0') === '1';
    }

    /**
     * التحقق من السماح بالتسجيل
     * @return bool
     */
    public static function isRegistrationAllowed()
    {
        return self::getSetting('allow_registration', '1') === '1';
    }
}
