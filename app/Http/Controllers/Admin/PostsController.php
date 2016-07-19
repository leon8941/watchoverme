<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Posts;
use App\Http\Requests\CreatePostsRequest;
use App\Http\Requests\UpdatePostsRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\User;


class PostsController extends Controller {

	/**
	 * Display a listing of posts
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $posts = Posts::with("user")
			->orderBy('created_at','DESC')
			->get();

		return view('admin.posts.index', compact('posts'));
	}

	/**
	 * Show the form for creating a new posts
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $user = User::lists("id", "id")->prepend('Please select', '');

	    
	    return view('admin.posts.create', compact("user"));
	}

	/**
	 * Store a newly created posts in storage.
	 *
     * @param CreatePostsRequest|Request $request
	 */
	public function store(CreatePostsRequest $request)
	{
	    $request = $this->saveFiles($request);
		Posts::create($request->all());

		return redirect()->route('admin.posts.index');
	}

	/**
	 * Show the form for editing the specified posts.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$posts = Posts::find($id);
	    $user = User::lists("id", "id")->prepend('Please select', '');

	    
		return view('admin.posts.edit', compact('posts', "user"));
	}

	/**
	 * Update the specified posts in storage.
     * @param UpdatePostsRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdatePostsRequest $request)
	{
		$posts = Posts::findOrFail($id);

        $request = $this->saveFiles($request);

		$posts->update($request->all());

		return redirect()->route('admin.posts.index');
	}

	/**
	 * Remove the specified posts from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Posts::destroy($id);

		return redirect()->route('admin.posts.index');
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
            Posts::destroy($toDelete);
        } else {
            Posts::whereNotNull('id')->delete();
        }

        return redirect()->route('admin.posts.index');
    }

}
