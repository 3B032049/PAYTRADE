@extends('layouts.master')

@section('title','商品內容')

@section('content')
<div class="flex font-sans">
    <div class="flex-none w-48 relative">
        <img src="{{ asset('storage/products/' . $product->image_url) }}" alt="" class="absolute inset-0 w-full h-full object-cover" loading="lazy" />
    </div>
    <form class="flex-auto p-6">
        <div class="flex flex-wrap">
            <h1 class="flex-auto text-lg font-semibold text-slate-900">{{ $product->name }}</h1>
            <div class="text-lg font-semibold text-slate-500">${{ $product->price }}</div>
        </div>
        <div class="flex space-x-4 mb-6 text-sm font-medium">
            <div class="flex-auto flex space-x-4">
                <div class="form-group">
                    <input id="num" name="num" type="text" class="form-control">
                    <form action="{{ route("cart_items.store",$product->id) }}" method="POST" role="form">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-secondary">加入購物車</button>
                    </form>
                </div>
            </div>
        </div>

        <p class="text-sm text-slate-700">
            {{ $product->content }}
        </p>
    </form>
</div>
@endsection
