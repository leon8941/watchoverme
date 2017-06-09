<?php

namespace App\Http\Controllers;

use App\Event;
use App\Gamer;
use App\Market;
use App\Post;
use App\Posts;
use App\Subscriber;
use App\Team;
use App\User;
use App\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

use SEO;
use Sitemap;
use OpenGraph;
use SEOMeta;

class PagesController extends Controller
{

    public function home()
    {
        SEOMeta::setDescription('Cenário Competitivo de Overwatch, campeonatos, eventos, vídeos e tudo sobre a comunidade de Overwatch.');
        SEOMeta::setCanonical('http://nerfthis.com.br/');
        SEOMeta::addKeyword(['notícias', 'overwatch', 'nerfthis', 'campeonatos overwatch', 'ranking overwatch', 'ranking nacional']);

        OpenGraph::setDescription('Cenário Competitivo de Overwatch, campeonatos, eventos e vídeos e tudo sobre a comunidade de Overwatch.');
        OpenGraph::setUrl('http://www.nerfthis.com.br/');
        //OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'pt-br');
        OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);

        OpenGraph::addImage(asset('img/nerfthis.jpg'));

        Sitemap::addTag(route('home'), '', 'daily', '0.8');

        // Last Posts
        $posts = Posts::orderBy('created_at','DESC')
            ->take(8)
            ->get();

        // Last updated players
        $updated_players = Gamer::orderBy('updated_at', 'DESC')
            ->with('user')
            ->take(6)->get();

        // New registered users
        $new_registered_users = User::orderBy('created_at','DESC')
            ->take(8)->get();

        $date = new \DateTime();
        $date->modify('-30 days');
        $formatted_date = $date->format('Y-m-d H:i:s');

        // New users amount
        $count_new_users = User::where('created_at','>=',$formatted_date)->count();

        // Events later than today
        $events = Event::orderBy('starts','ASC')
            ->where('starts','>=', DB::raw('curdate()'))
            ->get();

        // Top 5 ranking
        $tops = Gamer::orderBy('competitive_rank', 'DESC')
            ->with('user')
            ->take(5)->get();

        $teams = Team::orderBy('points','DESC')->take(5)->get();

        $mercado = Market::orderBy('created_at','DESC')->take(15)->get();

        return view('pages.home',compact(
            'posts','updated_players','new_registered_users','count_new_users',
            'events','tops','teams','mercado'));
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

    public function about()
    {

        $news = Post::count();

        $users = User::count();

        $teams = Team::count();

        return view('pages.about', compact('teams', 'users', 'news'));
    }

    public function getStatsPlayers()
    {

        $players = Gamer::count();

        return Response::json($players);
    }

    public function getStatsTeams()
    {
        $teams = Team::count();

        return Response::json($teams);
    }

    public function getStatsUpdates()
    {
        $updates = Gamer::where('updated_at', '>=', Carbon::now()->subDays('7'))
            ->count();

        return Response::json($updates);
    }

    public function getStatsEvents()
    {
        $events = Event::count();

        return Response::json($events);
    }

    public function test($channel = false)
    {

        $channelsApi = 'https://api.twitch.tv/kraken/channels/';
        $channelName = $channel? $channel : 'wraxu';
        $clientId = 'h6b0lkg3c14e4h068thlrzy4sgp7t4';
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                'Client-ID: ' . $clientId
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $channelsApi . $channelName
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        $json = json_decode($response, TRUE);

        dd($json);
        exit;

    }
}
