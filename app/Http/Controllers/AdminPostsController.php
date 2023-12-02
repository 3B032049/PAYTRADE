<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class AdminPostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at','DESC')->get();
        $data = ['posts' => $posts];
        return view('admins.posts.index',$data);
    }

    public function create()
    {
        return view('admins.posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'posts_title' => 'required|max:50',
            'posts_content' => 'required',
            'is_feature' => 'required|boolean',
        ]);

        Post::create($request->all());
        return redirect()->route('admins.posts.index');
    }

    public function edit(Post $post)
    {
        $data = [
            'post'=> $post,
        ];
        return view('admins.posts.edit',$data);
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request,[
            'posts_title' => 'required|max:50',
            'posts_content' => 'required',
            'is_feature' => 'required|boolean',

        ]);

        $post->update($request->all());
        return redirect()->route('admins.posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admins.posts.index');
    }
}
