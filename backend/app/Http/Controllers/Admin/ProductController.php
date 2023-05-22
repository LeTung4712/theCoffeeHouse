<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    //lay danh sach san pham
    public function index()
    {
        $productList = Product::where('active', 1)
                            ->orderby('id')
                            ->get(); 
        return response([
            'products' => $productList,
        ]);
    }
}
