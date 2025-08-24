<?php
namespace App\Models;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;

use Devamirul\PhpMicro\core\Foundation\Models\BaseModel;

class Projects extends BaseModel {
    public $table = "projects";
    protected $fillable = [
        'title',
        'description',
        'category',
        'technologies',
        'host_url',
        'github_url',
        'created_at',
    ];

    public function getAll($additionalComands='', $currentLanguage=true) {
        if($currentLanguage){
            $projects = DB::db()->query("SELECT
                            id,  
                            JSON_UNQUOTE(JSON_EXTRACT(title, '$.".locale()."')) AS title,
                            JSON_UNQUOTE(JSON_EXTRACT(description, '$.".locale()."')) AS description,
                            technologies,
                            category,
                            host_url,
                            github_url,
                            created_at
                            FROM projects $additionalComands")->fetchAll();
        }else{
            $projects = $this->select('*')->getData();
        }
        return $projects;
    }

    public function getProject($id,$currentLanguage=true) {
        // $query = 'SELECT id, category, created_at,';
        if($currentLanguage){

            $project = DB::db()->query("SELECT
                            id,  
                            JSON_UNQUOTE(JSON_EXTRACT(title, '$.".locale()."')) AS title,
                            JSON_UNQUOTE(JSON_EXTRACT(description, '$.".locale()."')) AS description,
                            technologies,
                            category,
                            host_url,
                            github_url,
                            created_at
                            FROM projects WHERE id=$id")->fetch();
        }else{
            $project = $this->get('*', ['id' => $id])->getData();
            $project['title_en'] = json_decode($project['title'])->en;
            $project['title_ar'] = json_decode($project['title'])->ar;
            $project['description_en'] = json_decode($project['description'])->en;
            $project['description_ar'] = json_decode($project['description'])->ar;
        }
        return $project;
    }
}
