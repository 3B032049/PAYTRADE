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
        $this->validate($request, [
            'name' => 'required|max:25',
            'content' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product;

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            // 存儲原始圖片
            Storage::disk('products')->put($imageName, file_get_contents($image));

            $product->image_url = $imageName;
        }

        // 其他保存商品資訊的邏輯...
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->content =  $request->input('content');

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

    public function review(Product $product)
    {
        $data = [
            'product'=> $product,
        ];
        return view('admins.products.review',$data);
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required|max:25',
            'content' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            // Delete the old image from storage
            if ($product->image_url) {
                Storage::disk('products')->delete($product->image_url);
            }


            // Upload the new image
            $image = $request->file('image_url');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            // Log the image file name

            Storage::disk('products')->put($imageName, file_get_contents($image));

            // Set the new image URL in the Product instance
            $product->image_url = $imageName;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->content = $request->input('content');

        $product->save();

        return redirect()->route('admins.products.index');
    }

    public function pass(Request $request, Product $product)
    {
        $product->update(['status' => 1]);
        return redirect()->route('admins.products.index');
    }

    public function unpass(Request $request, Product $product)
    {
        $product->update(['status' => 2]);
        return redirect()->route('admins.products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admins.products.index');
    }
}
