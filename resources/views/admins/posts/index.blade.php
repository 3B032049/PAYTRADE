@extends('admins.layouts.master')

@section('page-title', 'Article list')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">公告管理</h1>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('admins.posts.create') }}">新增</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:center">標題</th>
                <th scope="col" style="text-align:center">內容</th>
                <th scope="col" style="text-align:center">公告時間</th>
                <th scope="col">功能</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td style="text-align:center">{{ $post->posts_title }}</td>
                    <td style="text-align:center">{{$post->posts_content}}</td>
                    <td style="text-align:center">{{$post->created_at}}</td>
                    <td style="text-align:center">
                        <a href="{{ route('admins.posts.edit',$post->id) }}" class="btn btn-primary btn-sm">編輯</a>
                        <form action="{{ route('admins.posts.destroy',$post->id) }}" method="POST">
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
