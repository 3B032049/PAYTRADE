@extends('layouts.master')

@section('title','登入')

@section('content')
<section id="location">
    <div class="wrapper">
        <table align="center" border="1">
            <form  method=post action=login.php>
            <td>
                使用者帳號:<input type=text name=account placeholder=請輸入您的帳號 required><br>
                使用者密碼:<input type=password name=password placeholder=請輸入您的密碼 required>
                <br>
                <input type=submit name=button value=使用者登入>
            </form> 
            <form  method=post action=register.php>
                還沒有帳號點擊這邊註冊<input type=submit name=button value=註冊>
            </form> 
            <form  method=post action=contact.php>
                <input type=submit name=button value=忘記密碼>
            </form>
            </td>
        </table> 
    </div>
</section>
@endsection