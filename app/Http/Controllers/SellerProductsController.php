<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductCategory;

class SellerProductsController extends Controller
{
    public function index(Request $request)
    {
        $seller = Auth::user()->seller;
        $perPage = $request->input('perPage', 10);
        $products = Product::orderby('id','ASC')->where('seller_id',$seller->id)->paginate($perPage);
        $data = ['products' => $products];
        return view('sellers.products.index',$data);
    }

    public function search(Request $request)
    {
        $seller = Auth::user()->seller;
        $perPage = $request->input('perPage', 10);
        $searchTerm = $request->input('query');

        $products = Product::with(['seller.user'])
            ->where('seller_id', $seller->id)
            ->when($searchTerm, function ($query, $searchTerm) {
                $query->whereHas('seller.user', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('name', 'like', "%$searchTerm%");
                })->orWhere('name', 'like', "%$searchTerm%");
            })
            ->orderBy('id', 'ASC')
            ->paginate($perPage);

        $data = [
            'products' => $products,
            'query' => $searchTerm,
        ];

        return view('sellers.products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product_category = ProductCategory::orderby('id','ASC')->get();
        $data = ['product_category' => $product_category];

        return view('sellers.products.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:25',
            'content' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $seller_id=auth()->user()->seller->id;
        $product = new Product;

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time().'.'.$image->getClientOriginalExtension();

            // 存儲原始圖片
            Storage::disk('products')->put($imageName, file_get_contents($image));
            $product->image_url = $imageName;
        }
        $product->name = $request->name;
        $product->product_category_id = $request->product_category;
        $product->seller_id =$seller_id;
        $product->status='0';
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

        return redirect()->route('sellers.products.index');
    }
    public function reply(Product $product)
    {
        $product->status='0';
        $product->save();
        return redirect()->route('sellers.products.index');
    }
    public function statusoff(Product $product)
    {
        $product->status='4';
        $product->save();
        return redirect()->route('sellers.products.index');
    }
    public function statuson(Product $product)
    {
        $product->status='3';
        $product->save();
        return redirect()->route('sellers.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image_url) {
            Storage::disk('products')->delete($product->image_url);
        }
        $product->delete();
        return redirect()->route('sellers.products.index');
    }
}
