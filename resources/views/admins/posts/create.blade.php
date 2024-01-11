@extends('admins.layouts.master')

@section('page-title', 'Create article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">公告管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">新增公告</li>
        </ol>
        @include('admins.layouts.shared.errors')
        <form action="{{ route('admins.posts.store') }}" method="POST" role="form" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="form-group">
                <label for="title" class="form-label">公告標題</label>
                <input id=title name=title type="text" class="form-control" value="{{ old('title') }}" placeholder="請輸入文章標題">
            </div>
            <div class="form-group">
                <label for="content" class="form-label">公告內容</label>
                <textarea id="content" name="content" class="form-control" rows="10" placeholder="請輸入文章內容">{{ old('content') }}</textarea>
            </div>
            <div class="form-group">
                <label for="file" class="form-label">上傳</label>
                <input id="file" name="file" type="file" class="form-control" rows="10" placeholder="附檔">{{ old('file') }}</input>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">儲存</button>
            </div>
        </form>
    </div>
@endsection
