@extends('admins.layouts.master')

@section('page-title', 'Edit article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">管理員資料管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">編輯用戶資料</li>
        </ol>
        @include('admins.layouts.shared.errors')
        <form action="{{ route('admins.admins.update',$admin->id) }}" method="POST" role="form">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">使用者id</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name',$admin->user->name	) }}" placeholder="請輸入帳號">
            </div>
            <div class="form-group">
                <label for="position" class="form-label">職級</label>
                <select id="position" name="position" class="form-control">
                    <option value=3>一般管理員</option>
                    @if(Auth::user()->admin->position <= 2)
                        <option value=2>高階管理員</option>
                    @endif
                    @if(Auth::user()->admin->position == 1)
                        <option value=1>超級管理員</option>
                    @endif
                </select>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">儲存</button>
            </div>
        </form>
    </div>
@endsection
