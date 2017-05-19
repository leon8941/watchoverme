<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CategoriesController extends Controller
{
    //
    public function index($category)
    {
        var_dump($category);exit;
        SEOMeta::setTitle('Not�cias');
        SEOMeta::setDescription('Not�cias de Overwatch, tudo sobre os campeonatos e rankings, eventos e v�deos. - NerfThis');
        SEOMeta::setCanonical('http://watchoverme.com.br/posts/');
        //SEOMeta::addMeta('article:published_time', $post->created_at->toW3CString(), 'property');
        //SEOMeta::addMeta('article:section', $post->category, 'property');
        SEOMeta::addKeyword(['noticias', 'overwatch', 'o verme', 'videos', 'jogadas', 'comics', 'not�cias overwatch']);

        OpenGraph::setDescription('Not�cias de Overwatch, tudo sobre os campeonatos e rankings, eventos e v�deos. - NerfThis');
        OpenGraph::setTitle('Not�cias de OverWatch - NerfThis');
        OpenGraph::setUrl('http://www.watchoverme.com.br/posts/');
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
