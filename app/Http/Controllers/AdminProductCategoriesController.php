<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

class AdminProductCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $product_categories = ProductCategory::orderby('id','ASC')->paginate($perPage);
        $data = ['product_categories' => $product_categories];
        return view('admins.product_categories.index',$data);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 10);
        // 搜尋會員資料
        $product_categories = ProductCategory::where('name', 'like', "%$query%")
            ->paginate($perPage);

        // 返回結果
        return view('admins.product_categories.index', [
            'product_categories' => $product_categories,
            'query' => $query,
        ]);
    }

    public function create()
    {
        return view('admins.product_categories.create');
    }

//    public function store(Request $request)
//    {
////        $this->validate($request,[
////            'title' => 'required|max:50',
////            'content' => 'required',
////            'is_feature' => 'required|boolean',
////        ]);
//
//        Product::create($request->all());
//        return redirect()->route('admins.products.index');
//    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:25',
        ]);

        ProductCategory::create($request->all());
        return redirect()->route('admins.product_categories.index');
    }

    public function statusOn(Request $request, ProductCategory $product_category)
    {
        $product_category->update(['status' => 1]);
        return redirect()->route('admins.product_categories.index');
    }

    public function statusOff(Request $request, ProductCategory $product_category)
    {
        $product_category->update(['status' => 0]);
        return redirect()->route('admins.product_categories.index');
    }

    public function edit(ProductCategory $product_category)
    {
        //dd($product_category);
        $data = [
            'product_category'=> $product_category,
        ];
        return view('admins.product_categories.edit',$data);
    }

    public function update(Request $request, ProductCategory $product_category)
    {
        $this->validate($request, [
            'name' => 'required|max:25',
        ]);
        $product_category->update($request->all());
        return redirect()->route('admins.product_categories.index');
    }

    public function destroy(ProductCategory $product_category)
    {
        $product_category->delete();
        return redirect()->route('admins.product_categories.index');
    }
}
