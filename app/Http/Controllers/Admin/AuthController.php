<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orders;
use App\Models\Users;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use Devamirul\PhpMicro\core\Foundation\Auth\Authentication\AuthAttempt;
use Devamirul\PhpMicro\core\Foundation\Controller\BaseController;
use function redirect;
use function view;

class AuthController extends BaseController {

    public function create(){
        return view('login');
    }
    /**
     * View welcome page.
     */
    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        (new AuthAttempt())->attempt(['email' => $email, 'password' => $password],'/admin/dashboard');
    }

    public function destroy() {
        (new AuthAttempt())->destroy();
    }

//    public function destroy() {
//        (new AuthAttempt())->guard('editor')->destroy('/editors/login');
//    }
}
