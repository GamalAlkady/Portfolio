<?php
// Get singleton route instance.
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Api\TranslationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use Devamirul\PhpMicro\core\Foundation\Application\Facade\Facades\Router;

/**
 * Here is where you can register routes for your application.
 */

Router::get('/', [HomeController::class, 'index'])->name('home')->middleware('maintenance');
Router::get('/maintenance', [HomeController::class, 'maintenance'])->name('maintenance');
Router::post('/sendEmail', [NotificationController::class, 'sendEmail'])->name('sendEmail');
Router::get('/projects', [HomeController::class, 'showProjects'])->name('showProjects')->middleware('maintenance');

// API Routes for translations
Router::get('/api/translations/:locale', [TranslationController::class, 'getTranslations'])->name('api.translations');

Router::get('/login', [AuthController::class, 'create'])->name('login')->middleware('guest');
Router::post('/login', [AuthController::class, 'login']);
Router::get('/logout', [AuthController::class, 'destroy'])->name('logout')->middleware('auth');

Router::get("/admin/", [DashboardController::class,'index'])->middleware('auth');
Router::get("/admin/dashboard", [DashboardController::class,'index'])->name("dashboard")->middleware('auth');
Router::get("/admin/visitors", [DashboardController::class,'visitors'])->name("visitors")->middleware('auth');

/**  Projects  */
Router::get("/admin/projects", [Admin\ProjectController::class,'index'])->name("projects")->middleware('auth');
Router::get('/admin/projects/datatable', [App\Http\Controllers\Admin\ProjectController::class, 'dataTable'])->middleware('auth');
Router::get("/admin/project/details/:id", [Admin\ProjectController::class,'show'])->name("project.details")->middleware('auth');
Router::get("/admin/projects/add", [Admin\ProjectController::class,'create'])->name("project.add")->middleware('auth');
Router::post("/admin/projects/store", [Admin\ProjectController::class,'store'])->name("project.store")->middleware('auth');
Router::get("/admin/projects/:id/edit", [Admin\ProjectController::class,'edit'])->name("project.edit")->middleware('auth');
Router::put("/admin/projects/:id/update", [Admin\ProjectController::class,'update'])->name("project.update")->middleware('auth');
Router::delete("/admin/projects/:id/delete", [Admin\ProjectController::class,'destroy'])->name("project.delete")->middleware('auth');


Router::get("/admin/projects/images/:project_id", [Admin\ProjectController::class,'getImages'])->name("project.getImages")->middleware('auth');
Router::post("/admin/projects/images/:project_id/add", [Admin\ProjectController::class,'addImage'])->name("project.addImage")->middleware('auth');
Router::put("/admin/projects/images/:id/replace", [Admin\ProjectController::class,'replaceImage'])->name("project.replaceImage")->middleware('auth');
Router::delete("/admin/projects/images/:id/delete", [Admin\ProjectController::class,'deleteImage'])->name("project.deleteImage")->middleware('auth');
Router::post("/admin/projects/images/:id/set-main", [Admin\ProjectController::class,'setMainImage'])->name("project.setMainImage")->middleware('auth');


/**  Skills */
Router::get("/admin/skills", [Admin\SkillController::class,'index'])->name("skills")->middleware('auth');
Router::get('/admin/skills/datatable', [Admin\SkillController::class, 'dataTable'])->middleware('auth');
Router::get("/admin/skills/add", [Admin\SkillController::class,'create'])->name("skill.add")->middleware('auth');
Router::post("/admin/skills/store", [Admin\SkillController::class,'store'])->name("skill.store")->middleware('auth');
Router::get("/admin/skills/:id/edit", [Admin\SkillController::class,'edit'])->name("skill.edit")->middleware('auth');
Router::put("/admin/skills/:id/update", [Admin\SkillController::class,'update'])->name("skill.update")->middleware('auth');
Router::delete("/admin/skills/:id/delete", [Admin\SkillController::class,'destroy'])->name('skill.delete')->middleware('auth');


Router::get("/admin/profile", [Admin\ProfileController::class,'index'])->name('profile')->middleware('auth');
Router::put("/admin/profile", [Admin\ProfileController::class,'update'])->name('updateProfile')->middleware('auth');

Router::get("/admin/settings", [Admin\SettingController::class,'index'])->name('settings')->middleware('auth');
Router::put("/admin/setting", [Admin\SettingController::class,'update'])->name('updateSetting')->middleware('auth');
Router::put("/admin/setting/reset", [Admin\SettingController::class,'reset'])->name('resetSetting')->middleware('auth');

Router::get('/language/:locale', [Admin\LanguageController::class, 'switch'])->name('language.switch');



