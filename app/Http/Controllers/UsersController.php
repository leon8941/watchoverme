<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Define query
        $config = (new GridConfig())
            ->setName('Users')
            ->setDataProvider(
                new EloquentDataProvider(
                    (new User())
                        ->newQuery()
                )
            )
            ->setPageSize($view_amount)
            ->setColumns([
                new FieldConfig('id'),
                $this->getActionColumn(),
                (new FieldConfig('name'))
                    ->addFilter(getFilterILike('name'))
                    ->setSortable(true)
                ,
                (new FieldConfig('staff'))
                    ->setLabel('is RH?')
                    ->setCallback(function ($val) {

                        if($val)
                            return '<span class="glyphicon glyphicon-registration-mark"></span>';

                        return '';
                    }),
                (new FieldConfig('level'))
                    ->setSortable(true),
                (new FieldConfig('phone'))
                    ->setSortable(true)
                    ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {
                        if (!$val)
                            return '';

                        if (!empty($val))
                            return $val . ' <a href="tel:'.$val.'"><i class="fa fa-phone"></i></a> ';
                    })
                ,
                (new FieldConfig('email'))
                    ->addFilter(getFilterILike('email'))
                    ->setSortable(true)
                    ->setCallback(function ($val) {

                        if (!empty($val))
                            return $val . ' <a href="mailto:'.$val.'"><i class="fa fa-envelope-o"></i></a> ';
                    }),
                (new FieldConfig('points'))
                    ->setLabel('Pontos'),
                (new FieldConfig('id'))
                    ->setLabel('Rank')
                    ->setCallback(function ($val) {

                        // Get the user rank position
                        if(User::getRankingPosition($val) == 1)
                            return '<span class="glyphicon glyphicon-star-empty"></span> 1st';

                        if(User::getRankingPosition($val) == 2 )
                            return '<span class="glyphicon glyphicon-star"></span> 2nd';

                        if(User::getRankingPosition($val) == 3 )
                            return '<span class="glyphicon glyphicon-star"></span> 3rd';

                        return User::getRankingPosition($val);
                    }),
            ])
            ->setComponents([
                (new THead)
                    ->getComponentByName(FiltersRow::NAME)
                    ->setComponents([
                        (new RecordsPerPage)
                            ->setVariants([
                                50,
                                100,
                                200
                            ])
                            ->setRenderSection('filters_row_column_level')
                        ,
                        (new HtmlTag)
                            ->setTagName('button')
                            ->setAttributes([
                                'type' => 'submit',
                                'class' => 'btn btn-success btn-small'
                            ])
                            ->addComponent(new RenderFunc(function() {
                                return '<i class="glyphicon glyphicon-refresh"></i> Filter';
                            }))
                            ->setRenderSection('filters_row_column_level'),
                        (new HtmlTag)
                            ->setContent(' <i class="fa fa-home"></i> Default ')
                            ->setTagName('config')
                            ->setRenderSection(RenderableRegistry::SECTION_BEFORE)
                            ->setAttributes([
                                'class' => 'btn btn-default btn-sm',
                                'id'    => 'show-clean'
                            ]),
                        (new HtmlTag)
                            ->setContent(' <i class="fa fa-arrows-alt"></i> All ')
                            ->setTagName('span')
                            ->setRenderSection(RenderableRegistry::SECTION_BEFORE)
                            ->setAttributes([
                                'class' => 'btn btn-warning btn-sm',
                                'id'    => 'show-all'
                            ])
                    ])
                    ->getParent()
                ,
                new TFoot
            ]);

        $grid = (new Grid($config))->render();

        return view('users.index', compact('users'));
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


}