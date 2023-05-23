<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ToppingProduct;
use App\Models\Topping;


class ToppingController extends Controller
{
    //lay danh sach topping
    public function index(){
        $toppings = Topping::orderby('id')->get();
        return response ([
            'Toppings' => $toppings,
        ], 200);
    }
    //them topping
    public function create(Request $request){
        $topping=Topping::create([ 
            'name' => (string)$request->input('name'),
            'price' => (int)$request->input('price')
        ]);
        return response([
            'message' => 'Thêm topping thành công',
            'topping'=> $topping,
        ], 200);
    }
    //cap nhat topping
    public function update(Request $request){
        $topping=Topping::find($request->id);
        $topping->name = (string)$request->input('name');
        $topping->price = (int)$request->input('price');
        $topping->save();
        return response([
            'message' => 'Cập nhật thành công',
            'topping' => $topping,
        ], 200);
    }
    //xoa topping
    public function delete(Request $request){
        $topping=Topping::find($request->id);
        $topping->delete();
        return response([
            'message' => 'Xóa thành công',
            'topping' => $topping,
        ], 200);
    }
}
