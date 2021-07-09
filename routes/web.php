<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/index', 'App\Http\Controllers\PageController@getIndex');

// user //
Route::get('/signup', [PageController::class, 'getSignup'])->name('getSignup');
Route::post('/signup', [PageController::class, 'postSignup'])->name('postSignup');

Route::get('/login', [PageController::class, 'getLogin'])->name('getLogin');
Route::post('/login', [PageController::class, 'postLogin'])->name('postLogin');

//admin
// Route::get('/admin/login',[UserController::class,'getLoginAd'])->name('admin.getLogin');
// Route::post('/admin/login',[UserController::class,'postLoginAd'])->name('admin.postLogin');
// Route::get('/admin/dangxuat',[UserController::class,'getLogoutAd']);

//shopping-cart
Route::get('/add-to-cart/{id}',[PageController::class,'addToCart'])->name('banhang.addtocart');
Route::get('/add-many-to-cart/{id}',[PageController::class,'addManyToCart'])->name('banhang.addmanytocart');
Route::get('/del-cart/{id}',[PageController::class,'delCartItem'])->name('banhang.xoagiohang');



/*------ phần quản trị ----------*/
// Route::get('/admin/dangnhap',[UserController::class,'getLogin'])->name('admin.getLogin');
// Route::post('/admin/dangnhap',[UserController::class,'postLogin'])->name('admin.postLogin');
// Route::get('/admin/dangxuat',[UserController::class,'getLogout']);

// Route::group(['prefix'=>'admin','middleware'=>'adminLogin'],function(){
	
// 		Route::group(['prefix'=>'category'],function(){
			// admin/category/danhsach
		// 	Route::get('danhsach',[CategoryController::class,'getCateList'])->name('admin.getCateList');
		// 	Route::get('them',[CategoryController::class,'getCateAdd'])->name('admin.getCateAdd');
		// 	Route::post('them',[CategoryController::class,'postCateAdd'])->name('admin.postCateAdd');
		// 	Route::get('xoa/{id}',[CategoryController::class,'getCateDelete'])->name('admin.getCateDelete');
		// 	Route::get('sua/{id}',[CategoryController::class,'getCateEdit'])->name('admin.getCateEdit');
		// 	Route::post('sua/{id}',[CategoryController::class,'postCateEdit'])->name('admin.postCateEdit');

		// });

		// //viết tiếp các route khác cho crud products, users,.... thì viết tiếp

// });