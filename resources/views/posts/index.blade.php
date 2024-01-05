@extends('layouts.master')

@section('title','最新公告')

@section('page-path')
    <div>
        <p style="font-size: 1.2em;"><a href="{{ route('home') }}">首頁</a> > 最新公告</p>
    </div>
@endsection

@section('content')
    <section class="py-5">
        <div class="container">
            {{-- Display the overall title --}}
            <div class="text-center mb-4">
                <h2>最新公告</h2>
            </div>

            {{-- Display all posts --}}
            @if(count($posts) > 0)
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-6 mb-4 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a></h5>
                                    <p class="card-text"><small class="text-muted">發佈日期： {{ $post->created_at }}</small></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div align="center"><p>目前無公告</p></div>
            @endif
        </div>
    </section>
@endsection

