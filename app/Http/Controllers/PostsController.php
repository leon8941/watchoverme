<?php

namespace App\Http\Controllers;

use App\Posts;
use Illuminate\Http\Request;

use App\Http\Requests;

class PostsController extends Controller
{
    //
    public function show($id)
    {
        $post = Posts::where('id',$id)
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }
}
