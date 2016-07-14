<?php

namespace App\Http\Controllers;

use App\Posts;
use App\Team;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\URL;
use Sitemap;

class SitemapsController extends Controller
{

    public function index()
    {
        // Get a general sitemap.
        Sitemap::addSitemap('/sitemaps/general');

        // You can use the route helpers too.
        Sitemap::addSitemap(URL::route('sitemaps.posts'));
        Sitemap::addSitemap(route('sitemaps.users'));
        Sitemap::addSitemap(route('sitemaps.teams'));

        // Return the sitemap to the client.
        return Sitemap::index();
    }

    public function posts()
    {
        $posts = Posts::orderBy('created_at','DESC')->get();

        foreach ($posts as $post) {
            Sitemap::addTag(route('posts.show', $post->slug), $post->updated_at, 'daily', '0.8');
        }

        return Sitemap::render();
    }

    public function users()
    {
        $users = User::all();

        foreach ($users as $user) {
            Sitemap::addTag(route('users.show', $user->slug), $user->updated_at, 'daily', '0.8');
        }

        return Sitemap::render();
    }


    public function teams()
    {
        $teams = Team::all();

        foreach ($teams as $team) {
            Sitemap::addTag(route('teams.show', $team->slug), $team->updated_at, 'daily', '0.8');
        }

        return Sitemap::render();
    }
}
