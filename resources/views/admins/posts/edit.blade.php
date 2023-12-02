@extends('admins.layouts.master')

@section('page-title', 'Edit article')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">文章管理</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">編輯文章</li>
        </ol>
        @include('admins.layouts.shared.errors')
        <form action="{{ route('admins.posts.update',$post->id) }}" method="POST" role="form" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="posts_title" class="form-label">文章標題</label>
                <input id="posts_title" name="posts_title" type="text" class="form-control"  value="{{ old('posts_title',$post->posts_title) }}">
            </div>
            <div class="form-group">
                <label for="posts_content" class="form-label">文章內容</label>
                <textarea id="posts_content" name="posts_content" class="form-control" rows="10" >{{ old('posts_content',$post->posts_content) }}</textarea>
            </div>
            <div class="form-group">
                <label for="is_feature" class="form-label">精選?</label>
                <select id="is_feature" name="is_feature" class="form-control">
                    <option value="0" {{(!$post->is_feature)?'selected':""}}>否</option>
                    <option value="1" {{($post->is_feature)?'selected':""}}>是</option>
                </select>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary btn-sm">儲存</button>
            </div>
        </form>
    </div>
@endsection
