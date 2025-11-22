<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;

Route::get('/', function () {
    return view('index');
});

//Route:: view('/','index');

// お問い合わせフォーム
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'sendMail']);
Route::get('/contact/complete', [ContactController::class, 'complete'])->name('contact.complete');

//　管理画面
Route::prefix('/admin')
    ->name('admin.')
    ->group(function (){
        //ログイン時のみアクセス可能なルート
        Route::middleware('auth')->group(function (){

//ブログ
Route::resource('/blogs', AdminBlogController::class)->except(['show']);
// Route::get('/blogs', [AdminBlogController::class, 'index'])->name('blogs.index');
// Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('blogs.create');
// Route::post('/blogs', [AdminBlogController::class, 'store'])->name('blogs.store');
// Route::get('/blogs/{blog}', [AdminBlogController::class, 'edit'])->name('blogs.edit');
// Route::put('/blogs/{blog}', [AdminBlogController::class, 'update'])->name('blogs.update');
// Route::delete('/blogs/{blog}', [AdminBlogController::class, 'destroy'])->name('blogs.destroy');

//　ユーザ管理
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// ログアウト
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    });
    Route::middleware('guest')->group(function (){
        //　認証
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });
        });
// Route::get('/admin/blogs', [App\Http\Controllers\Admin\AdminBlogController::class, 'index'])->name('admin.blogs.index');
// Route::get('/admin/blogs/create', [App\Http\Controllers\Admin\AdminBlogController::class, 'create'])->name('admin.blogs.create');
// Route::post('/admin/blogs', [App\Http\Controllers\Admin\AdminBlogController::class, 'store'])->name('admin.blogs.store');
// //Route::post('/admin/blogs', [App\Http\Controllers\Admin\AdminBlogController::class, 'store'])->name('admin.blogs.store');
// //Route::get('/admin/blogs/{blog}', [App\Http\Controllers\Admin\AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
// //Route::post('/admin/blogs/{blog}', [App\Http\Controllers\Admin\AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
// Route::get('/admin/blogs/{blog}/edit', [App\Http\Controllers\Admin\AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
// Route::put('/admin/blogs/{blog}', [App\Http\Controllers\Admin\AdminBlogController::class, 'update'])->name('admin.blogs.update');
// Route::delete('/admin/blogs/{blog}', [App\Http\Controllers\Admin\AdminBlogController::class, 'destroy'])->name('admin.blogs.destroy');

