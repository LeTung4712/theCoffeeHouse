<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
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

Route::group(['prefix'=> 'admin'],function(){


    //category api
    Route::post('category/create', [CategoryController::class, 'create']); // vd http://localhost:8000/api/admin/category/create?name=abc&parent_id=2
    Route::get('category/index', [CategoryController::class, 'index']); // http://localhost:8000/api/admin/category/index
    Route::post('category/update', [CategoryController::class, 'update']);//http://localhost:8000/api/admin/category/update?id=1&name=abc&parent_id=2
    Route::post('category/indexByParentId', [CategoryController::class, 'indexByParentId']);// http://localhost:8000/api/admin/category/indexByParentId?parent_id=1

});
