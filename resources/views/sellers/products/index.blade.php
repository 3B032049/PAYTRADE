@extends('sellers.layouts.master')

@section('page-title', 'Article list')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">書籍管理</h1>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('sellers.products.create') }}">新增書籍</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:left">書籍名稱</th>
                <th scope="col" style="text-align:left">書籍圖片</th>
                <th scope="col" style="text-align:left">書籍簡述</th>
                <th scope="col" style="text-align:left">價格</th>
                <th scope="col" style="text-align:left">數量</th>
                <th scope="col" style="text-align:center">修改</th>
                <th scope="col" style="text-align:center">狀態</th>
                <th scope="col" style="text-align:center">操作</th>

                <th scope="col" style="text-align:center">刪除</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td><img src="{{ asset( 'storage/products/' . $product->image_url) }}" alt="{{ $product->name }}" height="100px" width="100px"></td>
                    <td>{{ $product->content }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('sellers.products.edit',$product->id) }}" class="btn btn-secondary btn-sm">編輯</a>
                    </td>
                    <td>
                        @if ($product->status == 0)
                            <div style="color:#FF0000; font-weight:bold;">
                                (申請中)
                            </div>
                        @elseif ($product->status == 1)
                            <div style="color:#FF8033; font-weight:bold;">
                                (申請通過)
                            </div>
                        @elseif ($product->status == 2)
                            <div style="color:#33FF33; font-weight:bold;">
                                (申請失敗)
                            </div>
                        @elseif ($product->status == 3)
                            <div style="color:#FFB233; font-weight:bold;">
                                (上架)
                            </div>
                        @elseif ($product->status == 4)
                            <div style="color:#FFB233; font-weight:bold;">
                                (下架)
                            </div>

                        @endif
                    </td>
                    <td style="text-align:center">
                        @if ($product->status == 0)

                        @elseif ($product->status == 1)
                            <form action="{{ route('sellers.products.statuson',$product->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">上架</button>
                            </form>
                        @elseif ($product->status == 2)
                            <form action="{{ route('sellers.products.reply',$product->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">重新申請</button>
                            </form>
                        @elseif ($product->status == 3)
                            <form action="{{ route('sellers.products.statusoff',$product->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">下架</button>
                            </form>
                        @elseif ($product->status == 4)
                            <form action="{{ route('sellers.products.statuson',$product->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">上架</button>
                            </form>
                        @endif
                    </td>
                    <td style="text-align:center">
                        <form action="{{ route('sellers.products.destroy',$product->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">刪除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
