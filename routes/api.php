<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class,'register']);
// Route::post('/create', [TaskController::class,'store']);
// Route::get('/tasks', [TaskController::class,'index']);
// Route::get('/user/{id}/tasks', [TaskController::class,'getUserTasks']);
// Route::delete('/task/{id}', [TaskController::class,'destroy']);
// Route::patch('/task/{id}', [TaskController::class,'updateTask']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});




Route::group(['middleware' => ['auth:sanctum']], function(){
    // all routes that require authentication inside this group
    Route::post('/create', [TaskController::class, 'store']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/user/{id}/tasks', [TaskController::class, 'getUserTasks']);
    Route::delete('/task/{id}', [TaskController::class, 'destroy']);
    Route::patch('/task/{id}', [TaskController::class, 'updateTask']);
});

// Routes outside the group (do not require authentication)

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/user', [AuthController::class, 'me']);
