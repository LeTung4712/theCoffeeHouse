<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


// thư viện để sử dụng session

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
    //them san pham
    public function create(Request $request)
    {
        if (Product::where('name', $request->name)->first()) {
            return response([
                'message' => 'Đã có sản phẩm này',
            ]);
        }
        $product = Product::create([ // create() là hàm tạo mới 1 bản ghi trong database thuộc lop
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'price_sale' => $request->price_sale,
            'active' => 1,
            'image_url' => $request->image_url,
        ]);

        return response([
            'message' => "Thêm sản phẩm thành công",
            'product' => $product,
        ], 200);
    }
    //lay danh sach danh muc con theo danh muc cha
    public function getChild($parent)
    {
        $childList = Category::select('id')  //chọn cột id
            ->where('parent_id', $parent->id) //có điều kiện là cột parent_id = id của parent
            ->orderby('id')
            ->get();
        return $childList;
    }
    //lay danh sach san pham theo danh muc
    //ý tưởng : lấy danh sách danh mục con của danh mục request đến, 
    //sau đó lấy danh sách sản phẩm của tất cả danh mục con đó
    public function indexByCategoryId(Request $request)
    {
        $categoryList = collect(); 
        $childList = collect();
        $productList = collect();

        $categoryList = Category::select('id')
            ->where('id', $request->category_id)
            ->get();
        for ($i = 0; $i < $categoryList->count(); $i++) {
            $childList = $this->getChild($categoryList[$i]);
            foreach ($childList as $child) {
                if (!($categoryList->contains($child)))//contains() kiểm tra xem mảng có chứa phần tử đó chưa,phương thức này thuọc class
                    $categoryList->push($child); //push vào cuối mảng categoryList
            }
        }
        foreach ($categoryList as $category) {
            $product_list = Product::where('category_id', $category->id)
                ->where('active', 1)
                ->orderby('id')
                ->get();
            foreach ($product_list as $product) {
                $productList->push($product);
            }
        }
        return response([
            'products' => $productList,
        ]);
    }
    //lay thong tin chi tiet san pham
    public function getProductInfo(Request $request)
    {
        $productInfo = Product::select(
            'id',
            'name',
            'category_id',
            'description',
            'price_sale',
            'image_url'
        )
            ->where('id', $request->id) // where() là hàm lọc dữ liệu theo điều kiện
            ->where('active', 1)
            ->first(); // first() là hàm lấy ra bản ghi đầu tiên thỏa mãn điều kiện

        return response([
            'message' => 'Lấy thông tin sản phẩm thành công',
            'product' => $productInfo,

        ], 200);
    }
    //cap nhat san pham
    public function update(Request $request)
    {
        $product = Product::where('id', $request->input('id'))->first();
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice === false) {
            return false;
        }

        try {
            $product->fill($request->input());
            $product->save();
            return response([
                'message' => 'Cập nhật thành công',
                'product' => $product,
            ], 200);
        } catch (\Exception $err) {
            return response([
                'message' => 'Cập nhật thất bại',
                'error' => $err->getMessage(),
            ], 500);
        }
    }
    //check xem gia giam co nho hon gia goc hay khong
    protected function isValidPrice($request)
    {
        if (
            $request->input('price') != 0 && $request->input('price_sale') != 0
            && $request->input('price_sale') > $request->input('price')
        ) {
            Session::flash('error', 'Giá giảm phải nhỏ hơn giá gốc');
            return false;
        }

        if ($request->input('price_sale') != 0 && (int) $request->input('price') == 0) {
            Session::flash('error', 'Vui lòng nhập giá gốc');
            return false;
        }

        return true;
    }
    //xóa sản phẩm
    public function destroy(Request $request)
    {
        $product = Product::where('id', $request->input('id'))->first();
        if ($product) {
            $product->delete();
            return response()->json([
                'message' => 'Xóa thành công sản phẩm'
            ], 200);
        } else return response([
            'message' => 'Không có sản phẩm này trong dữ liệu'
        ], 500);
    }

}
