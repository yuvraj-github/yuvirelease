<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Middleware\LoginCheck;
use App\Http\Middleware\CheckUser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['checkUser'])->group(function () {
    Route::get('login', [CustomAuthController::class, 'index'])->name('login');
    Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
    Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
    Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
});

Route::middleware(['loginCheck'])->group(function () {
    Route::view('/', 'home');
    Route::get('/viewProjects', [ProjectController::class, 'index']);
    Route::post('/project/save', [ProjectController::class, 'save']);
    Route::get('/project/edit/{id}', [ProjectController::class, 'edit']);
    Route::get('/project/getProjectForm/', [ProjectController::class, 'getProjectForm']);
    Route::get('/project/deleteProject', [ProjectController::class, 'deleteProject']);
    Route::get('/note/add', [NoteController::class, 'addNote']);
    Route::post('/note/save', [NoteController::class, 'saveNote']);
    Route::get('/note', [NoteController::class, 'index']);
    Route::get('/note/edit/{id?}', [NoteController::class, 'edit']);
    Route::get('/note/delete', [NoteController::class, 'deleteNote']);
    Route::get('dashboard', [CustomAuthController::class, 'dashboard']);
    Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
});
