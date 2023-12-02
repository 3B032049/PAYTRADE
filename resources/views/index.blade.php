@extends('layouts.master')

@section('title','賣場')

@section('content')
<div class="wrapper">
{{--    <div class="mx-2 mt-2 grid lg:grid-cols-6 sm:grid-cols-4 gap-3">--}}
{{--        <h1>賣場商品一覽</h1>--}}
        @foreach($products as $product)
{{--            <div id=product-grid>--}}
{{--                <div class=txt-heading>產品</div>--}}
                <div class="card mb-4">
                    <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->title }}" width="100" height="200">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                    </div>
                    <div class="card-footer text-center">
                        ${{ $product->price }}
                        <a href="#" class="btn btn-secondary">加入購物車</a>
                    </div>
                </div>
{{--            </div>--}}
        @endforeach
{{--    </div>--}}
</div>
@endsection
