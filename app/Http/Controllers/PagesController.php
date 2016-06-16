<?php

namespace App\Http\Controllers;

use App\Subscriber;
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
}
