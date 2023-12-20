@extends('admins.layouts.master')

@section('page-title', 'Article list')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">用戶資料管理</h1>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('admins.users.create') }}">新增用戶</a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" style="text-align:left">帳號</th>
                <th scope="col" style="text-align:left">姓名</th>
                <th scope="col" style="text-align:left">性別</th>
                <th scope="col" style="text-align:left">電子信箱</th>
                <th scope="col" style="text-align:left">身份</th>
                <th scope="col" style="text-align:left">生日</th>
                <th scope="col" style="text-align:left">電話</th>
                <th scope="col" style="text-align:center">修改</th>
                <th scope="col" style="text-align:center">刪除</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td style="text-align:left">{{ $index + 1 }}</td>
                    <td>{{ $user->account }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->sex }}</td>
                    <td>{{ $user->email }}</td>
                    @if ($user->isadmin())
                        <td>
                            <div style="color:#FF0000;">
                                @if($user->admin->position == 1)
                                    超級管理員
                                @elseif($user->admin->position == 2)
                                    高階管理員
                                @else
                                    一般管理員
                                @endif
                            </div>
                        </td>
                    @elseif($user->isseller())
                        <td>賣家</td>
                    @else
                        <td>一般會員</td>
                    @endif
                    <td>{{ $user->birthday }}</td>
                    <td>{{ $user->phone }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('admins.users.edit',$user->id) }}" class="btn btn-secondary btn-sm">編輯</a>
                    </td>
                    <td style="text-align:center">
                        <form action="{{ route('admins.users.destroy',$user->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">刪除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="d-flex align-items-center">
                <span class="mr-1">每</span>
                <select id="records-per-page" class="form-control" onchange="changeRecordsPerPage()">
                    <option value="10" {{ $users->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $users->perPage() == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $users->perPage() == 50 ? 'selected' : '' }}>50</option>
                </select>
                <span class="ml-1">筆</span>
            </div>
        </div>
    </div>
    <script>
        function changeRecordsPerPage() {
            const select = document.getElementById('records-per-page');
            const value = select.options[select.selectedIndex].value;
            window.location.href = `{{ route('admins.users.index') }}?perPage=${value}`;
        }
    </script>
@endsection
