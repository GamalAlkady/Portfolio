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
        $project = new Projects();
        $p = $project->insert([$data]);
        return toRoute('projects');
        redirect("/admin/projects");
    }

    public function edit(Request $request)
    {
        $project = (new Projects())->get('*', ["id" => $request->getParam('id')])->getData();
        return viewAdmin('projects/edit',compact('project'));
//        return layout('admin/app')->view('/admin/edit_project', compact('project'));
    }

    public function update(Request $request)
    {
//        dd($request->all());
        $projects = (new Projects());
        $data = $this->extracted($request, true);
        unset($data['old_image'], $data['old_other_images']);

        $p = $projects->update($data, ['id' => $request->input('id')]);
        if ($p->error() != null) {
            return back()->withError($p->error());
        }
        return toRoute('projects');
//        redirect("/admin/projects");
    }

    /**
     * @param Request $request
     * @return array
     */
    public function extracted(Request $request, $removeOld = false): array
    {
        $data = $request->input();
        $validator = new Validator();
        $validation = $validator->validate($data + $_FILES, [
            'title' => 'required',
            'category' => 'required',
            'image' => 'nullable|uploaded_file:0,500K,png,jpeg',
            'other_images' => 'nullable|array',
            'host_url' => 'nullable|url',
        ]);
        $data['image'] = uploadImage('image', removeOld: $removeOld); // 'image' هو اسم الحقل في نموذج الـ HTML
        if ($data['image'] == null)
            unset($data['image']);

        // Handle multiple other images
        $data['other_images'] = uploadMultipleImages('other_images');
        if (count($data['other_images']) == 0)
            unset($data['other_images']);
        else $data['other_images'] = json_encode($data['other_images']);
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