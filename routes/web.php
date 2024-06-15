<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AksesMenuController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskJawabanController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('/', \App\Http\Controllers\HomeController::class);

// route home 
Route::resource('/home', \App\Http\Controllers\HomeController::class);

// route menu 
Route::resource('/menu', \App\Http\Controllers\MenuController::class);
Route::get('get-menu', [MenuController::class, 'getMenu'])->name('menu.getMenu');
Route::get('/addMenu', [MenuController::class, 'addMenu'])->name('menu.addMenu');
Route::get('/getReffJenisMenu', [MenuController::class, 'getReffJenisMenu'])->name('getReffJenisMenu');
Route::get('/getMasterMenu', [MenuController::class, 'getMasterMenu'])->name('menu.getMasterMenu');
Route::get('/getReffStatusMenu', [MenuController::class, 'getReffStatusMenu'])->name('getReffStatusMenu');
Route::post('/addMenuAction', [MenuController::class, 'addMenuAction'])->name('addMenuAction');
Route::get('/infoMenu/{id_menu}', [MenuController::class, 'infoMenu'])->name('menu.infoMenu');
Route::get('/showDetailMenu/{id_menu}', [MenuController::class, 'showDetailMenu'])->name('menu.showDetailMenu');
Route::get('/editMenu/{id_menu}', [MenuController::class, 'editMenu'])->name('menu.editMenu');
Route::post('/updateMenuAction', [MenuController::class, 'updateMenuAction'])->name('updateMenuAction');
Route::post('/deleteMenuAction', [MenuController::class, 'deleteMenuAction'])->name('deleteMenuAction');



// route akses menu 
Route::resource('/aksesmenu', \App\Http\Controllers\AksesMenuController::class);
Route::get('get-aksesmenu', [AksesMenuController::class, 'getAksesMenu'])->name('aksesmenu.getAksesMenu');
Route::get('/addAksesMenu', [AksesMenuController::class, 'addAksesMenu'])->name('aksesmenu.addAksesMenu');
Route::get('/getRoleAksesMenu', [AksesMenuController::class, 'getRoleAksesMenu'])->name('getRoleAksesMenu');
Route::get('/getMenu/{id_role}', [AksesMenuController::class, 'getMenu'])->name('aksesmenu.getMenu');
Route::post('/addAksesMenuAction', [AksesMenuController::class, 'addAksesMenuAction'])->name('addAksesMenuAction');
Route::post('/deleteAksesMenuAction', [AksesMenuController::class, 'deleteAksesMenuAction'])->name('deleteAksesMenuAction');

Route::post('info-aksesmenu', [AksesMenuController::class, 'infoAksesMenu'])->name('aksesmenu.infoAksesMenu');
Route::post('edit-aksesmenu', [AksesMenuController::class, 'editAksesMenu'])->name('aksesmenu.editAksesMenu');
Route::post('delete-aksesmenu', [AksesMenuController::class, 'deleteAksesMenu'])->name('aksesmenu.deleteAksesMenu');



// route role 
Route::resource('/role', \App\Http\Controllers\RoleController::class);
Route::get('get-role', [RoleController::class, 'getRole'])->name('role.getRole');
Route::get('/addRole', [RoleController::class, 'addRole'])->name('role.addRole');
Route::post('/addRoleAction', [RoleController::class, 'addRoleAction'])->name('addRoleAction');
Route::get('/editRole/{id_role}', [RoleController::class, 'editRole'])->name('role.editRole');
Route::get('/showDetailRole/{id_role}', [RoleController::class, 'showDetailRole'])->name('role.showDetailRole');
Route::post('/updateRoleAction', [RoleController::class, 'updateRoleAction'])->name('updateRoleAction');
Route::post('/deleteRoleAction', [RoleController::class, 'deleteRoleAction'])->name('deleteRoleAction');

// nanti dihapus
Route::get('/infoRole', [RoleController::class, 'infRole'])->name('role.infoRole');
Route::get('/deleteRole', [RoleController::class, 'deleteRole'])->name('role.deleteRole');

