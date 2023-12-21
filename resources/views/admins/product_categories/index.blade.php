@extends('admins.layouts.master')

@section('page-title', 'Article list')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">書籍類別管理</h1>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('admins.product_categories.create') }}">新增書籍類別</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:left">書籍類別名稱</th>
                <th scope="col" style="text-align:left">狀態</th>
                <th scope="col" style="text-align:center">修改狀態</th>
                <th scope="col" style="text-align:center">修改</th>
                <th scope="col" style="text-align:center">刪除</th>
            </tr>
            </thead>
            <tbody>
            @foreach($product_categories as $product_category)
                <tr>
                    <td>{{ $product_category->name }}</td>
                    <td>
                        @if ($product_category->status == 1)
                            <div style="color:#33FF33; font-weight:bold;">
                            (啟用中)
                            </div>
                        @else
                            <div style="color:#FF0000; font-weight:bold;">
                            (未啟用)
                            </div>
                        @endif
                    </td>
                    <td style="text-align:center">
                    @if ($product_category->status == 1)
                    <form action="{{ route('admins.product_categories.statusOff',$product_category->id) }}" method="POST" role="form">
                        @method('PATCH')
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">停用</button>
                    </form>
                    @else
                    <form action="{{ route('admins.product_categories.statusOn',$product_category->id) }}" method="POST" role="form">
                        @method('PATCH')
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">啟用</button>
                    </form>
                    @endif
                    </td>

                    <td style="text-align:center">
                        <a href="{{ route('admins.product_categories.edit',$product_category->id) }}" class="btn btn-secondary btn-sm">編輯</a>
                    </td>
                    <td style="text-align:center">
                        <form action="{{ route('admins.product_categories.destroy',$product_category->id) }}" method="POST">
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
