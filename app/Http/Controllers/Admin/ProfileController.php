<?php

namespace App\Http\Controllers\Admin;

use App\Models\Skills;
use App\Models\Users;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\Session;
use HTMLPurifier;
use HTMLPurifier_Config;
use Rakit\Validation\Validator;


class ProfileController
{
    public function index()
    {
        $user = (new Users())->get('*',['id'=>auth()->user()['id']])->getData();
        return viewAdmin('profile',compact('user'));
    }

    public function update(Request $request)
    {
        $id = auth()->user()['id'];
        $users = (new Users());

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $isAjax=true;
        }

        $data = $request->except('_method','csrf');
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        if (isset($_POST['description'])) $data['description'] = $purifier->purify($_POST['description']);
        elseif (isset($_POST['education'])) $data['education'] = $purifier->purify($_POST['education']);
        elseif (isset($_POST['experience'])) $data['experience'] = $purifier->purify($_POST['experience']);
//        return json_encode(['success'=>false,'message'=>$data]);

        if (isset($_POST['image'])) {
            $image = uploadImage('image', 'user', $_POST['image']);
            if ($image) $data['image'] = $image;
        }
        $p = $users->update($data, ['id' => $id]);
        if ($p->error() != null) {
            if (isset($isAjax))
                return json_encode(['success'=>false,'message'=>$p->error()]);
            return back()->withError($p->error());
        }
//        destroy_old();
        if (isset($isAjax))
            return json_encode(['success'=>true,'message'=>"Profile updated successfully."]);
        flushMessage()->set('success','Skill updated successfully.');
        return back();
    }


    public function destroy(Request $request)
    {
        $id = auth()->user()['id'];

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
            'description' => 'nullable|min:10',
            'category' => 'required'
        ]);

        if ($validation->fails()){
            flushMessage()->set('old', $_POST);
            $errors = $validation->errors();
            return back()->withError($errors);
        }
        unset($data['csrf']);
        return $data;
    }
}