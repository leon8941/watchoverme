<?php

namespace App\Http\Controllers;

use App\Posts;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use SEO;
use Sitemap;
use OpenGraph;
use SEOMeta;

class UsersController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function show($slug)
    {
        $user = User::where('slug',$slug)
            ->first();

        SEO::setTitle($user->name, ' | ' . 'Watch OVerme');
        SEO::setDescription('Jogador brasileiro de Overwatch ' . $user->name );
        //SEO::opengraph()->setUrl('http://watchoverme.com.br/users/' . $user->slug);
        //SEO::setCanonical('https://codecasts.com.br/lesson');
        //SEO::opengraph()->addProperty('type', 'articles');

        // TODO: adicionar o nome do gamer?
        SEOMeta::setTitle($user->name);
        SEOMeta::setDescription('Perfil do Verme de Overwatch ' . $user->name);
        SEOMeta::setCanonical('http://watchoverme.com.br/users/' . $user->slug);
        //SEOMeta::addMeta('article:published_time', $post->created_at->toW3CString(), 'property');
        //SEOMeta::addMeta('article:section', $post->category, 'property');
        SEOMeta::addKeyword([$user->slug, $user->name]);

        OpenGraph::setDescription($user->name . ' Perfil de Jogador - NerfThis ');
        OpenGraph::setTitle($user->name);
        OpenGraph::setUrl('http://www.watchoverme.com.br/users/' . $user->slug);
        OpenGraph::addProperty('type', 'profile');
        OpenGraph::addProperty('locale', 'pt-br');
        OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);

        OpenGraph::addImage(getUserAvatar($user->avatar));

        if ($user->stats) {
            $stats['quick'] = $user->stats->where('mode','quick')->first();
            $stats['competitive'] = $user->stats->where('mode','competitive')->first();
        }
        else
            $stats = null;

        return view('users.show', compact('user', 'stats'));
    }

    /**
     * Show a page of user creation
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::lists('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Insert new user into the system
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        return redirect()->route('users.index')->withMessage(trans('quickadmin::admin.users-controller-successfully_created'));
    }

    /**
     * Show a user edit page
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::lists('title', 'id');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update our user information
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user->update($input);

        return redirect()->route('users.index')->withMessage(trans('quickadmin::admin.users-controller-successfully_updated'));
    }

    /**
     * Destroy specific user
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        User::destroy($id);

        return redirect()->route('users.index')->withMessage(trans('quickadmin::admin.users-controller-successfully_deleted'));
    }

    public function test()
    {
        $data['name'] = 'vic';
        $data['email'] = 'souto.victor@gmail.com';

        Mail::send('emails.users.register', [], function ($m) use ($data) {
            $m->from('staff@watchoverme.com.br', 'OVerme');

            $m->to($data['email'], $data['name'])->subject('Bem vindo Verme!');
        });

    }

    public function upload() {

        // getting all of the post data
        $file = array('image' => Input::file('image'));
        // setting up rules
        $rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000

        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);

        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return Redirect::back()->withInput()->withErrors($validator);
        }
        else {
            // checking file is valid.
            if (Input::file('image')->isValid()) {

                $destinationPath = 'uploads/users/'; // upload path
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111,99999).'.'.$extension; // renameing image

                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path

                User::where('id',Auth::user()->id)->update([
                    'avatar' => $fileName
                ]);

                // sending back with message
                Session::flash('success', 'Upload successfully');
                return Redirect::back();
            }
            else {
                // sending back with error message.
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::back();
            }
        }
    }

    /**
     * Get NerfThis colaborators
     *
     * @return mixed
     */
    public function getColaborators()
    {
        $users = User::colaborator()->get();

        foreach($users as $key => $user) {
            $users[$key]->artigos = Posts::where('user_id',$user->id)->count();
        }

        $users->sort();

        return Response::json($users);
    }
}