<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Message;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('perPage', 10);
        $orders = Order::where('user_id', $user->id)->paginate($perPage);
        $data = ['orders' => $orders];

        return view('orders.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $selectedItems = $request->query('selected_items');

        // 將這些 ID 轉換為數組，然後使用它們進行進一步的處理
        $selectedItemsArray = explode(',', $selectedItems);

        // 根據 $selectedItemsArray 獲取相應的商品信息，這可以通過你的數據庫模型或其他方式完成
        $selectedCartItems = CartItem::whereIn('id', $selectedItemsArray)->get();

        // 現在，$selectedProducts 將包含所選商品的信息，你可以將它傳遞給結帳視圖
        return view('orders.create', ['selectedCartItems' => $selectedCartItems]);
    }

    public function show_create(Request $request)
    {
        $user = Auth::user();
        $selectedItems = $request->input('selected_items');

        $selectedCartItems = Product::where('id', $selectedItems)
            ->first();

        // 判斷使用者是否擁有該商品
        if ($selectedCartItems->seller->user->id == $user->id) {
            return back()->with('error', '您不能購買自己的商品！');
        }
        return view('orders.show_create', ['selectedCartItems' => $selectedCartItems]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show_store(StoreOrderRequest $request, Product $product)
    {
        // 創建一個新的訂單
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->seller_id = 1;
        $order->status = 0;
        $order->date = now();
        $order->pay = 0;

        // 使用 $product 來獲取價格
        $order->price = $product->price + 60;

        $order->receiver = $request->receiver;
        $order->receiver_phone = $request->receiver_phone;
        $order->receiver_address = $request->receiver_address;

        // 儲存訂單
        $order->save();

        // 創建一個新的訂單明細
        $orderDetail = new OrderDetail();
        $orderDetail->order_id = $order->id;
        $orderDetail->product_id = $product->id; // 使用 $product->id 來獲取商品ID
        $orderDetail->quantity = 1;

        // 儲存訂單明細
        $orderDetail->save();

        // 扣除商品庫存
        $product->decrement('inventory', 1);

        // 檢查庫存是否為 0，如果是，設置商品的 status 為 4
        if ($product->inventory === 0) {
            $product->update(['status' => 4]);
        }

        return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        // 先獲取購物車商品資訊
        $selectedItems = json_decode($request->input('selected_items'), true);

        // 這裡假設你已經登入並取得會員資訊
        $user = auth()->user();

        // 將購物車商品與商品資料表連結
        $productsByCartItem = collect($selectedItems)->map(function ($item) {
            // 利用product_id關聯
            $product = Product::find($item['product_id']);

            // 回傳商品 &　購物車商品連結
            return [
                'product' => $product,
                'cart_item' => $item,
            ];
        });

        // 檢查所有商品庫存是否足夠
        if ($this->checkInventoryForAll($productsByCartItem)) {
            // 遍歷分組後的商品，建立對應的訂單
            $productsByCartItem->groupBy(function ($item) {
                // 以seller_id區隔
                return $item['product']->seller_id;
            })->each(function ($items, $sellerId) use ($request, $user) {
                // 建立訂單
                $order = new Order();
                $order->user_id = $user->id;
                $order->seller_id = $sellerId;
                $order->status = 0;
                $order->date = now();
                $order->pay = 0;
                $order->price = $items->sum(function ($item) {
                        return $item['cart_item']['quantity'] * $item['cart_item']['product']['price'];
                    }) + 60;
                $order->receiver = $request->receiver;
                $order->receiver_phone = $request->receiver_phone;
                $order->receiver_address = $request->receiver_address;

                // 儲存訂單
                $order->save();

                // 建立訂單明細
                foreach ($items as $item) {
                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $item['cart_item']['product_id'];
                    $orderDetail->quantity = $item['cart_item']['quantity'];
                    // ...其他訂單明細相關欄位

                    // 儲存訂單明細
                    $orderDetail->save();

                    // 扣除商品庫存
                    Product::where('id', $item['cart_item']['product']['id'])->decrement('quantity', $item['cart_item']['quantity']);

                    // 檢查庫存是否為 0，如果是，設置商品的 status 為 4
                    $updatedInventory = Product::where('id', $item['cart_item']['product']['id'])->value('quantity');

                    if ($updatedInventory == 0) {
                        Product::where('id', $item['cart_item']['product']['id'])->update(['status' => 4]);
                    }
                }

                // 刪除購物車中的商品
                $productIdsToRemove = $items->pluck('cart_item.product_id');
                $user->cartItems()->whereIn('product_id', $productIdsToRemove)->delete();
            });

            return redirect()->route('home'); // 跳轉到你想要的路由
        } else {
            // 如果庫存不足，返回上一頁並帶上錯誤訊息
            return back()->withErrors(['error' => '庫存不足，請調整購買數量。']);
        }
    }

    private function checkInventoryForAll($productsByCartItem)
    {
        foreach ($productsByCartItem as $item) {
            $product = $item['product'];
            $quantity = $item['cart_item']['quantity'];

            if ($product['quantity'] < $quantity) {
                return false; // 如果有任一商品庫存不足，返回 false
            }
        }

        return true; // 所有商品庫存足夠
    }
    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $comment = Message::where('order_id', $order->id)->first();

        $orderDetails = OrderDetail::where('order_id', $order->id)->get();

        $data = [
            'order_details' => $orderDetails,
            'has_comment' => $comment !== null, // 如果评论存在，has_comment 将为 true，否则为 false
            'order' => $order,
        ];

        return view('orders.show', $data);
    }

    public function payment(Order $order)
    {
        //
//        $order = Order::where('id',$order_id)->get();
        $orderDetails = OrderDetail::where('order_id', $order->id)->get();
        $data = ['order_details' => $orderDetails,'order' => $order];

        return view('orders.payment', $data);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function comment_edit(Order $order)
    {
        return view('orders.comment_edit', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_pay(Order $order)
    {
        //
        $order->status='1';
        $order->pay='1';
        $order->save();
        return redirect()->route('orders.index');
    }

    public function cancel_order(Order $order)
    {
        //
        $order->status='7';
        $order->save();
        return redirect()->route('orders.index');
    }

    public function complete_order(Order $order)
    {
        //
        $order->status='5';
        $order->save();
        return redirect()->route('orders.index');
    }

    public function comment(Order $order)
    {
        $data = ['order' => $order];

        return view('orders.comment', $data);
    }

    public function store_comment(Request $request, Order $order)
    {

        // 使用 updateOrCreate 方法更新或創建 Message 模型
        $message = Message::updateOrCreate(
            ['order_id' => $order->id],
            [
                'buyer_message' => $request->input('comment'),
                'buying_rating' => $request->input('comment_rating'),
            ]
        );

        if ($message) {
            $message->save();
        }

        // 重定向到訂單列表頁面
        return redirect()->route('orders.index');
    }


    public function filter(Request $request)
    {
        $status = $request->input('status');
        $status = $request->input('status');
        $status2 = $request->input('status2');
        $status3 = $request->input('status3');
        $status4 = $request->input('status4');

        $orders = Order::whereIn('status', [$status, $status2,$status3,$status4])->get();
        // You can pass $orders to the view and display the filtered orders

        // Redirect back to the order list
        return view('orders.index', ['orders' => $orders]);
    }

    public function update_comment(Request $request, Order $order)
    {
        $message = message::updateOrCreate(
            ['order_id' => $order->id],
            [
                'buyer_message' => $request->input('buyer_message'),
                'buying_rating' => $request->input('comment_rating'),
            ]
        );

        if ($message) {
            $message->save();
        }

        // 重定向到訂單列表頁面
        return redirect()->route('orders.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 10);

        $orders = Order::whereHas('seller.user', function ($queryBuilder) use ($query) {
            $queryBuilder->where('name', 'like', "%$query%");
        })
            ->orWhereHas('user', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%");
            })
            ->paginate($perPage);

        return view('orders.index', [
            'orders' => $orders,
            'query' => $query,
        ]);
    }

}
