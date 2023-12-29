<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Message;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class SellersOredersMessageController extends Controller
{
    public function index()
    {
        $orders = Order::orderby('id','ASC')->get();
        $data = ['orders' => $orders];
        return view('sellers.message.index',$data);
    }
//    public function create()
//    {
//        return view('sellers.message.create');
//    }
//    public function store(Request $request)
//    {
//        OrderDetail::create($request->all());
//        return redirect()->route('sellers.message.index');
//    }
    public function edit(Order $order)
    {
        $data = [
            'order'=> $order,
        ];
        return view('sellers.message.edit',$data);
    }
    public function update(Request $request, Order $order,$order_id)
    {
        $request->validate([
            // 其他驗證規則...
            'seller_rating' => 'nullable|integer|min:1|max:5',
        ]);
        $message = Message::updateOrCreate(
            ['order_id' => $order_id],
            [
                'seller_message' => $request->input('seller_message'),
                'seller_rating' => $request->input('seller_rating'),
            ]
        );

        // 如果 $message 更新或創建成功，保存並進行其他操作
        if ($message) {
            $message->save();
        }

        // 在這裡可以進一步處理其他邏輯
        //dd($request->all());
        return redirect()->route('sellers.message.index');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('sellers.message.index');
    }

}
