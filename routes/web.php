<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\AdminSideUserController;

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

//login Register

Route::middleware(['admin_auth'])->group(function (){
      Route::redirect('/', 'loginPage');
      Route::get('loginPage',[AuthController::class,'loginPage'])->name('auth@loginPage');
      Route::get('registerPage',[AuthController::class,'registerPage'])->name('auth@registerPage');
});

Route::middleware(['auth',config('jetstream.auth_session'),'verified'])->group(function () {
     //dashboard
     Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');

  //admin
    Route::middleware('admin_auth')->group(function (){

         //category
        Route::group(['prefix' => 'category'],function(){
          Route::get('list',[CategoryController::class,'list'])->name('category@list');
          Route::get('createPage',[CategoryController::class,'createPage'])->name('category@createPage');
          Route::post('create',[CategoryController::class,'create'])->name('category@create');
          Route::get('delete/{id}',[CategoryController::class,'delete'])->name('category@delete');
          Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category@edit');
          Route::post('update',[CategoryController::class,'update'])->name('category@update');
        });

        //admin account
        Route::prefix('admin')->group(function (){
          //changing password
          Route::get('password/changePasswordPage',[AdminController::class,'changePasswordPage'])->name ('admin@changePasswordPage');
          Route::post('password/changePassword',[AdminController::class,'changePassword'])->name('admin@changePassword');

          //account details
          Route::get('account/details',[AdminController::class,'details'])->name('admin@details');
          Route::get('editDetailsPage',[AdminController::class,'editDetailsPage'])->name('admin@editDetailsPage');
          Route::post('updateDetails/{id}',[AdminController::class,'updateDetails'])->name('admin@updateDetails');

          //account lists
          Route::get('listPage',[AdminController::class,'listPage'])->name('admin@listPage');
          Route::get('delete/{id}',[AdminController::class,'delete'])->name('admin@delete');
        //   Route::get('changeRolePage/{id}',[AdminController::class,'changeRolePage'])->name('admin@changeRolePage');
          Route::get('ajax/changeRole',[AjaxController::class,'changeRole'])->name('admin@ajaxChangeRole');
        //   Route::post('changeRole/{id}',[AdminController::class,'changeRole'])->name('admin@changeRole');

          //products
          Route::prefix('products')->group(function (){

            Route::get('list',[ProductController::class, 'list'])->name('products@list');
            Route::get('createPage',[ProductController::class,'createPage'])->name('products@createPage');
            Route::post('create',[ProductController::class,'create'])->name('products@create');
            Route::get('delete/{id}',[ProductController::class,'delete'])->name('products@delete');
            Route::get('details/{id}',[ProductController::class,'details'])->name('products@details');
            Route::get('editPage/{id}',[ProductController::class,'editPage'])->name('products@editPage');
            Route::post('edit/{id}',[ProductController::class,'edit'])->name('products@edit');
          });

         //order
         Route::prefix('order')->group(function (){
           Route::get('list',[OrderController::class,'list'])->name('order@list');
           Route::get('sort/status',[OrderController::class,'sortWithStatus'])->name('order@SortWithStatus');
           Route::get('listInfo/{orderCode}',[OrderController::class,'listInfo'])->name('order@listInfo');
           //ajax
           Route::prefix('ajax')->group(function (){
           Route::get('change/status',[OrderController::class,'changeStatus'])->name('order@ajaxChangeStatus');
           });
         });

         //user List
         Route::prefix('user')->group(function (){
            Route::get('list',[AdminSideUserController::class,'list'])->name('admin@userList');
            Route::get('ajax/change/role',[AdminSideUserController::class,'changeRole'])->name('admin@ajaxChangeRole');
            Route::get('deleteUser/{id}',[AdminSideUserController::class,'deleteUser'])->name('admin@deleteUser');
         });

         //message form user
         Route::get('messageListPage',[ContactController::class,'messageListPage'])->name('admin@messageListPage');
         Route::get('ajax/message',[ContactController::class,'ajaxMessage'])->name('admin@ajaxMessage');
         Route::get('message/detail/{message_code}',[ContactController::class,'messageDetail'])->name('admin@messageDetail');
         Route::get('message/delete/{id}',[ContactController::class,'messageDelete'])->name('admin@messageDelete');
        });
    });



 //user
    Route::group(['prefix'=> 'user','middleware' => 'user_auth'],function(){

      Route::get('/homePage',[UserController::class,'home'])->name('user@home');
      Route::get('/filter/{categoryId}',[UserController::class,'filter'])->name('user@filter');
      Route::get('/history',[UserController::class,'history'])->name('user@history');

      //pizza
      Route::prefix('pizza')->group(function (){
         Route::get('/details/{pizzaId}',[UserController::class,'pizzaDetails'])->name('user@pizzaDetails');
      });

      //cart
      Route::prefix('cart')->group(function (){
         Route::get('list',[UserController::class,'cartList'])->name('user@cartList');
      });

      //account
      Route::prefix('account')->group(function (){
        Route::get('change',[UserController::class,'changePasswordPage'])->name('user@changePasswordPage');
        Route::post('change',[UserController::class,'changePassword'])->name('user@changePassword');
        Route::get('profile',[UserController::class,'changeProfilePage'])->name('user@changeProfilePage');
        Route::post('changeProfile/{id}',[UserController::class,'changeProfile'])->name('user@changeProfile');

      });

      //contact
      Route::get('contact',[UserController::class,'contactPage'])->name('user@contactPage');
      Route::post('contact',[UserController::class,'contactData'])->name('user@contactData');

      //ajax
      Route::prefix('ajax')->group(function (){
        Route::get('pizza/list',[AjaxController::class,'pizzaList'])->name('ajax@pizzaList');
        Route::get('addToCart',[AjaxController::class,'addToCart'])->name('ajax@addToCart');
        Route::get('order',[AjaxController::class,'order'])->name('ajax@order');
        Route::get('clear/cart',[AjaxController::class,'clearCart'])->name('ajax@clearCart');
        Route::get('clear/row',[AjaxController::class,'clearRow'])->name('ajax@clearRow');
        Route::get('viewCount/increase',[AjaxController::class,'increaseViewCount'])->name('ajax@increaseViewCount');
      });

    });

});

