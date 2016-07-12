<?php

namespace App\Http\Controllers;

use App\Post;
use App\Subscriber;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use SEO;

class PagesController extends Controller
{
    //

    public function home()
    {
        SEO::setTitle('Notícias');
        SEO::setDescription('Últimas notícias de Overwatch, campeonatos, eventos e vídeos.');
        SEO::opengraph()->setUrl('http://watchoverme.com.br');
        //SEO::setCanonical('https://codecasts.com.br/lesson');
        SEO::opengraph()->addProperty('type', 'articles');

        $posts = Post::orderBy('created_at','DESC')
            ->get();

        return view('pages.home',compact('posts'));
    }


    public function soon()
    {
        return view('pages.coming-soon');
    }


    public function subscribe()
    {
        $data = Input::all();

        if (!empty($data['email'])) {

            Subscriber::create([
                'email' => $data['email']
            ]);

            return Response::json(true);
        }

        return Response::json(false);
    }

}
