<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use Illuminate\Http\Request;

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
        //$posts=post::where('user_id',auth()->id())->get();
        $posts=Post::paginate(5);
        return view('post.index',compact('posts'));
    }

    public function show(Post $post){
        return view('post.show',compact('post'));
    }

    public function edit(Post $post){
        return view('post.edit',compact('post'));
    }

    public function update(Request $request, Post $post){
        $validated = $request->validate(['title' => 'required | max:20','body' => 'required | max:400']); 
        
        $validated['user_id'] = auth()->id();

        $post->update($validated);

        session()->flash('message','body was successfully updated');

        return back();
    }

    public function destroy(Request $request, Post $post){
        $post->delete();
        session()->flash('message','The content was successfully deleted');
        return redirect()->route('post.index');
    }
}
