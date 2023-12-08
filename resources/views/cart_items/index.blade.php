@extends('layouts.master')

@section('title','購物車')

@section('content')
    <div class="wrapper mx-auto">
        <div class="container mx-auto mt-8">
            <h1 class="text-2xl mb-4">購物車內容</h1>

            @if ($cartItems->count() > 0)
                <table class="min-w-full bg-white border border-gray-200">
                    <tr align="center">
                        <th class="py-2">商品圖片</th>
                        <th>商品名稱</th>
                        <th>價格</th>
                        <th>數量</th>
                        <th>小計</th>
                        <th>刪除</th>
                    </tr>
                    <tbody>
                    @foreach ($cartItems as $cartItem)
                        <tr>
                            <td class="py-2 px-4 border-b">
                                <img src="{{ asset('storage/products/' . $cartItem->product->image_url) }}" alt="{{ $cartItem->product->name }}" width="150px" height="150px">
                            </td>
                            <td class="py-2 px-4 border-b">{{ $cartItem->product->name }}</td>
                            <td class="py-2 px-4 border-b">${{ $cartItem->product->price }}</td>
                            <td class="py-2 px-4 border-b">
                                <form action="{{ route('cart_items.update', $cartItem->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit">-</button>
                                    <span class="mx-2">1{{ $cartItem->quantity }}</span>
                                    <button type="submit">+</button>
                                </form>
                            </td>
                            <td class="py-2 px-4 border-b">${{ $cartItem->quantity * $cartItem->product->price }}</td>
                            <td class="py-2 px-4 border-b">
                                <form action="{{ route('cart_items.destroy', $cartItem->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">刪除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button>結帳</button>
            @else
                <p class="text-gray-600">購物車內無商品。</p>
            @endif
        </div>


    </div>
@endsection
