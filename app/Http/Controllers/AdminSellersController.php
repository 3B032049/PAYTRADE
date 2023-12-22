<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Seller;

class AdminSellersController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10); // Default: 10 records per page
        $sellers = DB::table('sellers')
            ->join('users', 'sellers.user_id', '=', 'users.id')
            ->select('sellers.*', 'users.name', 'users.email') // 選擇需要的使用者資料
            ->orderBy('sellers.id', 'ASC')
            ->paginate($perPage);
        $data = ['sellers' => $sellers];
        return view('admins.sellers.index',$data);
    }

    public function statusOn(Request $request, Seller $seller)
    {
        $seller->update(['status' => 2]);
        return redirect()->route('admins.sellers.index');
    }

    public function statusOff(Request $request, Seller $seller)
    {
        $seller->update(['status' => 1]);
        return redirect()->route('admins.sellers.index');
    }

    public function edit(Seller $seller)
    {
        $data = [
            'seller'=> $seller,
        ];
        return view('admins.sellers.edit',$data);
    }

    public function pass(Request $request, Seller $seller)
    {
        $seller->update(['status' => 2]);
        return redirect()->route('admins.sellers.index');
    }

    public function unpass(Request $request, Seller $seller)
    {
        $seller->update(['status' => 0]);
        return redirect()->route('admins.sellers.index');
    }

    public function destroy(Seller $seller)
    {
        $seller->delete();
        return redirect()->route('admins.sellers.index');
    }
}
