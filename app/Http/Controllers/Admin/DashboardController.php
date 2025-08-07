<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orders;
use App\Models\Projects;
use App\Models\Skills;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\DB;

class DashboardController
{
    public function index(){
        $data = [];
        $data['countProjects'] = (new Projects())->count()->getData();
        $data['countOrders'] =(new Orders())->count()->getData();
        $data['countSkills'] =(new Skills())->count()->getData();
        $data['orders'] = DB::db()->query("SELECT o.*, p.title AS project_title 
                      FROM orders o 
                      JOIN projects p ON o.project_id = p.id")->fetchAll();

        $data['projects'] = DB::db()->query("SELECT * FROM projects order by created_at DESC LIMIT 4")->fetchAll();

//        var_dump($data);
//        die();
        return layout('admin/app')->view('/admin/dashboard',$data);
    }
}