<?php

use App\Mail\MyTestMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;

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

Route::get('/test', function () {
    $user = User::find(43);
    $user->assignRole('admin');
    
    // $user = User::create($input);
    // $user->assignRole($request->input('roles'));
    

});
Route::resource('/tasks', TaskController::class)->middleware('isLoggedIn');

Route::get('/', function () {
    if (Auth::check()) {
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