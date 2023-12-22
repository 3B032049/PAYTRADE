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
        $products = Product::orderBy('id','DESC')->where('status',3)->get();
        $data = [
            'products' => $products,
        ];
        return view('index',$data);
    }
}

