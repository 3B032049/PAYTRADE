<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    public function index()
    {
        $users = User::orderby('id','ASC')->get();
        $data = ['users' => $users];
        return view('admins.users.index',$data);
    }

    public function create()
    {
        return view('admins.users.create');
    }

    public function store(Request $request)
    {
//        $this->validate($request,[
//            'title' => 'required|max:50',
//            'content' => 'required',
//            'is_feature' => 'required|boolean',
//        ]);

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
//        $this->validate($request,[
//            'title' => 'required|max:50',
//            'content' => 'required',
//            'is_feature' => 'required|boolean',
//        ]);

        $user->update($request->all());
        return redirect()->route('admins.users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admins.users.index');
    }
}
