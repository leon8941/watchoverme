<?php

namespace App\Http\Controllers;

use App\Category;
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

        SEOMeta::setTitle($post->title);
        SEOMeta::setDescription($post->description . ' - Notícias OverWatch - NerfThis');
        SEOMeta::setCanonical('http://nerfthis.com.br/posts/' . $post->slug);
        SEOMeta::addMeta('article:published_time', $post->created_at->toW3CString(), 'property');
        //SEOMeta::addMeta('article:section', $post->category, 'property');
        SEOMeta::addKeyword(['notícia', 'overwatch', $post->title,$post->slug, 'nerfthis', 'verme']);

        OpenGraph::setDescription($post->description);
        OpenGraph::setTitle($post->title);
        OpenGraph::setUrl('http://www.nerfthis.com.br/posts/' . $post->slug);
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'pt-br');
        OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);

        OpenGraph::addImage(getPostImage($post->image));

        Sitemap::addTag(route('posts.show', $post->slug), $post->updated_at, 'daily', '0.8');

        return view('posts.show', compact('post'));
    }

    public function index()
    {
        SEOMeta::setTitle('Notícias');
        SEOMeta::setDescription('Notícias de Overwatch, tudo sobre os campeonatos e rankings, eventos e vídeos. - NerfThis');
        SEOMeta::setCanonical('http://nerfthis.com.br/posts/');
        //SEOMeta::addMeta('article:published_time', $post->created_at->toW3CString(), 'property');
        //SEOMeta::addMeta('article:section', $post->category, 'property');
        SEOMeta::addKeyword(['noticias', 'overwatch', 'nerfthis', 'videos', 'jogadas', 'comics', 'notícias overwatch']);

        OpenGraph::setDescription('Notícias de Overwatch, tudo sobre os campeonatos e rankings, eventos e vídeos. - NerfThis');
        OpenGraph::setTitle('Notícias de OverWatch - NerfThis');
        OpenGraph::setUrl('http://www.nerfthis.com.br/posts/');
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'pt-br');
        OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);

        OpenGraph::addImage(asset('img/o-verme-jim.jpg'));

        Sitemap::addTag(route('posts.index'), '', 'daily', '0.8');

        $posts = Posts::orderBy('created_at',"DESC")
            ->get();

        $categories = Category::getList();

        return view('posts.index',compact('posts','categories'));
    }
}
