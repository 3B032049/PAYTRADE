@extends('sellers.layouts.master')

@section('page-title', 'Article list')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">訂單管理</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:left">#</th>
                <th scope="col" style="text-align:left">買家</th>
                <th scope="col" style="text-align:left">訂單狀態</th>
                <th scope="col" style="text-align:left">建立日期</th>
                <th scope="col" style="text-align:center">操作</th>
{{--                <th scope="col" style="text-align:center">刪除</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->user_id }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->date }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('sellers.orders.edit',$order->id) }}" class="btn btn-secondary btn-sm">檢視訂單</a>
                    </td>
                    <td style="text-align:center">
{{--                        <form action="{{ route('sellers.products.destroy',$product->id) }}" method="POST">--}}
{{--                            @method('DELETE')--}}
{{--                            @csrf--}}
{{--                            <button type="submit" class="btn btn-danger btn-sm">刪除</button>--}}
{{--                        </form>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
