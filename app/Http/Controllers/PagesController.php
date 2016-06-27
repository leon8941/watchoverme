<?php

namespace App\Http\Controllers;

use App\Subscriber;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class PagesController extends Controller
{
    //

    public function home()
    {
        return view('pages.home');
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

    public function consult()
    {

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.lootbox.eu/',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        //$client->setDefaultOption('verify', false);

        // Send a request to https://foo.com/api/test
        $response = $client->request('GET', 'pc/us/kzz-1722/profile');

        dd($response);
        /*$response = $client->request('GET', 'profile', [
            'query' => [
                'tag' => 'kzz-1722',
                'platform' => 'pc',
                'region' => 'us',
            ]
        ]);

        /*
        $ch = curl_init();

        $url = "https://api.lootbox.eu/pc/us/kzz-1722/profile";

        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        curl_close($ch);

        dd($response);
*/
    }
}
