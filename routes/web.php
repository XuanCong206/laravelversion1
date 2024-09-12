<?php

use App\Http\Controllers\Backend\AuthController; // muốn dùng class này thì phải Use
use App\Http\Controllers\Backend\DashboardController; // muốn dùng class này thì phải Use
use App\Http\Controllers\Backend\UserController; // muốn dùng class này thì phải Use
use App\Http\Controllers\Ajax\LocationController; // muốn dùng class này thì phải Use

// Quản lí đơn hàng
use App\Http\Controllers\Backend\OrderController; // muốn dùng class này thì phải Use

// Quản lý sản phẩm 
use App\Http\Controllers\Backend\ProductController; // muốn dùng class này thì phải Use


use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\LoginMiddleware;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Backend Routes
Route::get('dashboard/index',[DashboardController::class,'index'])->name('dashboard.index')->middleware(AuthenticateMiddleware::class);


//----------------------//
// User 
//- tối thiểu là có 4 phương thức get .
// Dùng group trong group để ngắn lại
// Route::get('user/index',[UserController::class,'index'])->name('user.index')->middleware(AuthenticateMiddleware::class);
// Route::get('user/create',[UserController::class,'create'])->name('user.create')->middleware(AuthenticateMiddleware::class);
// Route::get('user/update',[UserController::class,'update'])->name('user.update')->middleware(AuthenticateMiddleware::class);
// Route::get('user/destroy',[UserController::class,'destroy'])->name('user.destroy')->middleware(AuthenticateMiddleware::class);
// Viết lại để ngắn gọn 

Route::group(['prefix'=>'user'] , function(){
    Route::get('index',[UserController::class,'index']) ->name('user.index')
    ->middleware(AuthenticateMiddleware::class);

    Route::get('create',[UserController::class,'create']) ->name('user.create')
    ->middleware(AuthenticateMiddleware::class);

    Route::post('store',[UserController::class,'store']) ->name('user.store')
    ->middleware(AuthenticateMiddleware::class);

    Route::get('{id}/edit',[UserController::class,'edit'])->where(['id'=>'[0-9]+']) ->name('user.edit')
    ->middleware(AuthenticateMiddleware::class);

    Route::post('{id}/update',[UserController::class,'update'])->where(['id'=>'[0-9]+']) ->name('user.update')
    ->middleware(AuthenticateMiddleware::class);

    Route::get('{id}/delete',[UserController::class,'delete'])->where(['id'=>'[0-9]+']) ->name('user.delete')
    ->middleware(AuthenticateMiddleware::class);

    Route::delete('{id}/destroy',[UserController::class,'destroy'])->where(['id'=>'[0-9]+']) ->name('user.destroy')
    ->middleware(AuthenticateMiddleware::class);
});

//----------------------//

// Quản lý sản phẩm
Route::prefix('product')->group(function(){

    // Danh sách sản phẩm.
    Route::get('/index',[ProductController::class,'index'])->name('product.index');

    // Hiển thị form add dữ liệu (Áp dụng show form sửa chuyên mục)
    Route::get('/create',[ProductController::class,'create'])->name('product.create');

    // Xử lý thêm chuyên mục (Áp dụng show form sửa chuyên mục)
    Route::post('/store',[ProductController::class,'store'])->name('product.store');

    // Lấy chi tiết 1 chuyên mục (Áp dụng show form sửa chuyên mục)
    Route::get('/{id}/edit',[ProductController::class,'edit'])->where(['id'=>'[0-9]+'])->name('product.edit');

    // Cập nhật 1 chuyên mục (Áp dụng show form sửa chuyên mục)
    Route::post('/{id}/update',[ProductController::class,'update'])->where(['id'=>'[0-9]+'])->name('product.update');

      
    // xóa chuyên mục.
    Route::get('/{id}/delete',[ProductController::class,'delete'])->where(['id'=>'[0-9]+'])->name('product.delete');

    Route::delete('/{id}/destroy',[ProductController::class,'destroy'])->where(['id'=>'[0-9]+'])->name('product.destroy');


    // Chi tiết sản phẩm
    Route::get('/{slug}', [ProductController::class, 'show'])->name('product.show');



});

//----------------------//


// AJAX 
Route::get('ajax/location/getLocation',[LocationController::class,'getLocation'])->name('ajax.location.index');


// Quản lí đơn hàng
// Route::get('user/order',[OrderController::class,'order'])->name('user.order');
Route::group(['prefix'=>'user'] , function(){
    Route::get('order',[OrderController::class,'order']) ->name('user.order')
    ->middleware(AuthenticateMiddleware::class);

    Route::get('order/create',[OrderController::class,'create']) ->name('order.create')
    ->middleware(AuthenticateMiddleware::class);

    Route::post('order/store',[OrderController::class,'store']) ->name('order.store')
    ->middleware(AuthenticateMiddleware::class);

    // Route::get('order/{id}/edit',[OrderController::class,'edit'])->where(['id'=>'[0-9]+']) ->name('order.edit')
    // ->middleware(AuthenticateMiddleware::class);

    // Route::post('{id}/update',[UserController::class,'update'])->where(['id'=>'[0-9]+']) ->name('user.update')
    // ->middleware(AuthenticateMiddleware::class);

    // Route::get('{id}/delete',[UserController::class,'delete'])->where(['id'=>'[0-9]+']) ->name('user.delete')
    // ->middleware(AuthenticateMiddleware::class);

    // Route::delete('{id}/destroy',[UserController::class,'destroy'])->where(['id'=>'[0-9]+']) ->name('user.destroy')
    // ->middleware(AuthenticateMiddleware::class);

});

// Route::get('/api/users/{id}', [App\Http\Controllers\Backend\OrderController::class, 'getUserInfo']);




// post : truyền dữ liệu . thì lúc mà dùng action thì phải là post
// -> name ('...') : đặt tên để sử dụng ở nơi khác
Route::get('admin',[AuthController::class,'index'])->name('auth.admin')->middleware(LoginMiddleware::class);
Route::get('logout',[AuthController::class,'logout'])->name('auth.logout');
Route::post('login',[AuthController::class,'login'])->name('auth.login');



