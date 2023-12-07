@extends('layouts.master')

@section('title','賣場')

@section('content')
<div class="wrapper mx-auto">
{{--    <div class="mx-2 mt-2">--}}
{{--        <h1>賣場商品一覽</h1>--}}
{{--    </div>--}}
    <div class="mx-4 mt-4 grid grid-cols-4 gap-5">
        <!-- 商品列表 -->
        @foreach($products as $product)
            <div id=product-grid>
{{--                <div class=txt-heading>產品</div>--}}
                <div class="card mb-4">
                    <img src="{{ asset('storage/products/' . $product->image_url) }}" class="card-img-top" alt="{{ $product->title }}" width="100" height="200">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $product->name }}</h5>
                    </div>
                    <div class="card-footer text-center">
                        ${{ $product->price }}
                        <form action="{{ route("cart_items.store",$product->id) }}" method="POST" role="form">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-secondary">加入購物車</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
