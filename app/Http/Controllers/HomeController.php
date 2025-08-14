<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Skills;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use Devamirul\PhpMicro\core\Foundation\Controller\BaseController;

class WelcomeController extends BaseController {

    /**
     * View welcome page.
     */
    public function index() {
        $data = new Skills();
       $skills = $data->select('*')->getData();
        return view('index',compact('skills'));
    }

}
