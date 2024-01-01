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
        $admins = DB::table('admins')
            ->join('users', 'admins.user_id', '=', 'users.id')
            ->where('users.name', 'like', "%$query%")
            ->orderBy('admins.id', 'ASC')
            ->paginate($perPage);

        // 返回結果
        return view('admins.admins.index', [
            'admins' => $admins,
            'query' => $query,
        ]);
    }

    public function create()
    {
        $users = User::orderBy('id','ASC')->get();
        $data = ['users' => $users];
        return view('admins.admins.create',$data);

    }

    public function create_selcted($user)
    {
        //$users = User::doesntHave('admins')->orderBy('id', 'ASC')->get();
        $users = User::orderBy('id','ASC')->get();
        $user = User::where('id',$user)->first();
        $data = ['users' => $users,
            'user' => $user,

        ];
        return view('admins.admins.create_selected',$data);
    }

    public function store(Request $request)
    {
//        $this->validate($request,[
//            'title' => 'required|max:50',
//            'content' => 'required',
//            'is_feature' => 'required|boolean',
//        ]);

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
//        $this->validate($request,[
//            'title' => 'required|max:50',
//            'content' => 'required',
//            'is_feature' => 'required|boolean',
//        ]);

        $admin->update($request->all());
        return redirect()->route('admins.admins.index');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admins.admins.index');
    }
}
