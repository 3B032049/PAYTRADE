@extends('products.index.layouts.master')

@section('title','訂單')

@section('page-content')
    <div class="wrapper">
        <div class="container mt-8">
            <h1 class="text-2xl mb-4" align="center">購物車內容</h1>

            <!-- Existing Cart Section -->
            @if ($cartItems->count() > 0)
                <!-- ... (Your existing cart table) ... -->
            @else
                <p class="text-gray-600">購物車內無商品。</p>
            @endif

            <!-- Checkout Section -->
            <h2 class="text-2xl mb-4" align="center">訂單結帳</h2>
            <form action="{{ route('checkout') }}" method="POST" id="checkoutForm">
                @csrf
                @method('POST')

                <!-- Display selected items and calculate total amount -->
                <div id="order-summary-checkout">
                    <!-- This section is dynamically generated based on the selected items in the shopping cart -->
                </div>

                <!-- Member Information -->
                <h3>Member Information</h3>
                <p>Member Name: <span id="member-name">John Doe</span></p>
                <p>Member Email: <span id="member-email">john@example.com</span></p>

                <!-- Shipping Information -->
                <h3>Shipping Information</h3>
                <input type="checkbox" id="same-as-member" onclick="copyMemberInfo()"> Same as Member Information<br>
                <div id="shipping-info">
                    <label for="recipient-name">Recipient Name:</label>
                    <input type="text" id="recipient-name" name="recipient_name" placeholder="Recipient Name"><br>

                    <label for="recipient-phone">Recipient Phone:</label>
                    <input type="text" id="recipient-phone" name="recipient_phone" placeholder="Recipient Phone"><br>

                    <label for="recipient-address">Recipient Address:</label>
                    <input type="text" id="recipient-address" name="recipient_address" placeholder="Recipient Address"><br>
                </div>

                <!-- Checkout Button -->
                <div class="text-center">
                    <button class="btn btn-outline-dark mx-6 mt-auto" type="submit">結帳</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // The existing JavaScript code for the cart page

        // Dummy data for selected items
        const selectedItems = [
            // ... (Retrieve selected items from your existing cart logic)
        ];

        // Display selected items and calculate total amount for checkout
        function displayOrderSummaryCheckout() {
            // ... (Similar logic as in the existing cart page)
        }

        // Copy member information to shipping information if "Same as Member Information" is checked
        function copyMemberInfo() {
            // ... (Similar logic as in the existing cart page)
        }

        // Initial display of order summary for checkout
        displayOrderSummaryCheckout();
    </script>
@endsection
