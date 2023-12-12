<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class IndexController extends BaseController
{
    public function index()
    {
        if (Auth::check())
        {
            $user = Auth::user();
            $cartItems = $user->CartItems;

            $products = Product::orderBy('id','DESC')->get();
            $data = [
                'cartItems' => $cartItems,
                'products' => $products,
            ];
            return view('index',$data);
        }
        else
        {
            $products = Product::orderBy('id','DESC')->get();
            $data = [
                'products' => $products,

            ];
            return view('index',$data);
        }
    }
}

