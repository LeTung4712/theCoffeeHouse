<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'admin'], function () {

    //category api
    Route::post('category/create', [CategoryController::class, 'create']); // vd http://localhost:8000/api/admin/category/create?name=abc&parent_id=2&image_url=abc
    Route::get('category/index', [CategoryController::class, 'index']); // http://localhost:8000/api/admin/category/index
    Route::post('category/update', [CategoryController::class, 'update']); //http://localhost:8000/api/admin/category/update?id=1&name=abc&parent_id=2
    Route::post('category/indexByParentId', [CategoryController::class, 'indexByParentId']); // http://localhost:8000/api/admin/category/indexByParentId?parent_id=1
    //product api
    Route::get('product/index', [ProductController::class, 'index']); // http://localhost:8000/api/admin/product/index
    Route::post('product/create', [ProductController::class, 'create']); // http://localhost:8000/api/admin/product/create?name=abc&category_id=1&price=10000&description=abc&image_url=abc&active=1&price_sale=10000
    Route::post('product/update', [ProductController::class, 'update']); // http://localhost:8000/api/admin/product/update?id=1&name=abc&category_id=1&price=10000&description=abc&image_url=abc&active=1&price_sale=10000
    Route::post('product/getProductInfo', [ProductController::class, 'getProductInfo']); // http://localhost:8000/api/admin/product/getProductInfo?id=1
    Route::post('product/destroy', [ProductController::class, 'destroy']); // http://localhost:8000/api/admin/product/destroy?id=1
    Route::post('product/indexByCategoryId', [ProductController::class, 'indexByCategoryId']); // http://localhost:8000/api/admin/product/indexByCategoryId?category_id=1
    
});
