<?php

namespace App\Http\Controllers;

use App\Models\Message;
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
        if (Auth::check())
        {
            $user = Auth::user();
            $cartItems = $user->CartItems;

            $product = Product::where('id', $product)->first();
            $averageScore = Message::getAverageScoreForProduct($product->id);

            // 取得相同 product_category_id 的其他產品
            $relatedProducts = Product::where('product_category_id', $product->product_category_id)
                ->where('id', '!=', $product->id) // 排除當前產品
                ->inRandomOrder() // 隨機排序
                ->limit(4) // 限制取得的數量，根據你的需求調整
                ->get();

            $data = [
                'cartItems' => $cartItems,
                'product' => $product,
                'relatedProducts' => $relatedProducts,
                'averageScore' => $averageScore,
            ];

            return view('products.show', $data);
        }
        else
        {
            $product = Product::where('id', $product)->first();

            // 取得相同 product_category_id 的其他產品
            $relatedProducts = Product::where('product_category_id', $product->product_category_id)
                ->where('id', '!=', $product->id) // 排除當前產品
                ->inRandomOrder() // 隨機排序
                ->limit(4) // 限制取得的數量，根據你的需求調整
                ->get();

            $data = [
                'product' => $product,
                'relatedProducts' => $relatedProducts,
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
        $perPage = $request->input('perPage', 12);
        // 搜尋商品
        $products = Product::where('name', 'like', "%$query%")
            ->where('status','=',3)
            ->paginate($perPage);

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
        $selectedCategory = ProductCategory::find($category_id);
        $perPage = $request->input('perPage', 12);
        $products = Product::where('product_category_id', $category_id)
            ->where('status', 3)
            ->paginate($perPage);

        return view('products.by_category', [
            'selectedCategory' => $selectedCategory,
            'products' => $products,
        ]);
    }

    public function by_category_search(Request $request,$category_id)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 12);
        $selectedCategory = ProductCategory::find($category_id);
        $products = Product::where('product_category_id', $category_id)
            ->where('name', 'like', "%$query%")
            ->where('status', 3)
            ->paginate($perPage);

        return view('products.by_category', [
            'selectedCategory' => $selectedCategory,
            'products' => $products,
            'query' => $query,
        ]);
    }

    public function by_seller(Request $request,$seller_id)
    {
        $perPage = $request->input('perPage', 12);
        $products = Product::where('seller_id', $seller_id)
            ->where('status', 3)
            ->orderby('id','ASC')->paginate($perPage);
        $seller = Seller::where('id', $seller_id)->first();
        $sellerCategories = ProductCategory::whereIn('id', $products->pluck('product_category_id'))->get();
        $data = ['products' => $products , 'seller' => $seller , 'sellerCategories' => $sellerCategories,];

        return view('products.by_seller',$data);
    }

    public function by_seller_search(Request $request, $seller_id)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 12);

        $originalSellerCategories = ProductCategory::whereIn('id', function ($query) use ($seller_id) {
            $query->select('product_category_id')
                ->from('products')
                ->where('seller_id', $seller_id)
                ->where('status', 3);
        })->get();

        $products = Product::where('seller_id', $seller_id)
            ->where('status', 3)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', '%' . $query . '%');
            })
            ->orderBy('id', 'ASC')
            ->paginate($perPage);

        $seller = Seller::find($seller_id);

        $sellerCategories = $originalSellerCategories;

        $data = [
            'products' => $products,
            'seller' => $seller,
            'sellerCategories' => $sellerCategories,
            'query' => $query,
        ];

        return view('products.by_seller_search', $data);
    }

    public function by_seller_and_category(Request $request,$seller_id, $category_id)
    {
        $perPage = $request->input('perPage', 12);

        $originalSellerCategories = ProductCategory::whereIn('id', function ($query) use ($seller_id) {
            $query->select('product_category_id')
                ->from('products')
                ->where('seller_id', $seller_id)
                ->where('status', 3);
        })->get();

        $products = Product::where('seller_id', $seller_id)
            ->where('product_category_id', $category_id)
            ->where('status', 3)
            ->orderBy('id', 'ASC')
            ->paginate($perPage);

        $seller = Seller::find($seller_id);

        $sellerCategories = $originalSellerCategories;

        $selectedCategory = ProductCategory::find($category_id);

        $data = [
            'products' => $products,
            'seller' => $seller,
            'sellerCategories' => $sellerCategories,
            'selectedCategory' => $selectedCategory,
        ];

        return view('products.by_seller_and_category', $data);
    }

    public function by_seller_and_category_search(Request $request,$seller_id, $category_id)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 12);
        $originalSellerCategories = ProductCategory::whereIn('id', function ($query) use ($seller_id) {
            $query->select('product_category_id')
                ->from('products')
                ->where('seller_id', $seller_id)
                ->where('status', 3);
        })->get();
        $products = Product::where('seller_id', $seller_id)
            ->where('product_category_id', $category_id)
            ->where('status', 3)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', '%' . $query . '%');
            })
            ->orderBy('id', 'ASC')
            ->paginate($perPage);

        $seller = Seller::find($seller_id);
        $sellerCategories = $originalSellerCategories;
        $selectedCategory = ProductCategory::find($category_id);

        $data = [
            'products' => $products,
            'seller' => $seller,
            'sellerCategories' => $sellerCategories,
            'selectedCategory' => $selectedCategory,
            'query' => $query,
        ];

        return view('products.by_seller_and_category_search', $data);
    }
}
