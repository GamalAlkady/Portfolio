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
Router::get("/admin/projects", [Admin\ProjectController::class,'index'])->name("projects");
Router::get('/admin/projects/datatable', [App\Http\Controllers\Admin\ProjectController::class, 'dataTable']);
Router::get("/admin/project/details/:id", [Admin\ProjectController::class,'show'])->name("project.details");
Router::get("/admin/projects/add", [Admin\ProjectController::class,'create'])->name("addProject");
Router::post("/admin/projects/store", [Admin\ProjectController::class,'store'])->name("storeProject");
Router::get("/admin/projects/:id/edit", [Admin\ProjectController::class,'edit'])->name("editProject");
Router::put("/admin/projects/:id/update", [Admin\ProjectController::class,'update'])->name("updateProject");
Router::delete("/admin/projects/:id/delete", [Admin\ProjectController::class,'destroy']);


Router::post("/admin/projects/:id/add", [Admin\ProjectController::class,'addImage'])->name("addImage");
Router::put("/admin/projects/images/:id/replace", [Admin\ProjectController::class,'replaceImage'])->name("replaceImage");
Router::delete("/admin/projects/images/:id/delete", [Admin\ProjectController::class,'deleteImage'])->name("deleteImage");
Router::post("/admin/projects/images/:id/set-main", [Admin\ProjectController::class,'setMainImage'])->name("setMainImage");


/**  Skills */
Router::get("/admin/skills", [Admin\SkillController::class,'index'])->name("skills");
Router::get('/admin/skills/datatable', [Admin\SkillController::class, 'dataTable']);
Router::get("/admin/skills/add", [Admin\SkillController::class,'create'])->name("skill.add");
Router::post("/admin/skills/store", [Admin\SkillController::class,'store'])->name("skill.store");
Router::get("/admin/skills/:id/edit", [Admin\SkillController::class,'edit'])->name("skill.edit");
Router::put("/admin/skills/:id/update", [Admin\SkillController::class,'update'])->name("skill.update");
Router::delete("/admin/skills/:id/delete", [Admin\SkillController::class,'destroy']);
