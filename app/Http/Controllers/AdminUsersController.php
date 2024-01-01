<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Seller;

class AdminUsersController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10); // Default: 10 records per page
        $users = User::orderBy('id', 'ASC')->paginate($perPage);
        $data = ['users' => $users];
        return view('admins.users.index',$data);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 10);
        // 搜尋會員資料
        $users = User::where('email', 'like', "%$query%")
            ->orWhere('name', 'like', '%' . $query . '%')
            ->orWhere('sex', 'like', '%' . $query . '%')
            ->orWhere('phone', 'like', '%' . $query . '%')
            ->paginate($perPage);

        // 返回結果
        return view('admins.users.index', [
            'users' => $users,
            'query' => $query,
        ]);
    }

    public function create()
    {
        return view('admins.users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'sex' => 'required',
            'birthday' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        User::create($request->all());
        return redirect()->route('admins.users.index');
    }

    public function edit(User $user)
    {
        $data = [
            'user'=> $user,
        ];
        return view('admins.users.edit',$data);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id, // 判段多個行列
            'password' => 'required',
            'sex' => 'required',
            'birthday' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $user->update($request->all());
        return redirect()->route('admins.users.index');
    }

    public function destroy(User $user)
    {
        # 檢測該使用者使否在Admin或Seller資料表內有資料
        $admin = Admin::where('user_id', $user->id)->first();
        $seller = Seller::where('user_id', $user->id)->first();

        # 若有的話一同刪除
        if ($admin) {
            $admin->delete();
        }
        if ($seller) {
            $seller->delete();
        }

        $user->delete();
        return redirect()->route('admins.users.index');
    }
}
