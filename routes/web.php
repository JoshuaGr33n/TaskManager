<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;


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

Route::get('test', function () {
    return view('test');
});




//route to register
Route::get('/', [AppController::class, 'index']);
Route::get('/register', [AppController::class, 'register']);
Route::post('/register', [AppController::class, 'store']);

// route to login
Route::post('login', [AppController::class, 'login']);

//route to pages
Route::get('logout', [AppController::class, 'logout']);
Route::get('user', [AppController::class, 'user_page']);
Route::get('admin', [AppController::class, 'admin_page']);
//for Laravel
Route::get('admin/users', [AppController::class, 'allUsers']);
//for VUE
Route::get('users', [AppController::class, 'getUsers']);
Route::get('admin/inbox', [AppController::class, 'admin_inbox']);
Route::get('admin/outbox', [AppController::class, 'admin_outbox']);
Route::get('user/inbox', [AppController::class, 'user_inbox']);
Route::get('user/outbox', [AppController::class, 'user_outbox']);
Route::get('admin/outbox/{id}', [AppController::class, 'admin_view_outbox_message']);
Route::get('admin/inbox/{id}', [AppController::class, 'admin_view_inbox_message']);
Route::get('user/outbox/{id}', [AppController::class, 'user_view_outbox_message']);
Route::get('user/inbox/{id}', [AppController::class, 'user_view_inbox_message']);
Route::put('update_message_status/{id}', [AppController::class, 'update_message_status']);
Route::delete('deleteMessage/{id}', [AppController::class, 'deleteMessage']);
Route::post('send_message', [AppController::class, 'send_message']);
Route::put('update_user_status/{id}', [AppController::class, 'update_user_status']);
Route::delete('deleteUser/{id}', [AppController::class, 'deleteUser']);
Route::get('admin/task-categories', [AppController::class, 'task_categories']);
Route::post('create_category', [AppController::class, 'create_category']);
Route::put('update_category_status/{id}', [AppController::class, 'update_category_status']);
Route::delete('deleteCategory/{id}', [AppController::class, 'deleteCategory']);
Route::get('user/tasks', [AppController::class, 'tasks']);
//for VUE
Route::get('categories', [AppController::class, 'getCategories']);
Route::get('getUserTasks', [AppController::class, 'getUserTasks']);
Route::post('create_task', [AppController::class, 'create_task']);
Route::post('update_task', [AppController::class, 'update_task']);
Route::delete('deleteTask/{id}', [AppController::class, 'deleteTask']);
Route::get('admin/tasks', [AppController::class, 'admin_tasks_view']);

