<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellersController extends Controller
{


    public function create()
    {
        $user = Auth::user();
        $data = ['user' => $user];
        return view('sellers.create',$data);

    }



    public function store(Request $request)
    {
//        $this->validate($request,[
//
//            'content' => 'required',
//            'is_feature' => 'required|boolean',
//        ]);
//           $data=$request->only('user_id','status');
        Seller::create($request->all());
        return redirect()->route('home');
    }



    public function edit(Seller $seller)
    {
        $data = [
            'seller'=> $seller,
        ];
        return view('sellers.edit',$data);
    }

    public function update(Request $request, Seller $seller)
    {
//        $this->validate($request,[
//            'title' => 'required|max:50',
//            'content' => 'required',
//            'is_feature' => 'required|boolean',
//        ]);

        $seller->update($request->all());
        return redirect()->route('seller.index');
    }

    public function destroy(Seller $seller)
    {
        $seller->delete();
        return redirect()->route('sellers.index');
    }
}
