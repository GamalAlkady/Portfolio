<?php

namespace App\Http\Controllers\Admin;

use App\Models\Projects;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\Flush;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use Rakit\Validation\Validator;


class ProjectsController
{
    public function index()
    {
        $projects = (new Projects())->select("*")->getData();
        return viewAdmin('projects/index', compact('projects'));
//        return layout('admin/app')->view('/admin/projects/index', compact('projects'));
    }

    public function show(Request $request)
    {
        $project = (new Projects())->get("*",['id'=>$request->getParam('id')])->getData();
        return viewAdmin('projects/details', compact('project'));
//        return layout('admin/app')->view('/admin/projects/index', compact('projects'));
    }


    public function create()
    {
        return viewAdmin('projects/add');
//        return layout('admin/app')->view('/admin/add_project');
    }

    public function store(Request $request)
    {
        $data = $this->extracted($request);

        $database = DB::db();

        try {
            $database->pdo->beginTransaction();

            $database->insert("projects", $data);

            $projectId = $database->id();
            $images = uploadMultipleImages('images');

            $projectImages=[];
            foreach ($images as $image){
                $projectImages[]=['path'=>$image,'project_id'=>$projectId,'is_main'=>0];
            }

            $projectImages[0]['is_main']=1;
            $table = $database->insert('project_images',$projectImages);

            if ($table->rowCount()==0){
                $database->pdo->rollBack();
                return back()->withError("Can't save project");
            }
            /* Commit the changes */
            $database->pdo->commit();
        }catch (\Exception $exception){
            // On any failure, rollback all
            $database->pdo->rollBack();
        }
        flushMessage()->set('success','Project added successfully.');
        return toRoute('projects');
    }

    public function edit(Request $request)
    {
        $project = (new Projects())->get('*', ["id" => $request->getParam('id')])->getData();
        $images = DB::db()->select("project_images","*",['project_id'=>$project['id']]);

        return viewAdmin('projects/edit',compact('project','images'));
//        return layout('admin/app')->view('/admin/edit_project', compact('project'));
    }

    public function update(Request $request)
    {
//        dd($request->all());
        $projects = (new Projects());
        $data = $this->extracted($request, true);

        $p = $projects->update($data, ['id' => $request->input('id')]);
        if ($p->error() != null) {
            return back()->withError($p->error());
        }
        flushMessage()->set('success','Project updated successfully.');
        return toRoute('projects');
    }

    /**
     * @param Request $request
     * @return \Devamirul\PhpMicro\core\Foundation\Application\Redirect\Redirect
     */
    public function extracted(Request $request, $removeOld = false): \Devamirul\PhpMicro\core\Foundation\Application\Redirect\Redirect|array
    {
//        TODO: test add project
        $data = $request->input();
        $validator = new Validator();
        $validation = $validator->validate($data + $_FILES, [
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'category' => 'required',
            'technologies' => 'required',
            'images.*' => 'required|uploaded_file:0,1M,png,jpeg',
            'host_url' => 'nullable|url',
            'github_url' => 'nullable|url',
        ]);

        if ($validation->fails()){
            $errors = $validation->errors();
            return back()->withError($errors);
        }
        unset($data['csrf']);
        return $data;
    }


    public function destroy(Request $request){

        $id = $request->getParam('id');
        $projects = new Projects();
        $project = $projects->delete(['id'=>$id]);
        if ($project->error()!=null){
            return back()->withError($project->error());
        }
        flushMessage()->set("success","Record deleted successfully.");
        return toRoute('projects');
//        redirect("/admin/projects");
    }
}