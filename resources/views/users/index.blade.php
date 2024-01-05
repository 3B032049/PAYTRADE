@extends('layouts.master')

@section('title','個人資料')
@section('page-path')
    <div>
        <p style="font-size: 1.2em;"><a href="{{ route('home') }}">首頁</a> > {{ $user->name }}</p>
    </div>
@endsection
@section('content')
    <section id="location">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('個人資料') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('users.update',$user->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

{{--                                <div class="row mb-3">--}}
{{--                                    <label class="col-md-4 col-form-label text-md-end">{{ __('帳號 / Account') }}</label>--}}
{{--                                    <div class="col-md-6">--}}
{{--                                        {{ $user->account }}--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="row mb-3">
                                    <label for="photo" class="col-md-4 col-form-label text-md-end">{{ __('個人頭像 / photo') }}</label>
                                    <div class="col-md-6">
                                        <label for="photo" class="form-label">頭像</label>
                                        <input id="photo" name="photo" type="file" class="form-control" onchange="previewImage(this);">
                                        <img id="image-preview" src="#" alt="圖片預覽" style="display: none; width:200px; height:200px;" >

                                        @if ($user->photo == 'head.jpg')
                                            <img class="card-img-top w-100 h-100 object-cover" src="images/head.jpg" alt="{{ htmlspecialchars($user->name) }}" />
                                        @else
                                            <img class="card-img-top w-100 h-100 object-cover" src="{{ asset('storage/user/' . $user->photo) }}" alt="{{ htmlspecialchars($user->name) }}" />
                                        @endif

                                        @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('姓名 / Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('信箱 / Email') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('性別 / Sex') }}</label>

                                    <div class="col-md-6">
                                        <div class="col-md-6">
                                            @if ($user->sex == '男')
                                                男<input id="sex" type="radio" name="sex" value="{{ '男' }}" required autocomplete="sex" checked="checked">
                                                女<input id="sex" type="radio" name="sex" value="{{ '女' }}" required autocomplete="sex">
                                            @else
                                                男<input id="sex" type="radio" name="sex" value="{{ '男' }}" required autocomplete="sex">
                                                女<input id="sex" type="radio" name="sex" value="{{ '女' }}" required autocomplete="sex" checked="checked">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="birthday" class="col-md-4 col-form-label text-md-end">{{ __('生日 / Birthday') }}</label>

                                    <div class="col-md-6">
                                        <input id="birthday" type="text" class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{ $user->birthday }}" required autocomplete="current-password">

                                        @error('birthday')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('電話 / Phone') }}</label>

                                    <div class="col-md-6">
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required autocomplete="current-password">

                                        @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('地址 / Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $user->address }}" required autocomplete="current-password">

                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="bank_branch" class="col-md-4 col-form-label text-md-end">{{ __('分行代碼 / bank_branch') }}</label>

                                    <div class="col-md-6">
                                        <input id="bank_branch" type="text" class="form-control @error('bank_branch') is-invalid @enderror" name="bank_branch" value="{{ $user->bank_branch }}" >

                                        @error('bank_branch')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('銀行帳號 / bank_account') }}</label>

                                    <div class="col-md-6">
                                        <input id=" bank_account" type="text" class="form-control @error(' bank_account') is-invalid @enderror" name=" bank_account" value="{{ $user-> bank_account }}" >

                                        @error(' bank_account')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('儲存') }}
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
    <script>
        function previewImage(input) {
            var preview = document.getElementById('image-preview');
            var file = input.files[0];
            var reader = new FileReader();
            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }
    </script>

@endsection
