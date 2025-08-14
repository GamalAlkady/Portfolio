<?php

namespace App\Http\Middlewares;

use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\Auth;
use Devamirul\PhpMicro\core\Foundation\Application\Request\Request;
use Devamirul\PhpMicro\core\Foundation\Middleware\Interface\Middleware;

class MaintenanceModeMiddleware implements Middleware {

    /**
     * Check if the request is authenticated and act accordingly.
     */
    public function handle(Request $request, array $guards) {
        // التحقق من وضع الصيانة
        if (isMaintenanceMode()) {
            // السماح للمديرين بالوصول
            if (Auth::check()) {
                return; // المدير يمكنه الوصول
            }
            // توجيه المستخدمين العاديين لصفحة الصيانة
            return redirect('/maintenance');
        }
        return;
    }

}
