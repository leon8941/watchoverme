<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Categories;
use App\Http\Requests\CreateCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\User;


class CategoriesController extends Controller {

	/**
	 * Display a listing of categories
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $categories = Category::with("user")
			->orderBy('created_at','DESC')
			->get();

		return view('admin.categories.index', compact('categories'));
	}

	/**
	 * Show the form for creating a new categories
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $user = User::lists("id", "id")->prepend('Please select', '');

	    
	    return view('admin.categories.create', compact("user"));
	}

	/**
	 * Store a newly created categories in storage.
	 *
     * @param CreateCategoriesRequest|Request $request
	 */
	public function store(CreateCategoriesRequest $request)
	{
	    $request = $this->saveFiles($request);
		Category::create($request->all());

		return redirect()->route('admin.categories.index');
	}

	/**
	 * Show the form for editing the specified categories.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$categories = Category::find($id);
	    $user = User::lists("id", "id")->prepend('Please select', '');

	    
		return view('admin.categories.edit', compact('categories', "user"));
	}

	/**
	 * Update the specified categories in storage.
     * @param UpdateCategoriesRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateCategoriesRequest $request)
	{
		$categories = Category::findOrFail($id);

        $request = $this->saveFiles($request);

		$categories->update($request->all());

		return redirect()->route('admin.categories.index');
	}

	/**
	 * Remove the specified categories from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Category::destroy($id);

		return redirect()->route('admin.categories.index');
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
            Category::destroy($toDelete);
        } else {
            Category::whereNotNull('id')->delete();
        }

        return redirect()->route('admin.categories.index');
    }

}
