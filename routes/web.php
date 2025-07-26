<?php
// Get singleton route instance.
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\WelcomeController;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\Router;

/**
 * Here is where you can register routes for your application.
 */

Router::get('/', [WelcomeController::class, 'index'])->name('welcome');

Router::get('/login', [AuthController::class, 'create']);
Router::post('/login', [AuthController::class, 'login']);
Router::delete('/logout', [AuthController::class, 'destroy'])->name('logout')->middleware('auth');

Router::get("/admin", [DashboardController::class,'index']);
Router::get("/admin/dashboard", [DashboardController::class,'index'])->name("dashboard");

/**  Projects  */
Router::get("/admin/projects", [Admin\ProjectsController::class,'index'])->name("projects");
Router::get("/admin/project/details/:id", [Admin\ProjectsController::class,'show'])->name("project.details");
Router::get("/admin/add-project", [Admin\ProjectsController::class,'create'])->name("addProject");
Router::post("/admin/add-project", [Admin\ProjectsController::class,'store'])->name("storeProject");

Router::get("/admin/edit-project/:id", [Admin\ProjectsController::class,'edit'])->name("editProject");
Router::post("/admin/update-project", [Admin\ProjectsController::class,'update'])->name("updateProject");
Router::get("/admin/delete-project/:id", [Admin\ProjectsController::class,'destroy']);


