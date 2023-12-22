<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;

class CartItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems;
        $totalAmount = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });

        $data = [
            'cartItems' => $cartItems,
            'totalAmount' => $totalAmount,
        ];

        return view('cart_items.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartItemRequest $request, Product $product)
    {
        $user = Auth::user();
        $cartItem = $user->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // 商品已存在於購物車，更新數量
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->input('quantity'),
            ]);
        } else {
            // 商品不存在於購物車，新增購物車項目
            $user->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->input('quantity'),
            ]);
        }

//        return redirect()->back()->with('success', '成功加入購物車!');
        return redirect()->route('home');
    }



    /**
     * Display the specified resource.
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemRequest $request, $id)
    {
//        $this->validate($request,[
//            'quantity' => 'required|integer|min:1',
//        ]);
        $cartItem = CartItem::findOrFail($id);
        $cartItem->update(['quantity' => $request->quantity]);
        return redirect()->route('cart_items.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
        return redirect()->route('cart_items.index');
    }
}
