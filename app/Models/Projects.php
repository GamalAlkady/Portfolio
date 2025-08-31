<?php

namespace App\Models;

use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;

use Devamirul\PhpMicro\core\Foundation\Models\BaseModel;

class Projects extends BaseModel
{
    public $table = "projects";
    protected $fillable = [
        'category',
        'technologies',
        'host_url',
        'github_url',
        'created_at',
    ];

    public function getQuery($currentLanguage = true)
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
     * الحصول على جميع المشاريع مع الترجمة
     *
     * @param string $additionalComands
     * @param boolean $currentLanguage
     * @return array
     */
    public function getAll($additionalComands = '', $params = [], $currentLanguage = true)
    {
        $query = $this->getQuery($currentLanguage);

        return DB::db()->query("$query FROM {$this->table} $additionalComands", $params)->fetchAll();

        // if($currentLanguage){
        //     $projects = DB::db()->query("SELECT
        //                     id,  
        //                     JSON_UNQUOTE(JSON_EXTRACT(title, '$.".locale()."')) AS title,
        //                     JSON_UNQUOTE(JSON_EXTRACT(description, '$.".locale()."')) AS description,
        //                     technologies,
        //                     category,
        //                     host_url,
        //                     github_url,
        //                     created_at
        //                     FROM projects $additionalComands")->fetchAll();
        // }else{
        //     $projects = $this->select('*')->getData();
        // }
        // return $projects;
    }

    public function getWithImages()
    {
        return DB::db()->query("
            SELECT    p.id,
                            JSON_UNQUOTE(JSON_EXTRACT(p.title, '$." . locale() . "')) AS title,
                            JSON_UNQUOTE(JSON_EXTRACT(p.description, '$." . locale() . "')) AS description,
                            p.technologies,
                            p.category,
                            p.host_url,
                            p.github_url,
                            p.created_at,
                   GROUP_CONCAT(pi.path ORDER BY pi.is_main DESC, pi.id ASC) as all_images,
                   GROUP_CONCAT(pi.is_main ORDER BY pi.is_main DESC, pi.id ASC) as image_main_flags
            FROM projects p
            LEFT JOIN project_images pi ON p.id = pi.project_id
            GROUP BY p.id
            ORDER BY p.created_at DESC
        ")->fetchAll();
    }
    public function getProject($id, $currentLanguage = true)
    {
        // $query = 'SELECT id, category, created_at,';
        if ($currentLanguage) {

            $project = DB::db()->query("SELECT
                            id,  
                            JSON_UNQUOTE(JSON_EXTRACT(title, '$." . locale() . "')) AS title,
                            JSON_UNQUOTE(JSON_EXTRACT(description, '$." . locale() . "')) AS description,
                            technologies,
                            category,
                            host_url,
                            github_url,
                            created_at
                            FROM projects WHERE id=$id")->fetch();
        } else {
            $project = $this->get('*', ['id' => $id])->getData();
            $project['title_en'] = json_decode($project['title'])->en;
            $project['title_ar'] = json_decode($project['title'])->ar;
            $project['description_en'] = json_decode($project['description'])->en;
            $project['description_ar'] = json_decode($project['description'])->ar;
        }
        return $project;
    }

    public function getProjectImages($projectId)
    {
        return DB::db()->query("SELECT * FROM project_images WHERE project_id = :project_id ORDER BY is_main DESC, id ASC", [':project_id' => $projectId])->fetchAll();
    }

    public function getCategories()
    {
        return [
            ['id' => 'web_development', 'name' => __("web_development")],
            ['id' => 'mobile_app', 'name' => __("mobile_app")],
            ['id' => 'desktop_app', 'name' => __("desktop_app")],
            ['id' => 'ui_ux_design', 'name' => __("ui_ux_design")],
            ['id' => 'other', 'name' => __("other")]
        ];
    }
}
