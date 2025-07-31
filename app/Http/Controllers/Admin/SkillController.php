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
        return viewAdmin('skills/index');
    }

    public function dataTable(Request $request)
    {
        $start = $_GET['start'] ?? 0;
        $limit = $_GET['length'] ?? 10;
        $search = $_GET['search']['value'] ?? '';
        
        $params = [':search' => "%$search%"];
        
        // ✅ حساب عدد السجلات بعد الفلترة
        $countFiltered = DB::db()->query(
            "SELECT COUNT(*) as total FROM skills WHERE name LIKE :search OR description LIKE :search",
            $params
        )->fetch()['total'];
        
        // ✅ جلب البيانات مع التقطيع
        $params[':start'] = (int)$start;
        $params[':limit'] = (int)$limit;
        
        $query = DB::db()->query(
            "SELECT * FROM skills WHERE name LIKE :search OR description LIKE :search LIMIT :start, :limit",
            $params
        )->fetchAll();
        
        // ✅ العدد الكلي بدون فلترة
        $total = (new Skills())->count()->getData();
        
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
        return viewAdmin('skills/add');
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
        }catch (\Exception $exception){
            // On any failure, rollback all
            $database->pdo->rollBack();
        }
        destroy_old();
        flushMessage()->set('success','Skill added successfully.');
        return toRoute('skills');
    }

    public function edit(Request $request)
    {
        $skill = (new Skills())->get('*', ["id" => $request->getParam('id')])->getData();
        return viewAdmin('skills/edit',compact('skill'));
    }

    public function update(Request $request)
    {
        $skills = (new Skills());
        $data = $this->extracted($request, true);
        unset($data['_method']);
        $p = $skills->update($data, ['id' => $request->input('id')]);
        if ($p->error() != null) {
            return back()->withError($p->error());
        }
        destroy_old();
        flushMessage()->set('success','Skill updated successfully.');
        return toRoute('skills');
    }

    public function destroy(Request $request)
    {
        $id = $request->getParam('id');
        $skills = new Skills();
        $skill = $skills->delete(['id'=>$id]);
        if ($skill->error()!=null){
            return json_encode(['success'=>false,'message'=>$skill->error()]);
        }
        // flushMessage()->set("success","Skill deleted successfully.");
        return json_encode(['success'=>true,'message'=>"Skill deleted successfully."]);
    }


    /**
     * @param Request $request
     * @return \Devamirul\PhpMicro\core\Foundation\Application\Redirect\Redirect
     */
    public function extracted(Request $request, $removeOld = false): \Devamirul\PhpMicro\core\Foundation\Application\Redirect\Redirect|array
    {
        $data = $request->input();
        $validator = new Validator();
        $validation = $validator->validate($data + $_FILES, [
            'name' => 'required|min:3',
            'description' => 'required|min:10',
            'category' => 'required'
        ]);

        if ($validation->fails()){
            Session::set('old', $_POST);
            $errors = $validation->errors();
            return back()->withError($errors);
        }
        unset($data['csrf']);
        return $data;
    }
}