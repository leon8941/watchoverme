<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Events;
use App\Http\Requests\CreateEventsRequest;
use App\Http\Requests\UpdateEventsRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\User;


class EventsController extends Controller {

	/**
	 * Display a listing of events
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $events = Event::get();

		return view('admin.events.index', compact('events'));
	}

	/**
	 * Show the form for creating a new events
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $user = User::lists("id", "id")->prepend('Please select', '');

	    
	    return view('admin.events.create', compact("user"));
	}

	/**
	 * Store a newly created events in storage.
	 *
     * @param CreateEventsRequest|Request $request
	 */
	public function store(CreateEventsRequest $request)
	{
	    $request = $this->saveFiles($request);
		Event::create($request->all());

		return redirect()->route('admin.events.index');
	}

	/**
	 * Show the form for editing the specified events.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$events = Event::find($id);
	    $user = User::lists("id", "id")->prepend('Please select', '');

	    
		return view('admin.events.edit', compact('events', "user"));
	}

	/**
	 * Update the specified events in storage.
     * @param UpdateEventsRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateEventsRequest $request)
	{
		$events = Event::findOrFail($id);

        $request = $this->saveFiles($request);

		$events->update($request->all());

		return redirect()->route('admin.events.index');
	}

	/**
	 * Remove the specified events from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Event::destroy($id);

		return redirect()->route('admin.events.index');
	}

    /**
     * Mass delete function from index page
     * @param Request $request
     *
     * @return mixed
     */
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            Event::destroy($toDelete);
        } else {
			Event::whereNotNull('id')->delete();
        }

        return redirect()->route('admin.events.index');
    }

}
