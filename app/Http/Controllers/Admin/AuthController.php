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
        // Check if user has remember cookie and auto-login
        $authAttempt = new AuthAttempt();
        if ($authAttempt->checkRememberCookie()) {
            return redirect('/admin/dashboard');
        }
        
        return layout('blankLayout')-> view('login');
    }
    /**
     * View welcome page.
     */
    public function login(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember', false);
        
        (new AuthAttempt())->attempt([
            'email' => $email,
            'password' => $password
        ], '/admin/dashboard', (bool)$remember);
    }

    public function destroy() {
        (new AuthAttempt())->destroy();
        return redirect('/');
    }

//    public function destroy() {
//        (new AuthAttempt())->guard('editor')->destroy('/editors/login');
//    }
}
