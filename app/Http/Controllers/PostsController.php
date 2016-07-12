<?php

namespace App\Http\Controllers;

use App\Posts;
use Illuminate\Http\Request;

use App\Http\Requests;
use SEO;

class PostsController extends Controller
{
    //
    public function show($slug)
    {

        $post = Posts::where('slug',$slug)
            ->firstOrFail();

        SEO::setTitle($post->title);
        SEO::setDescription($post->description);
        SEO::opengraph()->setUrl('http://watchoverme.com.br/events');
        //SEO::setCanonical('https://codecasts.com.br/lesson');
        SEO::opengraph()->addProperty('type', 'articles');

        return view('posts.show', compact('post'));
    }

    public function index()
    {
        SEO::setTitle('Notícias');
        SEO::setDescription('Últimas notícias de Overwatch, campeonatos, eventos e vídeos.');
        SEO::opengraph()->setUrl('http://watchoverme.com.br');
        //SEO::setCanonical('https://codecasts.com.br/lesson');
        SEO::opengraph()->addProperty('type', 'articles');

        $posts = Posts::orderBy('created_at','DESC')
            ->get();

        return view('posts.index',compact('posts'));
    }
}
