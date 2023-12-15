<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(User $user)
    {
        $user = User::where('id',auth()->user()->id)->first();
        $data = ['user' => $user];
        return view('users.index',$data);
    }

    public function update(Request $request, User $user)
    {
//        $this->validate($request,[
//            'title' => 'required|max:50',
//            'content' => 'required',
//            'is_feature' => 'required|boolean',
//        ]);

        $user->update($request->all());
        return redirect()->route('users.index');
    }
}
