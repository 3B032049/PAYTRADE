@extends('products.index.layouts.master')

@section('title', '訂單')

@section('content')
    <hr>
    <div class="wrapper">
        <div class="container mt-8">
            <h3 class="text-2xl mb-4" align="center">訂購清單</h3>
{{--            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp--}}
{{--            <a href="#" style="text-decoration: none;color: black" >歷史訂單</a>--}}
        </div>
    </div>

    <form id="checkoutForm" action="{{ route('orders.store') }}" method="POST">
        @csrf
        @method('POST')

        <table class="min-w-full bg-white border border-gray-200 mx-auto" border="1">
            <thead align="center">
            <tr  align="center">
                <th width="200" height="30">訂單</th>
                <th width="200" height="30">建立日期</th>
                <th width="200" height="30">狀態</th>
                <th width="200" height="30">訂單內容</th>
            </tr>
            </thead>
        </table>
        <table class="min-w-full bg-white border border-gray-200 mx-auto" border="1">
            <tbody>
            @foreach ($orders as $order)
                <tr  align="center">
                    <td width="200" height="50">訂單{{ $order->id }}</td>
                    <td width="200" height="50">{{ $order->created_at }}</td>
                    <td width="200" height="50">
                    @if ($order->status == '1')
                        <div style="color:#FF0000; font-weight:bold;">
                            (待確認)
                        </div>
                    @elseif ($order->status == '2')
                        <div style="color:#ff6f00; font-weight:bold;">
                            (發貨中)
                        </div>
                    @elseif ($order->status == '3')
                        <div style="color:#ffea00; font-weight:bold;">
                            (已出貨)
                        </div>
                    @elseif ($order->status == '4')
                        <div style="color:#48ff00; font-weight:bold;">
                            (已送達)
                        </div>
                    @elseif ($order->status == '5')
                        <div style="color:#002aff; font-weight:bold;">
                            (已完成)
                        </div>
                    @endif
                    </td>
                    <td width="200" height="50">
                        <a href="{{ route('orders.show',$order->id) }}" style="text-decoration: none;color: black" ><strong>查看訂單</strong></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>

@endsection
