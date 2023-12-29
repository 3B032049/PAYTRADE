<?php

namespace App\Http\Controllers;

use App\Models\Product;

use App\Models\Seller;
use App\Models\ProductCategory;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderby('id','ASC')->get();
        $data = ['products' => $products];
        return view('sellers.products.index',$data);
    }
    public function shopindex($seller_id)
    {
//        dd($product, $seller_id);
        $products = Product::where('seller_id', $seller_id)->orderby('id','ASC')->get();
        $seller = Seller::where('id', $seller_id)->first();
        $data = ['products' => $products , 'seller' => $seller];

        return view('shop',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sellers.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
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
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->content =  $request->input('content');

        $product->save();

        return redirect()->route('sellers.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($product)
    {
        //
        if (Auth::check())
        {
            $user = Auth::user();
            $cartItems = $user->CartItems;

            $product = Product::where('id',$product)->first();
            $data = [
                'cartItems' => $cartItems,
                'product' => $product,
            ];
            return view('products.show', $data);
        }
        else
        {
            $product = Product::where('id',$product)->first();
            $data = [
                'product' => $product,

            ];
            return view('products.show', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $data = [
            'product'=> $product,
        ];
        return view('sellers.products.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
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

        return redirect()->route('sellers.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('sellers.products.index');
    }


    public function search(Request $request)
    {
        $query = $request->input('query');

        // 搜尋商品
        $products = Product::where('name', 'like', "%$query%")
            ->where('status','=',3)
            ->get();

//        // 搜尋賣家
//        $sellers = Seller::where('name', 'like', "%$query%")->get();

        // 返回結果
        return view('products.search', [
            'products' => $products,
//            'sellers' => $sellers,
            'query' => $query,
        ]);
    }

    public function by_category(Request $request,$category_id)
    {
        $category_selected = ProductCategory::find($category_id);
        $products = Product::where('product_category_id', $category_id)->get();

//        dd($category_selected);
        return view('products.by_category', [
            'category_selected' => $category_selected,
            'products' => $products,
        ]);
    }

    public function by_category_search(Request $request,$category_id)
    {
        $query = $request->input('query');
        $category_selected = ProductCategory::find($category_id);
        $products = Product::where('product_category_id', $category_id)
            ->where('name', 'like', "%$query%")
            ->get();

        return view('products.by_category', [
            'category_selected' => $category_selected,
            'products' => $products,
            'query' => $query,
        ]);
    }
}
