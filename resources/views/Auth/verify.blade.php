@extends('layouts.master')

@section('title','驗證信箱')

@section('content')
    <hr>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('驗證您的電子信箱') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('驗證連結已發送至您的信箱!') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('如果未收到信箱') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('再次寄送') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
