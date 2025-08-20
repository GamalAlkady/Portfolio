<?php

namespace App\Http\Controllers\Admin;

use App\Models\Skills;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\Session;
use Rakit\Validation\Validator;


class SkillController
{
    public function index()
    {
        $skills = new Skills();


        // dd($skills->getAll());
        return viewAdmin('skills/index');
    }

    public function dataTable(Request $request)
    {
        $start = $_GET['start'] ?? 0;
        $limit = $_GET['length'] ?? 10;
        $search = $_GET['search']['value'] ?? '';

        $params = [':search' => "%$search%"];

        $skills = new Skills();
        // ✅ حساب عدد السجلات بعد الفلترة
        $countFiltered = DB::db()->query(
            "SELECT COUNT(*) as total FROM skills WHERE name LIKE :search OR description LIKE :search",
            $params
        )->fetch()['total'];

        // ✅ جلب البيانات مع التقطيع
        $params[':start'] = (int)$start;
        $params[':limit'] = (int)$limit;

        $query = $skills->getAll("WHERE name LIKE :search OR description LIKE :search LIMIT :start, :limit", true, $params);
        // $query = DB::db()->query(
        //     "SELECT * FROM skills WHERE name LIKE :search OR description LIKE :search LIMIT :start, :limit",
        //     $params
        // )->fetchAll();

        // ✅ العدد الكلي بدون فلترة
        $total = $skills->count()->getData();

        header('Content-Type: application/json');

        return json_encode([
            "draw" => (int) $_GET['draw'],
            "recordsTotal" => $total,
            "recordsFiltered" => $countFiltered,
            "data" => $query
        ]);
    }

    public function create()
    {
        $categories = [
            ['id' => 'technical_skills', 'name' => __('technical_skills')],
            ['id' => 'design_skills', 'name' => __('design_skills')],
            ['id' => 'personal_skills', 'name' => __('personal_skills')],
            ['id' => 'other', 'name' => __('other')]
        ];
        return viewAdmin('skills/add', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->extracted($request);

        $database = DB::db();

        try {
            $database->pdo->beginTransaction();

            $database->insert("skills", $data);

            $skillId = $database->id();

            /* Commit the changes */
            $database->pdo->commit();
        } catch (\Exception $exception) {
            // On any failure, rollback all
            $database->pdo->rollBack();
        }
        //        destroy_old();
        flushMessage()->set('success', 'Skill added successfully.');
        return toRoute('skills');
    }

    public function edit(Request $request)
    {
        $categories = [
            ['id' => 'technical_skills', 'name' => __('technical_skills')],
            ['id' => 'design_skills', 'name' => __('design_skills')],
            ['id' => 'personal_skills', 'name' => __('personal_skills')],
            ['id' => 'other', 'name' => __('other')]
        ];

        $skill = (new Skills())->getSkill($request->getParam('id'), false);
        // dd($skill);
        return viewAdmin('skills/edit', compact('skill', 'categories'));
    }

    public function update(Request $request)
    {
        $skills = (new Skills());
        $data = $this->extracted($request, true);
        unset($data['_method']);
        // dd($request->input());
        $p = $skills->update($data, ['id' => $request->input('id')]);
        if ($p->error() != null) {
            return back()->withError($p->error());
        }
        //        destroy_old();
        flushMessage()->set('success', 'Skill updated successfully.');
        return toRoute('skills');
    }

    public function destroy(Request $request)
    {
        $id = $request->getParam('id');
        $skills = new Skills();
        $skill = $skills->delete(['id' => $id]);
        if ($skill->error() != null) {
            return json_encode(['success' => false, 'message' => $skill->error()]);
        }
        // flushMessage()->set("success","Skill deleted successfully.");
        return json_encode(['success' => true, 'message' => "Skill deleted successfully."]);
    }


    /**
     * @param Request $request
     * @return \Devamirul\PhpMicro\core\Foundation\Application\Redirect\Redirect
     */
    public function extracted(Request $request, $removeOld = false): \Devamirul\PhpMicro\core\Foundation\Application\Redirect\Redirect|array
    {
        $data = $request->input();
        // رسائل التحقق بالعربية والإنجليزية
        $messages = [
            // رسائل العنوان - عربي
            'name.ar:required' => __('required_field'),
            'name.ar:min' => __('min_number', ['number' => 3]),
            'name.ar:max' => __('max_number', ['number' => 255]),

            // رسائل العنوان - إنجليزي
            'name.en:required' => __('required_field'),
            'name.en:min' => __('min_number', ['number' => 3]),
            'name.en:max' => __('max_number', ['number' => 255]),

            // رسائل الوصف - عربي
            'description.ar:required' => __('required_field'),
            'description.ar:min' => __('min_number', ['number' => 10]),
            'description.ar:max' => __('max_number', ['number' => 5000]),

            // رسائل الوصف - إنجليزي
            'description.en:required' => __('required_field'),
            'description.en:min' => __('min_number', ['number' => 10]),
            'description.en:max' => __('max_number', ['number' => 5000]),

            // رسائل التصنيف
            'category:required' => __('category_required'),

        ];

        $validator = new Validator($messages);

        // قواعد التحقق الأساسية
        $rules = [
            'name' => 'array',
            'description' => 'array',
            'category' => 'required'
        ];

        // قواعد حسب اللغة الحالية
        if (locale() == 'en') {
            $rules['name.en'] = 'required|min:3|max:255';
            $rules['description.en'] = 'required|min:10|max:5000';
            $rules['name.ar'] = 'nullable|min:3|max:255';
            $rules['description.ar'] = 'nullable|min:10|max:5000';
        } else {
            $rules['name.ar'] = 'required|min:3|max:255';
            $rules['description.ar'] = 'required|min:10|max:5000';
            $rules['name.en'] = 'nullable|min:3|max:255';
            $rules['description.en'] = 'nullable|min:10|max:5000';
        }

        // التحقق من وجود محتوى بلغة واحدة على الأقل
        $hasArabicContent = !empty($data['name']['ar']) || !empty($data['description']['ar']);
        $hasEnglishContent = !empty($data['name']['en']) || !empty($data['description']['en']);

        if (!$hasArabicContent && !$hasEnglishContent) {
            return back()->withError(__('at_least_one_language_required'));
        }

        // dd($data);
        $validation = $validator->validate($data + $_FILES, $rules);

        if ($validation->fails()) {
            flushMessage()->set('old', $data);
            $invalidData = $validation->getInvalidData();
            $activeEn=true;
            if(empty($invalidData['name']['en']) || empty($invalidData['description']['en'])) $activeEn=false;
            // dd($validation->getValidatedData());
            $errors = $validation->errors();
            return back()->withError($errors)->withData('activeEn',$activeEn);
        }

        // dd($validation->getValidatedData());

        $data['name'] = json_encode($data['name']);
        $data['description'] = json_encode($data['description']);
        // dd($data);
        unset($data['csrf']);
        return $data;
    }
}
