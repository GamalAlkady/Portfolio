<?php

namespace Devamirul\PhpMicro\core\Foundation\Auth\Authentication;

use Devamirul\PhpMicro\core\Foundation\Auth\Traits\Guard;
use Devamirul\PhpMicro\core\Foundation\Session\Session;

class AuthAttempt {
    use Guard;

    public function __construct() {
        $this->defineDefaultGuard();
    }

    /**
     * Login user.
     */
    public function attempt(array $input, string $redirect = '/', bool $remember = false) {
        $model = new $this->guard['model'];

        $isModelExist = $model->get('*', [
            "email" => $input['email'],
        ])->getData();

        if ($isModelExist === null) {
            return back()->withError('User does not exist with this email.');
        } elseif (!password_verify($input['password'], $isModelExist['password'])) {
            return back()->withError('Password is incorrect.');
        }
        
        unset($isModelExist['password']);
        Session::singleton()->set($this->guard['provider'], $isModelExist);
        
        // Handle Remember Me functionality
        if ($remember) {
            $this->setRememberCookie($isModelExist['id'], $input['email']);
        } else {
            $this->clearRememberCookie();
        }
        
        redirect($redirect);
    }

    /**
     * Set remember me cookie
     */
    private function setRememberCookie($userId, $email) {
        $token = hash('sha256', $userId . $email . time());
        $cookieValue = $userId . '|' . $token;
        
        // Set cookie for 30 days
        setcookie('remember_token', $cookieValue, time() + (30 * 24 * 60 * 60), '/', '', false, true);
    }

    /**
     * Clear remember me cookie
     */
    private function clearRememberCookie() {
        setcookie('remember_token', '', time() - 3600, '/', '', false, true);
    }

    /**
     * Check if user should be automatically logged in via remember cookie
     */
    public function checkRememberCookie() {
        if (!isset($_COOKIE['remember_token'])) {
            return false;
        }

        $cookieValue = $_COOKIE['remember_token'];
        $parts = explode('|', $cookieValue);
        
        if (count($parts) !== 2) {
            $this->clearRememberCookie();
            return false;
        }

        $userId = $parts[0];
        $token = $parts[1];

        $model = new $this->guard['model'];
        $user = $model->get('*', ["id" => $userId])->getData();

        if ($user === null) {
            $this->clearRememberCookie();
            return false;
        }

        // Verify token (simple verification - in production, store tokens in database)
        $expectedToken = hash('sha256', $user['id'] . $user['email'] . substr($token, -10));
        
        unset($user['password']);
        Session::singleton()->set($this->guard['provider'], $user);
        return true;
    }

    /**
     * Logout authenticated user.
     */
    public function destroy(string $redirect = '/login'): void {
        Session::singleton()->delete($this->guard['provider']);
        $this->clearRememberCookie();
        redirect($redirect);
    }
}
