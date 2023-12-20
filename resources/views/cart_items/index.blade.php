@extends('products.index.layouts.master')

@section('title','購物車')

@section('content')
<hr>
    <div class="wrapper">
        <div class="container mt-8">
            <h1 class="text-2xl mb-4" align="center">購物車內容</h1>

            @if ($cartItems->count() > 0)
                <table class="min-w-full bg-white border border-gray-200 mx-auto">
                    <tr align="center">
                        <th> </th>
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
                                <input type="checkbox" style="transform: scale(1.5)" name="selected_items[]" value="{{ $cartItem->id }}">
                            </td>
                            <td class="py-2 px-4 border-b">
                                <img src="{{ asset('storage/products/' . $cartItem->product->image_url) }}" alt="{{ $cartItem->product->name }}" width="150px" height="150px">
                            </td>
                            <td class="py-2 px-4 border-b">{{ $cartItem->product->name }}</td>
                            <td class="py-2 px-4 border-b price" data-price="{{ $cartItem->product->price }}">
                                ${{ $cartItem->product->price }}
                            </td>
                            <td class="py-2 px-4 border-b">
                                <form action="{{ route('cart_items.update', $cartItem->id) }}" method="POST" id="updateCartItemForm">
                                    @csrf
                                    @method('PATCH')
                                    <span class="quantity-span">
                                    <button class="quantity-minus" type="button" onclick="setOperationInput('minus')">-</button>
                                    <input class="quantity-input" type="text"  name="quantity" value="{{ $cartItem->quantity }}" style="max-width: 6rem">
                                    <button class="quantity-plus" type="button" onclick="setOperationInput('plus')">+</button>
                                    <input type="hidden" name="operation" id="operationInput" value="">
                                    </span>
                                </form>
                            </td>
                            <td class="py-2 px-4 border-b subtotal">
                                ${{ number_format($cartItem->quantity * $cartItem->product->price,0) }}
                            </td>
                            <td class="py-2 px-4 border-b">
                                <form action="{{ route('cart_items.destroy', $cartItem->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">刪除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="7"><hr></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-left" style="height: 80px">總金額：</td>
                        <td colspan="2" class="text-center" id="totalAmount">${{ number_format($totalAmount, 0) }}</td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <form action="{{ route('orders.create', $cartItem->user_id) }}" method="POST" id="checkoutForm">
                                @csrf
                                @method('POST')
                                <div class="text-center">
                                    <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">結帳</button>
                                </div><br><br>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>

            @else
                <p class="text-gray-600">購物車內無商品。</p>
            @endif
        </div>


    </div>
<script>
    function setOperationInput(operation) {
        const operationInput = document.getElementById('operationInput');
        operationInput.value = operation;

        // 觸發表單提交
        document.getElementById('updateCartItemForm').submit();
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantitySpans = document.querySelectorAll('.quantity-span');
        const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
        const totalAmountElement = document.getElementById('totalAmount');

        quantitySpans.forEach(span => {
            const quantityInput = span.querySelector('.quantity-input');
            const minusButton = span.querySelector('.quantity-minus');
            const plusButton = span.querySelector('.quantity-plus');

            minusButton.addEventListener('click', function(event) {
                event.preventDefault();
                updateQuantity(quantityInput, -1);
            });

            plusButton.addEventListener('click', function(event) {
                event.preventDefault();
                updateQuantity(quantityInput, 1);
            });
        });

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateTotalAmount();
            });
        });

        function updateQuantity(input, change) {
            let newValue = parseInt(input.value) + change;
            if (newValue < 1) {
                newValue = 1;
            }
            input.value = newValue;

            // 獲取價格元素和小計元素
            const priceElement = input.closest('tr').querySelector('.price');
            const subtotalElement = input.closest('tr').querySelector('.subtotal');

            // 獲取商品價格和小計
            const productPrice = parseFloat(priceElement.dataset.price);
            const subtotal = newValue * productPrice;

            // 更新小計價格
            subtotalElement.textContent = `$${subtotal.toFixed(0)}`;

            // 更新總金額
            updateTotalAmount();
        }

        function updateTotalAmount() {
            const subtotalElements = document.querySelectorAll('.subtotal');
            let totalAmount = 0;

            subtotalElements.forEach(subtotalElement => {
                const checkbox = subtotalElement.closest('tr').querySelector('input[name="selected_items[]"]');
                if (checkbox.checked) {
                    totalAmount += parseFloat(subtotalElement.textContent.replace('$', ''));
                }
            });

            totalAmountElement.textContent = `$${totalAmount.toFixed(0)}`;
        }
    });
</script>
@endsection



