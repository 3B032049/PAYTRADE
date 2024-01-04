<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Message;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderMessagesController extends Controller
{
    public function index(Request $request)
    {
        $seller = Auth::user()->seller;
        $perPage = $request->input('perPage', 10);
        $orders = Order::where('status', '5')
            ->where('seller_id', $seller->id)
            ->orderBy('id', 'ASC')
            ->paginate($perPage);

        $data = ['orders' => $orders];
        return view('sellers.messages.index', $data);
    }

    public function search(Request $request)
    {
        $seller = Auth::user()->seller;
        $query = $request->input('query');
        $perPage = $request->input('perPage', 10);

        $orders = Order::where('status', '5')
            ->where('seller_id', $seller->id)
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where(function ($subQuery) use ($query) {
                    $subQuery->whereHas('seller.user', function ($userQuery) use ($query) {
                        $userQuery->where('name', 'like', "%$query%");
                    })
                        ->orWhereHas('user', function ($userQuery) use ($query) {
                            $userQuery->where('name', 'like', "%$query%");
                        });
                });
            })
            ->orderBy('id', 'ASC')
            ->paginate($perPage);

        $data = ['orders' => $orders, 'query' => $query];
        return view('sellers.messages.index', $data);
    }

    public function edit(Order $order)
    {
        $data = [
            'order'=> $order,
        ];
        return view('sellers.messages.edit',$data);
    }
    public function update(Request $request,$order_id)
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
        return redirect()->route('sellers.messages.index');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('sellers.messages.index');
    }

}
