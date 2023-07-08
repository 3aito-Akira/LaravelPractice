<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;

class PostController extends Controller
{
    public function create(){
        return view('post.create');
    }

    public function store(Request $request){
        Gate::authorize('test');
        $validated = $request->validate(['title' => 'required | max:20','body' => 'required | max:400']); 
        
        $validated['user_id'] = auth()->id();

        $post = Post::create($validated);
        
        session()->flash('message','body was successfully stored');

        return back();
    }

    public function index(){
        $posts=post::where('user_id',auth()->id())->get();
        return view('post.index',compact('posts'));
    }

    public function show(Post $post){
        return view('post.show',compact('post'));
    }

    public function update(Request $request, Post $post){
        $validated = $request->validate(['title' => 'required | max:20','body' => 'required | max:400']); 
        
        $validated['user_id'] = auth()->id();

        $post->update($validated);

        session()->flash('message','body was successfully updated');

        return back();
    }
}
