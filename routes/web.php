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
Router::get('/projects', [WelcomeController::class, 'showProjects'])->name('showProjects');

Router::get('/login', [AuthController::class, 'create'])->name('login')->middleware('guest');
Router::post('/login', [AuthController::class, 'login']);
Router::get('/logout', [AuthController::class, 'destroy'])->name('logout')->middleware('auth');

Router::get("/admin/", [DashboardController::class,'index'])->middleware('auth');
Router::get("/admin/dashboard", [DashboardController::class,'index'])->name("dashboard")->middleware('auth');

/**  Projects  */
Router::get("/admin/projects", [Admin\ProjectController::class,'index'])->name("projects")->middleware('auth');
Router::get('/admin/projects/datatable', [App\Http\Controllers\Admin\ProjectController::class, 'dataTable'])->middleware('auth');
Router::get("/admin/project/details/:id", [Admin\ProjectController::class,'show'])->name("project.details")->middleware('auth');
Router::get("/admin/projects/add", [Admin\ProjectController::class,'create'])->name("addProject")->middleware('auth');
Router::post("/admin/projects/store", [Admin\ProjectController::class,'store'])->name("storeProject")->middleware('auth');
Router::get("/admin/projects/:id/edit", [Admin\ProjectController::class,'edit'])->name("editProject")->middleware('auth');
Router::put("/admin/projects/:id/update", [Admin\ProjectController::class,'update'])->name("updateProject")->middleware('auth');
Router::delete("/admin/projects/:id/delete", [Admin\ProjectController::class,'destroy'])->name('deleteProject')->middleware('auth');


Router::get("/admin/projects/images/:project_id", [Admin\ProjectController::class,'getImages'])->name("getImages")->middleware('auth');
Router::post("/admin/projects/images/:project_id/add", [Admin\ProjectController::class,'addImage'])->name("addImage")->middleware('auth');
Router::put("/admin/projects/images/:id/replace", [Admin\ProjectController::class,'replaceImage'])->name("replaceImage")->middleware('auth');
Router::delete("/admin/projects/images/:id/delete", [Admin\ProjectController::class,'deleteImage'])->name("deleteImage")->middleware('auth');
Router::post("/admin/projects/images/:id/set-main", [Admin\ProjectController::class,'setMainImage'])->name("setMainImage")->middleware('auth');


/**  Skills */
Router::get("/admin/skills", [Admin\SkillController::class,'index'])->name("skills")->middleware('auth');
Router::get('/admin/skills/datatable', [Admin\SkillController::class, 'dataTable'])->middleware('auth');
Router::get("/admin/skills/add", [Admin\SkillController::class,'create'])->name("addSkill")->middleware('auth');
Router::post("/admin/skills/store", [Admin\SkillController::class,'store'])->name("storeSkill")->middleware('auth');
Router::get("/admin/skills/:id/edit", [Admin\SkillController::class,'edit'])->name("editSkill")->middleware('auth');
Router::put("/admin/skills/:id/update", [Admin\SkillController::class,'update'])->name("updateSkill")->middleware('auth');
Router::delete("/admin/skills/:id/delete", [Admin\SkillController::class,'destroy'])->name('deleteSkill')->middleware('auth');


Router::get("/admin/profile", [Admin\ProfileController::class,'index'])->name('profile')->middleware('auth');
Router::put("/admin/profile", [Admin\ProfileController::class,'update'])->name('updateProfile')->middleware('auth');



