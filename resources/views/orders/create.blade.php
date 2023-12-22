@extends('products.index.layouts.master')

@section('title', '訂單')

@section('content')
<hr>
    <div class="wrapper">
        <div class="container mt-8">
            <h3 class="text-2xl mb-4" align="center">訂單結帳</h3>
        </div>
    </div>

    @if ($cartItems->count() > 0)
        <table class="min-w-full bg-white border border-gray-200 mx-auto" border="1">
            <tr align="center">
                <th class="py-2">商品圖片</th>
                <th>商品名稱</th>
                <th>價格</th>
                <th>數量</th>
                <th>小計</th>
            </tr>
            <tbody>
            @php
                $totalSum = 0;
            @endphp
            @foreach ($cartItems as $cartItem)
                <tr>
                    <td class="py-2 px-4 border-b">
                        <img src="{{ asset('storage/products/' . $cartItem->product->image_url) }}" alt="{{ $cartItem->product->name }}" width="80px" height="80px">
                    </td>
                    <td class="py-2 px-4 border-b">{{ $cartItem->product->name }}</td>
                    <td class="py-2 px-4 border-b price" data-price="{{ $cartItem->product->price }}">
                        ${{ $cartItem->product->price }}
                    </td>
                    <td class="py-2 px-4 border-b">
                        <span class="quantity-span">
                            {{ $cartItem->quantity }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border-b subtotal">
                        ${{ number_format($cartItem->quantity * $cartItem->product->price, 0) }}
                    </td>
                </tr>
                @php
                    $totalSum += $cartItem->quantity * $cartItem->product->price;
                @endphp
            @endforeach
            <tr>
                <td colspan="5">
                    <br><h4>&nbsp買家資訊</h4>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <p>&nbsp&nbsp買家名稱: <span id="member-name">John Doe</span></p>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <p>&nbsp&nbsp買家信箱: <span id="member-email">john@example.com</span></p>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <h4>&nbsp收件人資訊</h4>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    &nbsp&nbsp<input type="checkbox" id="same-as-member" onclick="copyMemberInfo()">&nbsp&nbsp同買家資訊<br>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <div id="shipping-info">
                        <label for="recipient-name">&nbsp&nbsp收件人名稱:</label>
                        <input type="text" id="recipient-name" name="recipient_name" placeholder="收件人名稱"><br><br>

                        <label for="recipient-phone">&nbsp&nbsp收件人電話:</label>
                        <input type="text" id="recipient-phone" name="recipient_phone" placeholder="收件人電話"><br><br>

                        <label for="recipient-address">&nbsp&nbsp收件人名稱:</label>
                        <input type="text" id="recipient-address" name="recipient_address" placeholder="收件人名稱"><br><br>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <form action="{{ route('cart_items.update', $cartItem->id) }}" method="POST" id="updateCartItemForm">
                        @csrf
                        @method('PATCH')
                        <div class="text-center">
                            總金額：${{ number_format($totalSum, 0) }}
                            <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">下單</button><br><br>
                        </div>
                    </form>
                </td >
            </tr>
            </tbody>
        </table>

    @else
        <p class="text-gray-600">購物車內無商品。</p>
    @endif
@endsection
