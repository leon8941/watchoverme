<?php

namespace App\Http\Controllers;

use App\Posts;
use Illuminate\Http\Request;

use App\Http\Requests;
use SEO;
use Sitemap;
use OpenGraph;
use SEOMeta;


class PostsController extends Controller
{
    //
    public function show($slug)
    {

        $post = Posts::where('slug',$slug)
            ->firstOrFail();

        //SEO::setTitle($post->title);
        //SEO::setDescription($post->description);
        //SEO::opengraph()->setUrl('http://watchoverme.com.br/posts/' . $post->slug);
        //SEO::setCanonical('https://codecasts.com.br/lesson');
        //SEO::opengraph()->addProperty('type', 'articles');

        SEOMeta::setTitle($post->title);
        SEOMeta::setDescription($post->description . ' - Notícias OverWatch - O Verme');
        SEOMeta::setCanonical('http://watchoverme.com.br/posts/' . $post->slug);
        SEOMeta::addMeta('article:published_time', $post->created_at->toW3CString(), 'property');
        //SEOMeta::addMeta('article:section', $post->category, 'property');
        //SEOMeta::addKeyword(['key1', 'key2', 'key3']);

        OpenGraph::setDescription($post->description);
        OpenGraph::setTitle($post->title);
        OpenGraph::setUrl('http://www.watchoverme.com.br/posts/' . $post->slug);
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'pt-br');
        OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);

        OpenGraph::addImage(getPostImage($post->image));

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
