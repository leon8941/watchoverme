<?php

namespace App\Http\Controllers;

use App\Event;
use App\Gamer;
use App\Post;
use App\Posts;
use App\Subscriber;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use SEO;
use Sitemap;

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

        // Last Posts
        $posts = Posts::orderBy('created_at','DESC')
            ->get();

        // Last updated players
        $updated_players = Gamer::orderBy('updated_at', 'DESC')
            ->with('user')
            ->take(6)->get();

        // New registered users
        $new_registered_users = User::orderBy('created_at','DESC')
            ->take(8)->get();

        $date = new \DateTime();
        $date->modify('-6 days');
        $formatted_date = $date->format('Y-m-d H:i:s');

        // New users amount
        $count_new_users = User::where('created_at','>=',$formatted_date)->count();

        // Events later than today
        $events = Event::orderBy('starts','ASC')
            ->where('starts','>=', DB::raw('curdate()'))
            ->get();

        return view('pages.home',compact('posts','updated_players','new_registered_users','count_new_users','events'));
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

    public function sitemap()
    {
        // Get a general sitemap.
        Sitemap::addSitemap('/sitemap');

        // You can use the route helpers too.
        //Sitemap::addSitemap(URL::route('sitemap.posts'));
        //Sitemap::addSitemap(route('sitemaps.users'));

        // Return the sitemap to the client.
        return Sitemap::index();
    }

}
