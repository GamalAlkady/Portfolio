<?php

namespace App\Models;

use Devamirul\PhpMicro\core\Foundation\Models\BaseModel;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;
use PDO;

class Certificates extends BaseModel
{
    public $table = 'certificates';

    protected $fillable = [
        'id',
        'issuer',
        'issued_date',
        'expiry_date',
        'certificate_type',
        'certificate_file',
        'verification_url',
        'skills_related',
        'is_featured',
        'display_order',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * إنشاء شهادة جديدة
     */
    public function createCertificate($data)
    {
        return $this->insert($data);
    }

    /**
     * تحديث شهادة موجودة
     */
    public function updateCertificate($id, $data)
    {
        return $this->update($data, ['id' => $id]);
    }

    /**
     * حذف شهادة
     */
    public function deleteCertificate($id)
    {
        return $this->delete(['id' => $id]);
    }

    private function getCertificateSelectQuery($currentLanguage = true)
    {
        $query = 'SELECT ' . implode(', ', $this->fillable);
        if ($currentLanguage) {
            $query .= ", 
                JSON_UNQUOTE(JSON_EXTRACT(title, '$." . locale() . "')) AS title,
                JSON_UNQUOTE(JSON_EXTRACT(description, '$." . locale() . "')) AS description";
        } else {
            $query .= ", 
                JSON_UNQUOTE(JSON_EXTRACT(title, '$.en')) AS title_en,
                JSON_UNQUOTE(JSON_EXTRACT(title, '$.ar')) AS title_ar,
                JSON_UNQUOTE(JSON_EXTRACT(description, '$.en')) AS description_en,
                JSON_UNQUOTE(JSON_EXTRACT(description, '$.ar')) AS description_ar";
        }
        return $query;
    }

    /**
     * الحصول على شهادة بالمعرف
     */
    public function getCertificateById($id, $currentLanguage = true)
    {
        $query = $this->getCertificateSelectQuery($currentLanguage);
        return DB::db()->query("$query FROM {$this->table} WHERE id=$id")->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * الحصول على جميع الشهادات مع الترجمة
     */
    public function getAll($conditions = '', $params = [], $currentLanguage = true)
    {
        $query = $this->getCertificateSelectQuery($currentLanguage);

        $conditions = empty($conditions) ? "WHERE status = 'active'" : $conditions;

        return DB::db()->query("$query FROM {$this->table} $conditions", $params)->fetchAll();
    }

    /**
     * الحصول على الشهادات المميزة
     */
    public function getFeaturedCertificates($currentLanguage = true, $limit = 6)
    {
        $query = $this->getCertificateSelectQuery($currentLanguage);
        $query .= "
            FROM {$this->table}
            WHERE status = 'active' AND is_featured = 1
            ORDER BY display_order ASC, issued_date DESC
            LIMIT :limit
        ";

        return DB::db()->query($query, [':limit' => $limit])->fetchAll();
    }

    /**
     * الحصول على الشهادات حسب النوع
     */
    public function getCertificatesByType($type, $locale = 'ar')
    {
        $query = "
            SELECT 
                id,
                JSON_UNQUOTE(JSON_EXTRACT(title, '$.$locale')) AS title,
                JSON_UNQUOTE(JSON_EXTRACT(description, '$.$locale')) AS description,
                issuer,
                issued_date,
                expiry_date,
                certificate_type,
                certificate_file,
                verification_url,
                skills_related,
                is_featured,
                display_order,
                status
            FROM {$this->table}
            WHERE status = 'active' AND certificate_type = :type
            ORDER BY display_order ASC, issued_date DESC
        ";

        return DB::db()->query($query, ['type' => $type])->fetchAll();
    }

    /**
     * البحث في الشهادات
     */
    public function searchCertificates($searchTerm, $locale = 'ar')
    {
        $searchTerm = '%' . $searchTerm . '%';

        $query = "
            SELECT 
                id,
                JSON_UNQUOTE(JSON_EXTRACT(title, '$.$locale')) AS title,
                JSON_UNQUOTE(JSON_EXTRACT(description, '$.$locale')) AS description,
                issuer,
                issued_date,
                expiry_date,
                certificate_type,
                certificate_file,
                verification_url,
                skills_related,
                is_featured,
                display_order,
                status
            FROM {$this->table}
            WHERE status = 'active' 
            AND (
                JSON_UNQUOTE(JSON_EXTRACT(title, '$.$locale')) LIKE :searchTitle
                OR JSON_UNQUOTE(JSON_EXTRACT(description, '$.$locale')) LIKE :searchDescription
                OR issuer LIKE :issuer
                OR skills_related LIKE :skills_related
            )
            ORDER BY display_order ASC, issued_date DESC
        ";

        return DB::db()->query($query, [
            'searchTitle' => $searchTerm,
            'searchDescription' => $searchTerm,
            'issuer' => $searchTerm,
            'skills_related' => $searchTerm
        ])->fetchAll();
    }

    /**
     * الحصول على إحصائيات الشهادات
     */
    public function getCertificateStats()
    {
        $totalCertificates = $this->count(['status' => 'active'])->getData();

        $typeStats = DB::db()->query("
            SELECT 
                certificate_type,
                COUNT(*) as count
            FROM {$this->table}
            WHERE status = 'active'
            GROUP BY certificate_type
        ")->fetchAll();

        $featuredCount = $this->count(['status' => 'active', 'is_featured' => 1])->getData();

        $recentCount = DB::db()->query("
            SELECT COUNT(*) as count
            FROM {$this->table}
            WHERE status = 'active' AND issued_date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
        ")->fetch()['count'];

        return [
            'total' => $totalCertificates,
            'by_type' => $typeStats,
            'featured' => $featuredCount,
            'recent_year' => $recentCount
        ];
    }

    /**
     * الحصول على الشهادات الأخيرة
     */
    public function getRecentCertificates($locale = 'en', $limit = 5)
    {
        $query = "
            SELECT 
                id,
                JSON_UNQUOTE(JSON_EXTRACT(title, '$.$locale')) AS title,
                JSON_UNQUOTE(JSON_EXTRACT(description, '$.$locale')) AS description,
                issuer,
                issued_date,
                certificate_type,
                certificate_file,
                is_featured
            FROM {$this->table}
            WHERE status = 'active'
            ORDER BY issued_date DESC, created_at DESC
            LIMIT :limit
        ";

        return DB::db()->query($query, ['limit' => $limit])->fetchAll();
    }

    /**
     * تحديث ترتيب العرض
     */
    public function updateDisplayOrder($id, $order)
    {
        return $this->update(['display_order' => $order], ['id' => $id])->getData();
    }

    /**
     * تبديل حالة الشهادة المميزة
     */
    public function toggleFeatured($id)
    {
        $certificate = $this->getCertificateById($id);
        if ($certificate) {
            $newStatus = $certificate['is_featured'] ? 0 : 1;
            return $this->update(['is_featured' => $newStatus], ['id' => $id])->getData();
        }
        return false;
    }

    /**
     * تبديل حالة الشهادة
     */
    public function toggleStatus($id)
    {
        $certificate = $this->getCertificateById($id);
        if ($certificate) {
            $newStatus = $certificate['status'] === 'active' ? 'inactive' : 'active';
            return $this->update(['status' => $newStatus], ['id' => $id])->getData();
        }
        return false;
    }

    /**
     * الحصول على أنواع الشهادات
     */
    public function getCertificateTypes()
    {
        return [
            ['id' => 'certificate', 'name' => __('certificate')],
            ['id' => 'award', 'name' => __('award')],
            ['id' => 'course', 'name' => __('course')],
            ['id' => 'achievement', 'name' => __('achievement')]
        ];
    }

    /**
     * فحص انتهاء صلاحية الشهادات
     */
    public function getExpiredCertificates()
    {
        return DB::db()->query("
            SELECT *
            FROM {$this->table}
            WHERE status = 'active' 
            AND expiry_date IS NOT NULL 
            AND expiry_date < CURDATE()
        ")->fetchAll();
    }

    /**
     * الشهادات التي ستنتهي قريباً (خلال 30 يوم)
     */
    public function getExpiringCertificates($days = 30)
    {
        return DB::db()->query("
            SELECT *
            FROM {$this->table}
            WHERE status = 'active' 
            AND expiry_date IS NOT NULL 
            AND expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL :days DAY)
            ORDER BY expiry_date ASC
        ", ['days' => $days])->fetchAll();
    }
}
