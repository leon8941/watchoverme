<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Events\MessagePublished;
use App\Message as MessageModel;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Events\Dispatcher;

class Message extends Controller
{
    private $messages;

    public function __construct(MessageModel $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Display last 20 messages
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->messages->orderBy('id', 'desc')->take(20)->get()->reverse();
    }

    /**
     * Store a newly created message
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Dispatcher $event)
    {
	
	
        $message = $this->messages->create($request->input());

		if($message->message == 'opa') {
		
			$new_message = $message = $this->messages->create(['username' => 'vsouto', 'message' => 'puta merdaaaaaa']);
			$event->fire(new MessagePublished($new_message));
		}
		
        $event->fire(new MessagePublished($message));

        return response($message, 201);
    }
}
