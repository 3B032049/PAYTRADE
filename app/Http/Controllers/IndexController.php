<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 12);

        // 只獲取庫存不為0的商品
        $products = Product::where('status', 3)
            ->where('quantity', '>', 0)
            ->orderBy('id', 'DESC')
            ->paginate($perPage);

        $buyingRatings = [];
        $buyerMessages = [];

        foreach ($products as $product) {
            // 檢查是否有 orderDetail
            if ($product->orderDetail) {
                // 檢查是否有 message
                if ($product->orderDetail->message) {
                    $buyingRatings[] = $product->orderDetail->message->buying_rating;
                    $buyerMessages[] = $product->orderDetail->message->buyer_message;
                }
            }
        }

        $data = [
            'products' => $products,
            'buyingRatings' => $buyingRatings,
            'buyerMessages' => $buyerMessages,
        ];

        return view('index', $data);
    }

    public function detail()
    {
        $products = Product::orderby('id','ASC')->where('status',3)->get();
        $data = ['products' => $products];
        return view('detail',$data);
    }
}

