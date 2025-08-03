<?php

namespace App\Http\Controllers\Admin;

use App\Models\Projects;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\Flush;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\Session;
use Rakit\Validation\Validator;


class ProjectController
{
    public function index()
    {
//        $projects = (new Projects())->select("*")->getData();
        return viewAdmin('projects/index');
//        return layout('admin/app')->view('/admin/projects/index', compact('projects'));
    }

    public function dataTable(Request $request)
    {
        $start = $_GET['start'] ?? 0;
        $limit = $_GET['length'] ?? 10;
        $search = $_GET['search']['value'] ?? '';
        
        $params = [':search' => "%$search%"];
        
        // ✅ حساب عدد السجلات بعد الفلترة
        $countFiltered = DB::db()->query(
            "SELECT COUNT(*) as total FROM projects WHERE title LIKE :search OR description LIKE :search", 
            $params
        )->fetch()['total'];
        
        // ✅ جلب البيانات مع التقطيع
        $params[':start'] = (int)$start;
        $params[':limit'] = (int)$limit;
        
        $query = DB::db()->query(
            "SELECT * FROM projects WHERE title LIKE :search OR description LIKE :search LIMIT :start, :limit", 
            $params
        )->fetchAll();
        
        // ✅ العدد الكلي بدون فلترة
        $total = (new Projects())->count()->getData();
        
        header('Content-Type: application/json');
        
        return json_encode([
            "draw" => (int) $_GET['draw'],
            "recordsTotal" => $total,
            "recordsFiltered" => $countFiltered,
            "data" => $query
        ]);
        

    }


    public function show(Request $request)
    {
        $project = (new Projects())->get("*",['id'=>$request->getParam('id')])->getData();
        $images = DB::db()->select("project_images","*",['project_id'=>$project['id']]);
        return viewAdmin('projects/details', compact('project','images'));
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
        $projects = (new Projects());
        $data = $this->extracted($request, true);
        unset($data['_method']);
        $p = $projects->update($data, ['id' => $request->input('id')]);
        if ($p->error() != null) {
            return back()->withError($p->error());
        }
        flushMessage()->set('success','Project updated successfully.');
        return toRoute('projects');
    }

    public function destroy(Request $request)
    {
        $id = $request->getParam('id');

        $projectImages = DB::db()->select("project_images","path",['project_id'=>$id]);

        $projects = new Projects();

        $project = $projects->delete(['id'=>$id]);
        if ($project->error()!=null){
            return json_encode(['success'=>false,'message'=>$project->error()]);
        }
        foreach ($projectImages as $image){
            removeFile($image);
        }
        // flushMessage()->set("success","Project deleted successfully.");
        return json_encode(['success'=>true,'message'=>"Project deleted successfully."]);
    }

    public function getImages(Request $request){
        $images = DB::db()->select("project_images","*",['project_id'=>$request->getParam('project_id')]);
        header('Content-Type: application/json');
        echo json_encode($images);
    }
    public function addImage(Request $request)
    {
        $projectId = $request->getParam('project_id');
        $images = uploadMultipleImages('images');
//        return json_encode(['success'=>$images,'message'=>!is_array($_FILES['images']['name'])]);
        $projectImages=[];
        foreach ($images as $image){
            $projectImages[]=['path'=>$image,'project_id'=>$projectId,'is_main'=>0];
        }

        $database = DB::db();
        $table = $database->insert('project_images',$projectImages);
        if ($table->rowCount()==0){
            return back()->withError($database->error());
            return json_encode(['success'=>false,'message'=>$database->error()]);
        }
         flushMessage()->set('success','Project image added successfully.');
        return  back();
        return toRoute('updateProject',['id'=>$projectId]);
//        return json_encode(['success'=>true,'message'=>"Project image added successfully."]);
    }

    public function replaceImage(Request $request)
    {
        $projectImage = DB::db()->get("project_images","*",['id'=>$request->getParam('id')]);
        if ($projectImage==null){
            return back()->withError("Image not found");
        }

        $path = uploadImage('image');
        if ($path==null){
            return back()->withError("Can't save project image");
        }

        removeFile($projectImage['path']);
        $projectImage['path'] = $path;
        $projectImage['is_main'] = $request->input('is_main');

        $database = DB::db();
       $data =  $database->update("project_images",$projectImage,['id'=>$request->getParam('id')]);
        if ($data->rowCount()==0){
            return back()->withError($database->error());
        }
        flushMessage()->set('success','Project image replaced successfully.');
        return toRoute('project.details',['id'=>$projectImage['project_id']]);
    }

    public function deleteImage(Request $request)
    {
        $projectImage = DB::db()->get("project_images","*",['id'=>$request->getParam('id')]);
        if ($projectImage==null){
            return back()->withError("Image not found");
        }
        removeFile($projectImage['path']);
        $database = DB::db();
        $data =  $database->delete("project_images",['id'=>$request->getParam('id')]);
        if ($data->rowCount()==0){
            // return back()->withError($database->error());
            return json_encode(['success'=>false,'message'=>$database->error()]);
        }
        // flushMessage()->set('success','Project image deleted successfully.');
        return json_encode(['success'=>true,'message'=>'Project image deleted successfully.']);
    }

    public function setMainImage(Request $request)
    {
        $database = DB::db();

        $projectImage = $database->get("project_images","*",['id'=>$request->getParam('id')]);

        $projectMainImage = $database->get("project_images","*",['project_id'=>$projectImage['project_id'],'is_main'=>1]);
        if ($projectMainImage!=null){
            $data =  $database->update("project_images",['is_main'=>0],['id'=>$projectMainImage['id']]);
            if ($data->rowCount()==0){
                // return back()->withError($database->error());
                return json_encode(['success'=>false,'message'=>$database->error()]);
                exit;
            }
        }
        if ($projectImage==null){
            // return back()->withError("Image not found");
            return json_encode(['sucess'=>false,'message'=>'Image not found']);
            exit;
        }

        $data =  $database->update("project_images",['is_main'=>1],['id'=>$projectImage['id']]);
        if ($data->rowCount()==0){
            return json_encode(['success'=>false,'message'=>$database->error()]);
            exit;
        }
        return json_encode(['success'=>true,'message'=>'Image set main successfully.']);
    }


    /**
     * @param Request $request
     * @return \Devamirul\PhpMicro\core\Foundation\Application\Redirect\Redirect
     */
    public function extracted(Request $request, $removeOld = false): \Devamirul\PhpMicro\core\Foundation\Application\Redirect\Redirect|array
    {
        $data = $request->input();
        $projectId = $data['id'];
        $validator = new Validator([
            "images.*"=>"images is required"
        ]);

        $validation = $validator->validate($data + $_FILES, [
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'category' => 'required',
            'technologies' => 'required',
            'images' => "required_without:id|array|uploaded_file:0,1M,png,jpeg",
            'host_url' => 'nullable|url',
            'github_url' => 'nullable|url',
        ]);

        if ($validation->fails()){
            flushMessage()->set('old', $_POST);
            flushMessage()->set('old_files', $_FILES);
            $errors = $validation->errors();
            return back()->withError($errors);
        }
        unset($data['csrf']);
        return $data;
    }
}