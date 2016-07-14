<?php

namespace App\Http\Controllers;

use App\Posts;
use Illuminate\Http\Request;

use App\Http\Requests;
use SEO;
use Sitemap;

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

        Sitemap::addTag(route('posts.show', $post->slug), $post->updated_at, 'daily', '0.8');

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

        Sitemap::addTag(route('posts.index'), '', 'daily', '0.8');

        return view('posts.index',compact('posts'));
    }
}
