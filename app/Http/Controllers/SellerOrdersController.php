<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class SellerOrdersController extends Controller
{
    public function index()
    {
        $orders = Order::orderby('id','ASC')->get();
        $data = ['orders' => $orders];
        return view('sellers.orders.index',$data);
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $data = [
            'order'=> $order,
        ];
        return view('sellers.orders.edit',$data);
    }
    public function pass(Order $order)
    {
       $order->status='2';
        $order->save();
        return redirect()->route('sellers.orders.index');
    }
    public function unpass(Order $order)
    {
        $order->status='8';
        $order->save();
        return redirect()->route('sellers.orders.index');
    }
    public function transport(Order $order)
    {
        $order->status='3';
        $order->save();

        return redirect()->route('sellers.orders.index');
    }
    public function arrive(Order $order)
    {
        $order->status='4';
        $order->save();
        return redirect()->route('sellers.orders.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
//        $this->validate($request, [
//            'name' => 'required|max:25',
//            'content' => 'required',
//            'price' => 'required',
//            'quantity' => 'required',
//            'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
//        ]);



        $order->save();

        return redirect()->route('sellers.orders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('sellers.orders.index');
    }
}
