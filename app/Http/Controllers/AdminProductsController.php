<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AdminProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderby('id','ASC')->get();
        $data = ['products' => $products];
        return view('admins.products.index',$data);
    }

    public function create()
    {
        return view('admins.products.create');
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
        // 驗證請求...

        $product = new Product;

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            // 存儲原始圖片
            Storage::disk('products')->put($imageName, file_get_contents($image));

            // 製作縮略圖
            $thumbnailPath = 'thumbnails/'.$imageName;
            $thumbnail = Image::make($image)->resize(100, 100);
            Storage::disk('products')->put($thumbnailPath, $thumbnail->stream());

            $product->image_url = $imageName;
        }

        // 其他保存商品資訊的邏輯...
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->content = $request->content;

        $product->save();

        return redirect()->route('admins.products.index');
    }

    public function edit(Product $product)
    {
        $data = [
            'product'=> $product,
        ];
        return view('admins.products.edit',$data);
    }

    public function update(Request $request, Product $product)
    {
//        $this->validate($request,[
//            'title' => 'required|max:50',
//            'content' => 'required',
//            'is_feature' => 'required|boolean',
//        ]);

        $product->update($request->all());
        return redirect()->route('admins.products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admins.products.index');
    }
}
