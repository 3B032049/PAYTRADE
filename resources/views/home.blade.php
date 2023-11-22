@extends('layouts.master')

@section('title','登入')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('個人資料') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('登入成功!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
