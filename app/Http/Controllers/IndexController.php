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
        $products = Product::orderBy('id','DESC')->where('status',3)->paginate($perPage);
        $data = [
            'products' => $products,
        ];
        return view('index',$data);
    }
}

