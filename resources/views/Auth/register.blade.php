@extends('layouts.master')

@section('title','註冊頁面')

@section('content')
    <hr>
    <section id="location">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('會員註冊') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="account" class="col-md-4 col-form-label text-md-end">{{ __('帳號 / Account') }}</label>
                                    <div class="col-md-6">
                                        <input id="account" type="text" class="form-control @error('account') is-invalid @enderror" name="account" value="{{ old('account') }}" required autocomplete="account" autofocus>

                                        @error('account')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('密碼 / Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('確認密碼 / Confirm') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('姓名 / Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="sex" class="col-md-4 col-form-label text-md-end">{{ __('性別 / Gender') }}</label>

                                    <div class="col-md-6">
                                        男<input id="sex" type="radio" name="sex" value="{{ '男' }}" required autocomplete="sex" checked="checked">
                                        女<input id="sex" type="radio" name="sex" value="{{ '女' }}" required autocomplete="sex" >
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('電子信箱 / Email') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="birthday" class="col-md-4 col-form-label text-md-end">{{ __('生日 / Birthday') }}</label>
                                    <div class="col-md-6">
                                        <input id="birthday" type="date" class="form-control" name="birthday" value="{{ old('birthday') }}" required autocomplete="birthday">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('手機號碼 / phone') }}</label>
                                    <div class="col-md-6">
                                        <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('地址 / Address') }}</label>
                                    <div class="col-md-6">
                                        <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" >
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('註冊') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
