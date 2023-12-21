@extends('admins.layouts.master')

@section('page-title', 'Article list')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">賣家管理</h1>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('admins.users.create') }}">新增用戶</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" style="text-align:left">姓名</th>
                <th scope="col" style="text-align:left">電子信箱</th>
                <th scope="col" style="text-align:left">狀態</th>
                <th scope="col" style="text-align:center">操作</th>
{{--                <th scope="col" style="text-align:center">刪除</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($sellers as $seller)
                <tr>
                    <td style="text-align:left">{{ $seller->id }}</td>
                    <td>{{ $seller->name }}</td>
                    <td>{{ $seller->email }}</td>
                    <td>
                        @if ($seller->status == 0)
                            <div style="color:#FF0000; font-weight:bold;">
                            (申請未通過)
                            </div>
                        @elseif ($seller->status == 1)
                            <div style="color:#FF8033; font-weight:bold;">
                            (停權)
                            </div>
                        @elseif ($seller->status == 2)
                            <div style="color:#33FF33; font-weight:bold;">
                            (正式賣家)
                            </div>
                        @elseif ($seller->status == 3)
                            <div style="color:#FFB233; font-weight:bold;">
                            (申請中)
                            </div>
                        @endif
                    </td>
                    <td style="text-align:center">
                        @if ($seller->status == 0)

                        @elseif ($seller->status == 1)
                            <form action="{{ route('admins.sellers.statusOn',$seller->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">啟用</button>
                            </form>
                        @elseif ($seller->status == 2)
                            <form action="{{ route('admins.sellers.statusOff',$seller->id) }}" method="POST" role="form">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">停權</button>
                            </form>
                        @elseif ($seller->status == 3)
                            <a href="{{ route('admins.sellers.edit',$seller->id) }}" class="btn btn-secondary btn-sm">審核申請</a>
                        @endif
                    </td>
{{--                    <td style="text-align:center">--}}
{{--                        <form action="{{ route('admins.sellers.destroy',$seller->id) }}" method="POST">--}}
{{--                            @method('DELETE')--}}
{{--                            @csrf--}}
{{--                            <button type="submit" class="btn btn-danger btn-sm">刪除</button>--}}
{{--                        </form>--}}
{{--                    </td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
