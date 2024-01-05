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

        $products = Product::orderBy('id', 'DESC')->where('status', 3)->get();

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

        $perPage = $request->input('perPage', 12);
        $products = Product::orderBy('id','DESC')->where('status',3)->paginate($perPage);

        $data = [
            'products' => $products,
            'buyingRatings' => $buyingRatings,
            'buyerMessages' => $buyerMessages,
        ];

        return view('index', $data);
    }

}

