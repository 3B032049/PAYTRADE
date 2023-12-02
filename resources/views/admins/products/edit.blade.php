@extends('admins.layouts.master')

@section('page-title', 'Edit article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">書籍管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">編輯書籍資料</li>
        </ol>
        @include('admins.layouts.shared.errors')
        <form action="{{ route('admins.products.update',$product->id) }}" method="POST" role="form">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">書籍名稱</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$product->name) }}" placeholder="請輸入帳號">
            </div>
            <div class="form-group">
                <label for="name" class="form-label">書籍圖片</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$user->name) }}" placeholder="請輸入姓名">
            </div>
            <div class="form-group">
                <label for="email" class="form-label">書籍內容</label>
                <input id="email" name="email" type="text" class="form-control" value="{{ old('email',$user->email) }}" placeholder="請輸入信箱">
            </div>
            <div class="form-group">
                <label for="password" class="form-label">價格</label>
                <input id="password" name="password" type="text" class="form-control" value="{{ old('password',$user->password) }}" placeholder="請輸入密碼" readonly>
            </div>
            <div class="form-group">
                <label for="birthday" class="form-label">數量</label>
                <input id="birthday" name="birthday" type="date" class="form-control" value="{{ old('birthday',$user->birthday) }}" placeholder="請輸入日期">
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">儲存</button>
            </div>
        </form>
    </div>
@endsection
