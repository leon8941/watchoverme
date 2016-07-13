<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;


class TeamsController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        // If user didnt defined filters or order, define order
        if ($request->query->count() <= 0) {
            // Define Query
            $query = (new Team())
                ->newQuery();
        }
        else {
            // Define Query
            $query = (new Team())
                ->newQuery();
        }

        // Define query
        $config = (new GridConfig())
            ->setName('Teams')
            ->setDataProvider(
                new EloquentDataProvider(
                    $query
                )
            )
            ->setPageSize(50)
            ->setColumns([
                (new FieldConfig('competitive_rank'))
                    ->setLabel('Rank')
                    ->setSortable(true)
                    ->setCallback(function ($val) {

                        if (!empty($val))
                            return $val ;
                    }),
                (new FieldConfig('battletag'))
                    ->addFilter(getFilterILike('battletag'))
                    ->setSortable(true)
                    ->setCallback(function ($val) {

                        $gamer = Gamer::where('battletag',$val)->first();

                        if (!$gamer->user)
                            return $val . ' (!)';

                        return '<a href="' . route('users.show',[$gamer->user->slug]) . '">' . $val . '</a>';
                    }),
                (new FieldConfig('competitive_wins'))
                    ->setSortable(true)
                    ->setLabel('Wins'),
                (new FieldConfig('competitive_lost'))
                    ->setSortable(true)
                    ->setLabel('Lost'),
                (new FieldConfig('competitive_played'))
                    ->setSortable(true)
                    ->setLabel('Played'),
                (new FieldConfig('updated_at'))
                    ->setLabel('Last Update')
                    ->setCallback(function ($val) {
                        return date('d/m/Y',strtotime($val));
                    })
            ])
            ->setComponents([
                (new THead())
                    ->getComponentByName(FiltersRow::NAME)
                    ->setComponents([
                        (new RecordsPerPage())
                            ->setVariants([
                                50,
                                100,
                                200
                            ])
                            ->setRenderSection('filters_row_column_level')
                        ,
                        (new HtmlTag())
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
                new TFoot()
            ]);

        $grid = (new Grid($config))->render();

        return view('users.index', compact('users','grid'));
    }
}
