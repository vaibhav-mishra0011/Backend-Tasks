<?php

use App\Mail\MyTestMail;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

// Route::get('/test', function () {
//     $role = Role::create(['name' => 'user']);
//     $permission = Permission::create(['name' => 'delete tasks']);
//     $permission = Permission::create(['name' => 'edit tasks']);
//     $permission = Permission::create(['name' => 'add tasks']);
//     $permission = Permission::create(['name' => 'fetch tasks']);
//     return view("welcome");
// });

Route::resource('/tasks', TaskController::class)->middleware('isLoggedIn');

Route::get('/', function () {
    if(Auth::check()) {
        return redirect('tasks');
    } else {
        return redirect('login');
    }
});
Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [RegisterController::class, 'register'])->name('register')->middleware('alreadyLoggedIn');
// Route::get('/login', [LoginController::class,'index'])->name('login')->middleware('alreadyLoggedIn');
Route::get('/register', [RegisterController::class, 'index'])->middleware('alreadyLoggedIn');
Route::get('/', [RegisterController::class, 'index'])->middleware('alreadyLoggedIn');
// Route::post('login', [LoginController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

// Route::get('/logout', function () {
//     Auth::logout();
//     return view('users.login');
// });


// get - index
// post - update
// put - store
// delete - destroy