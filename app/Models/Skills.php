<?php

namespace App\Models;

use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;
use Devamirul\PhpMicro\core\Foundation\Models\BaseModel;

class Skills extends BaseModel
{
    public $table = "skills";
    protected $fillable = [
        'name',
        'description',
        'category',
        'created_at',
    ];

    public function getAll($additionalComands = '', $currentLanguage = true,$params=[])
    {
        $query = 'SELECT id,category,created_at,';

          if ($currentLanguage) {
            $query .= " JSON_UNQUOTE(JSON_EXTRACT(name, '$." . locale() . "')) AS name,
                            JSON_UNQUOTE(JSON_EXTRACT(description, '$." . locale() . "')) AS description ";
        } else {
            $query .= "JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) AS name_en,
                        JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar')) AS name_ar,
                        JSON_UNQUOTE(JSON_EXTRACT(description, '$.en')) AS description_en,
                        JSON_UNQUOTE(JSON_EXTRACT(description, '$.ar')) AS description_ar ";
        }
        $skills = DB::db()->query("$query FROM skills $additionalComands", $params)->fetchAll();

        return $skills;
    }

    public function getSkill($id, $currentLanguage = true)
    {
        $query = 'SELECT id,category,created_at,';
        if ($currentLanguage) {
            $query .= " JSON_UNQUOTE(JSON_EXTRACT(name, '$." . locale() . "')) AS name,
                            JSON_UNQUOTE(JSON_EXTRACT(description, '$." . locale() . "')) AS description ";
        } else {
            $query .= "JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) AS name_en,
                        JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar')) AS name_ar,
                        JSON_UNQUOTE(JSON_EXTRACT(description, '$.en')) AS description_en,
                        JSON_UNQUOTE(JSON_EXTRACT(description, '$.ar')) AS description_ar ";
        }

        $skill = DB::db()->query("$query FROM skills WHERE id=$id")->fetch();
        // dd($skill);
        return $skill;
    }
}
