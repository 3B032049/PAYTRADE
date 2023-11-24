@extends('layouts.master')

@section('title','賣場')

@section('content')
<div class="wrapper">
    <div class="mx-2 mt-2 grid lg:grid-cols-6 sm:grid-cols-4 gap-3">

{{--            @for ($i = 0; $i <= 20; $i++)--}}
                @foreach($products as $product)
{{--            <livewire:shopping.list-item :wire:key="'list-product' . $product->id" :item="$item"/>--}}
{{--            <div class="border-2 border-gray-100 rounded-lg shadow-lg px-5 pt-5 pb-2">--}}
{{--                <img class="object-cover h-36 w-full" src="{{ $product->image_url }}"/>--}}
{{--                <p class="text-sm font-bold mt-2">{{ $product->name }}</p>--}}
{{--                <p class="text-center">--}}
{{--                    <span class="text-xs font-extrabold text-pink-500">{{ $product->slogan }}</span>--}}
{{--                </p>--}}
{{--                <p class="text-center">--}}
{{--                    <span class="text-xs">網路價</span>--}}
{{--                    <span class="text-red-600 font-extrabold">${{ $product->price }}</span>--}}
{{--                </p>--}}
{{--            </div>--}}
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
{{--            @endfor--}}

    </div>
{{--    <dic class ="location-info">--}}
{{--        <h3 class="sub-title">國立勤益科技大學</h3>--}}
{{--        <h4>地址:411030台中市太平區中山路二段57號</h4>--}}
{{--        <h4>電話:0423924505</h4>--}}
{{--        <h4>營業時間:</h4>--}}
{{--        星期一08:00–22:00<br>--}}
{{--        星期二08:00–22:00<br>--}}
{{--        星期三08:00–22:00<br>--}}
{{--        星期四08:00–22:00<br>--}}
{{--        星期五08:00–22:00<br>--}}
{{--        星期六08:00–22:00<br>--}}
{{--        星期日08:00–22:00<br>--}}
{{--    </div>--}}
{{--    <div class="location-map">--}}
{{--        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3640.7284829645178!2d120.73028387508364!3d24.146171673467897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3469235d7fb2c4a7%3A0x1cc856130460088d!2z5ZyL56uL5Yuk55uK56eR5oqA5aSn5a24!5e0!3m2!1szh-TW!2stw!4v1698370918401!5m2!1szh-TW!2stw" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>--}}
{{--    </div>--}}
</div>
@endsection