// route user 
Route::resource('/user', \App\Http\Controllers\UserController::class);
Route::get('get-user', [UserController::class, 'getUser'])->name('user.getUser');
Route::get('/addUser', [UserController::class, 'addUser'])->name('user.addUser');
Route::get('/getReffJenisKelaminUser', [UserController::class, 'getReffJenisKelaminUser'])->name('getReffJenisKelaminUser');
Route::get('/getRoleUser', [UserController::class, 'getRoleUser'])->name('getRoleUser');
Route::get('/getReffStatusUser', [UserController::class, 'getReffStatusUser'])->name('getReffStatusUser');
Route::get('/getProvinsi', [UserController::class, 'getProvinsi'])->name('getProvinsi');
Route::get('/getKotaByProvinsi', [UserController::class, 'getKotaByProvinsi'])->name('getKotaByProvinsi');
Route::get('/getKecamatanByKota', [UserController::class, 'getKecamatanByKota'])->name('getKecamatanByKota');
Route::get('/getKelurahanByKecamatan', [UserController::class, 'getKelurahanByKecamatan'])->name('getKelurahanByKecamatan');
Route::get('/getSurveyorByKelurahan', [UserController::class, 'getSurveyorByKelurahan'])->name('getSurveyorByKelurahan');
Route::post('/addUserAction', [UserController::class, 'addUserAction'])->name('addUserAction');
Route::get('/showDetailUser/{id_user}', [UserController::class, 'showDetailUser'])->name('user.showDetailUser');
Route::get('/editUser/{id_user}', [UserController::class, 'editUser'])->name('user.editUser');
Route::post('/updateUserAction', [UserController::class, 'updateUserAction'])->name('updateUserAction');
Route::post('/updatePasswordAction', [UserController::class, 'updatePasswordAction'])->name('updatePasswordAction');
Route::get('/infoUser/{id_user}', [UserController::class, 'infoUser'])->name('user.infoUser');
Route::post('/deleteUserAction', [UserController::class, 'deleteUserAction'])->name('deleteUserAction');
Route::get('/profilUser/{id_user}', [UserController::class, 'profilUser'])->name('user.profilUser');

// route pertanyaan 
Route::resource('/pertanyaan', \App\Http\Controllers\PertanyaanController::class);
Route::get('get-pertanyaan', [PertanyaanController::class, 'getPertanyaan'])->name('pertanyaan.getPertanyaan');
Route::post('delete-pertanyaan', [PertanyaanController::class, 'deletePertanyaan'])->name('pertanyaan.deletePertanyaan');
Route::get('/addPertanyaan', [PertanyaanController::class, 'addPertanyaan'])->name('pertanyaan.addPertanyaan');
Route::get('/getReffJenisPertanyaan', [PertanyaanController::class, 'getReffJenisPertanyaan'])->name('getReffJenisPertanyaan');
Route::post('/addPertanyaanAction', [PertanyaanController::class, 'addPertanyaanAction'])->name('addPertanyaanAction');
Route::get('/addGroupPertanyaan', [PertanyaanController::class, 'addGroupPertanyaan'])->name('pertanyaan.addGroupPertanyaan');
Route::get('get-groupPertanyaan', [PertanyaanController::class, 'getGroupPertanyaan'])->name('pertanyaan.getGroupPertanyaan');
Route::post('/addGroupPertanyaanAction', [PertanyaanController::class, 'addGroupPertanyaanAction'])->name('addGroupPertanyaanAction');
Route::get('/getReffStatusPertanyaangroup', [PertanyaanController::class, 'getReffStatusPertanyaangroup'])->name('getReffStatusPertanyaangroup');
Route::get('/showDetailgroupPertanyaan/{id_group_pertanyaan}', [PertanyaanController::class, 'showDetailgroupPertanyaan'])->name('pertanyaan.showDetailgroupPertanyaan');
Route::post('/updateGroupPertanyaanAction', [PertanyaanController::class, 'updateGroupPertanyaanAction'])->name('updateGroupPertanyaanAction');
Route::post('/deleteGroupPertanyaanAction', [PertanyaanController::class, 'deleteGroupPertanyaanAction'])->name('deleteGroupPertanyaanAction');
Route::get('/editPertanyaan/{id_pertanyaan}', [PertanyaanController::class, 'editPertanyaan'])->name('pertanyaan.editPertanyaan');
Route::get('/showDetailPertanyaan/{id_pertanyaan}', [PertanyaanController::class, 'showDetailPertanyaan'])->name('pertanyaan.showDetailPertanyaan');
Route::get('/showPilihanPertanyaan/{id_pertanyaan}', [PertanyaanController::class, 'showPilihanPertanyaan'])->name('pertanyaan.showPilihanPertanyaan');
Route::post('/deletePilihanPertanyaanAction', [PertanyaanController::class, 'deletePilihanPertanyaanAction'])->name('deletePilihanPertanyaanAction');
Route::post('/addPilihanPertanyaanAction', [PertanyaanController::class, 'addPilihanPertanyaanAction'])->name('addPilihanPertanyaanAction');
Route::post('/editPertanyaanAction', [PertanyaanController::class, 'editPertanyaanAction'])->name('editPertanyaanAction');
Route::post('/deletePertanyaanAction', [PertanyaanController::class, 'deletePertanyaanAction'])->name('deletePertanyaanAction');
Route::get('/infoPertanyaan/{id_pertanyaan}', [PertanyaanController::class, 'infoPertanyaan'])->name('pertanyaan.infoPertanyaan');
Route::get('/getGroupPertanyaanOption', [PertanyaanController::class, 'getGroupPertanyaanOption'])->name('getGroupPertanyaanOption');


// route task 
Route::resource('/tasklist', \App\Http\Controllers\TaskController::class);
Route::get('getTask', [TaskController::class, 'getTask'])->name('task.getTask');
Route::get('/addTask', [TaskController::class, 'addTask'])->name('task.addTask');
Route::get('/getReffKegiatanTask', [TaskController::class, 'getReffKegiatanTask'])->name('getReffKegiatanTask');
Route::get('/getObjekTask', [TaskController::class, 'getObjekTask'])->name('getObjekTask');

