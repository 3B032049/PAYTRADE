<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Product;

class indexController extends BaseController
{
    public function index()
    {
        $products = Product::orderBy('id','DESC')->get();
        $data = [
            'products' => $products,
        ];
        return view('index',$data);
    }
}

