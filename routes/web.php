<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Auth;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/',[App\Http\Controllers\TemplateController::class, 'index'])->name('home');
Route::get('/about',[App\Http\Controllers\TemplateController::class, 'about'])->name('about');
Route::get('/contact',[App\Http\Controllers\TemplateController::class, 'contact'])->name('contact');
Route::get('/login',[App\Http\Controllers\AdminTemplateController::class, 'login'])->name('login');
Route::get('/register',[App\Http\Controllers\AdminTemplateController::class, 'register'])->name('register');
Route::get('/password',[App\Http\Controllers\AdminTemplateController::class, 'password'])->name('password');
Route::get('/errors',[App\Http\Controllers\AdminTemplateController::class, 'error'])->name('errors');
Route::get('/charts',[App\Http\Controllers\AdminTemplateController::class, 'chart'])->name('charts');
Route::get('/tables',[App\Http\Controllers\AdminTemplateController::class, 'table'])->name('tables');


Route::get('/layoutstat', [App\Http\Controllers\AdminTemplateController::class, 'layoutstat'])->name('layoutstat');
Route::get('/layoutsidenavs', [App\Http\Controllers\AdminTemplateController::class, 'layoutsidenav'])->name('layoutsidenavs');
Route::get('/login', [App\Http\Controllers\AdminTemplateController::class, 'login'])->name('login');
Route::get('/register', [App\Http\Controllers\AdminTemplateController::class, 'register'])->name('register');
Route::get('/password', [App\Http\Controllers\AdminTemplateController::class, 'password'])->name('password');
Route::get('/errors', [App\Http\Controllers\AdminTemplateController::class, 'error'])->name('errors');
Route::get('/charts', [App\Http\Controllers\AdminTemplateController::class, 'chart'])->name('charts');
Route::get('/tables', [App\Http\Controllers\AdminTemplateController::class, 'table'])->name('tables');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(['middleware' => ['auth']], function () {

    //only able to access if user login
    Route::get('/', [App\Http\Controllers\AdminTemplateController::class, 'index'])->name('index');
    // Users CRUD
    Route::resource('users', UserController::class);

    // Permissions CRUD->for admin
    Route::resource('permissions', PermissionController::class);

    // Roles CRUD->for admin
    Route::resource('roles', RoleController::class);
});