Route::get('/getPertanyaanTask/{id_pertanyaan_group}', [TaskController::class, 'getPertanyaanTask'])->name('getPertanyaanTask');

Route::get('/getPilihanPertanyaanTask', [TaskController::class, 'getPilihanPertanyaanTask'])->name('getPilihanPertanyaanTask');
Route::post('/addTaskAction', [TaskController::class, 'addTaskAction'])->name('addTaskAction');
Route::post('/publishTaskAction', [TaskController::class, 'publishTaskAction'])->name('publishTaskAction');
Route::get('/infoTask/{id_task}', [TaskController::class, 'infoTask'])->name('task.infoTask');
Route::get('/editTask/{id_task}', [TaskController::class, 'editTask'])->name('task.editTask');
Route::get('/deleteTask', [TaskController::class, 'deleteTask'])->name('task.deleteTask');
Route::get('/showDetailTask/{id_task}', [TaskController::class, 'showDetailTask'])->name('task.showDetailTask');
Route::get('/detailTaskPertanyaan/{id_task}', [TaskController::class, 'detailTaskPertanyaan'])->name('task.detailTaskPertanyaan');
Route::post('/editTaskAction', [TaskController::class, 'editTaskAction'])->name('editTaskAction');
Route::get('/showDetailTaskPertanyaan/{id_task_pertanyaan}', [TaskController::class, 'showDetailTaskPertanyaan'])->name('task.showDetailTaskPertanyaan');
Route::post('/editTaskPertanyaanAction', [TaskController::class, 'editTaskPertanyaanAction'])->name('editTaskPertanyaanAction');
Route::post('/deleteTaskPertanyaanAction', [TaskController::class, 'deleteTaskPertanyaanAction'])->name('deleteTaskPertanyaanAction');
Route::post('/addTaskPertanyaanAction', [TaskController::class, 'addTaskPertanyaanAction'])->name('addTaskPertanyaanAction');
Route::post('/deleteTaskAction', [TaskController::class, 'deleteTaskAction'])->name('deleteTaskAction');

// route task jawaban 
Route::resource('/taskJawaban', \App\Http\Controllers\TaskJawabanController::class);
Route::get('getTaskJawaban', [TaskJawabanController::class, 'getTaskJawaban'])->name('taskjawaban.getTaskJawaban');
Route::get('/infoTaskJawaban/{id_task}', [TaskJawabanController::class, 'infoTaskJawaban'])->name('taskjawaban.infoTaskJawaban');
Route::get('/detailTaskJawaban/{id_task}', [TaskJawabanController::class, 'detailTaskJawaban'])->name('taskjawaban.detailTaskJawaban');
Route::get('/editTaskJawaban/{id_task}', [TaskJawabanController::class, 'editTaskJawaban'])->name('taskjawaban.editTaskJawaban');
Route::get('/showDetailTaskPertanyaanJawaban/{id_task_jawaban}', [TaskJawabanController::class, 'showDetailTaskPertanyaanJawaban'])->name('taskjawaban.showDetailTaskPertanyaanJawaban');
Route::get('/getPilihanPertanyaan/{id_pertanyaan}', [TaskJawabanController::class, 'getPilihanPertanyaan'])->name('getPilihanPertanyaan');
Route::post('/updateJawabanTaskAction', [TaskJawabanController::class, 'updateJawabanTaskAction'])->name('updateJawabanTaskAction');



// route wilayah provinsi 
Route::resource('/wilayah', \App\Http\Controllers\WilayahController::class);
Route::get('get-provinsi', [WilayahController::class, 'getProvinsi'])->name('wilayah.getProvinsi');
Route::post('info-provinsi', [WilayahController::class, 'infoProvinsi'])->name('wilayah.infoProvinsi');
Route::post('edit-provinsi', [WilayahController::class, 'editProvinsi'])->name('wilayah.editProvinsi');
Route::post('delete-provinsi', [WilayahController::class, 'deleteProvinsi'])->name('wilayah.deleteProvinsi');

Route::get('/getKabkota', [WilayahController::class, 'getKabkota'])->name('wilayah.getKabkota');
Route::get('/showKota/{provinsi_kode}', [WilayahController::class, 'showKota'])->name('wilayah.showKota');

Route::get('/getKecamatan', [WilayahController::class, 'getKecamatan'])->name('wilayah.getKecamatan');
Route::get('/showKecamatan/{kabkota_kode}', [WilayahController::class, 'showKecamatan'])->name('wilayah.showKecamatan');

Route::get('/getKelurahan', [WilayahController::class, 'getKelurahan'])->name('wilayah.getKelurahan');
Route::get('/showKelurahan/{kecamatan_kode}', [WilayahController::class, 'showKelurahan'])->name('wilayah.showKelurahan');


// route login 
Route::resource('/login', \App\Http\Controllers\LoginController::class);
Route::post('/loginAction', [LoginController::class, 'loginAction'])->name('loginAction');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
