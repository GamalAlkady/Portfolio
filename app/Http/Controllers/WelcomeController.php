<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use Devamirul\PhpMicro\core\Foundation\Controller\BaseController;

class WelcomeController extends BaseController {

    /**
     * View welcome page.
     */
    public function index(Request $request) {
        $user = new Orders();
       $users = $user->select([
            "first_name",
            "email"
        ], [
            // Where condition.
            "user_id[>]" => 10
        ])->getData();

//        var_dump($users);
//        die('aa');
        return view('index');
    }

}
