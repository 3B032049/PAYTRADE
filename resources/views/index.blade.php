@extends('layouts.master')

@section('title','賣場')

@section('content')
<div class="wrapper">
    <div class="mx-2 mt-2 grid lg:grid-cols-6 sm:grid-cols-4 gap-3">
        @foreach($products as $product)
            <div id=product-grid>
                <div class=txt-heading>產品</div>
                <div class='product-item'>
                    <form method=get action='#'>
                    <div class='product-image'><a href="#"><img height=155px; width=250px; src={{ $product->image_url }}></a></div>
                    <div class='product-tile-footer'>
                        <div class='product-title'>{{ $product->name }}</div>
                        <div class='product-price'>{{ $product->price }}</div>
                        <div class='cart-action'><input type=text class=product-quantity name=item_amount value=1 size=2 /><input type=submit name=action value=加入購物車 class=btnAddAction /></div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
