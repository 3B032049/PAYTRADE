<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAdminsController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $admins = Admin::with('user')
            ->orderBy('id', 'ASC')
            ->paginate($perPage);
        $data = ['admins' => $admins];
        return view('admins.admins.index',$data);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 10);
        $admins = Admin::with('user')
            ->whereHas('user', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%");
            })
            ->orderBy('id', 'ASC')
            ->paginate($perPage);

        // 返回結果
        return view('admins.admins.index', [
            'admins' => $admins,
            'query' => $query,
        ]);
    }

    public function create()
    {
        $admins = Admin::pluck('user_id')->toArray();
        $users = User::whereNotIn('id',$admins)->orderBy('id','ASC')->get();
        $data = ['users' => $users];
        return view('admins.admins.create',$data);
    }

    public function create_selcted($user)
    {
        $admins = Admin::pluck('user_id')->toArray();
        $users = User::whereNotIn('id',$admins)->orderBy('id','ASC')->get();
        $user_selected = User::where('id',$user)->first();
        $data = [
            'users' => $users,
            'user_selected' => $user_selected,
        ];
        return view('admins.admins.create_selected',$data);
    }

    public function store(Request $request)
    {
        Admin::create($request->all());
        return redirect()->route('admins.admins.index');
    }

    public function store_level(Request $request)
    {
        $user_id = $request->input('user_id');
        $position = $request->input('position');

        Admin::create([
            'user_id' => $user_id,
            'position' => $position,
        ]);
        return redirect()->route('admins.admins.index');
    }


    public function edit(Admin $admin)
    {
        $data = [
            'admin'=> $admin,
        ];
        return view('admins.admins.edit',$data);
    }

    public function update(Request $request, Admin $admin)
    {
        $admin->update($request->all());
        return redirect()->route('admins.admins.index');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admins.admins.index');
    }
}
