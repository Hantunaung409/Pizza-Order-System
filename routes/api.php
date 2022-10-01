<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//Get
Route::get('product/list',[RouteController::class,'productList']); //Read *
Route::get('category/list',[RouteController::class,'categoryList']);  //Read *
Route::get('category/list/{id}',[RouteController::class,'categoryListUsingId']); //Read
Route::get('delete/contact/{id}',[RouteController::class,'deleteContactUsingGet']);  //Delete


//POST
Route::post('create/category',[RouteController::class,'createCategory']); //create
Route::post('create/contact',[RouteController::class,'createContact']);  //create
Route::post('delete/contact',[RouteController::class,'deleteContact']);  //delete
Route::post('category/details',[RouteController::class,'categoryDetails']);  // Read
Route::post('update/category',[RouteController::class,'updateCategory']); // update


/**
 * product list api
 * http://127.0.0.1:8000/api/product/list (GET)
 *
 * category list
 * http://127.0.0.1:8000/api/category/list (GET)
 * http://127.0.0.1:8000/api/category/list/{id} (GET)
 * http://127.0.0.1:8000/api/category/details (POST)
 * Key => id
 *
 *
 * category create
 *  http://127.0.0.1:8000/api/create/category (POST)
 *  body{
 *    name : ""
 *  }
 *
 * create contact
 * http://127.0.0.1:8000/api/create/contact (POST)
 * Key
 * ===
 * name => name
 * email => email
 * message => message
 *
 * delete contact
 * http://127.0.0.1:8000/api/delete/contact (POST)
 * key=>id
 * http://127.0.0.1:8000/api/delete/contact/{id} (GET)
 *
 *

 * update category
 *http://127.0.0.1:8000/api/update/category (POST)
 *Key => id,name
 *
 */

