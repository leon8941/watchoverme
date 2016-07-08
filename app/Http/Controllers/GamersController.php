<?php

namespace App\Http\Controllers;

use App\Gamer;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
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


class GamersController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */
    public function index()
    {

        // Define query
        $config = (new GridConfig())
            ->setName('Gamers')
            ->setDataProvider(
                new EloquentDataProvider(
                    (new Gamer())
                        ->newQuery()
                )
            )
            ->setPageSize(50)
            ->setColumns([
                //new FieldConfig('id'),
                (new FieldConfig('id'))
                    ->setLabel('Rank')
                    ->setCallback(function ($val) {

                        // Get the user rank position
                        if(Gamer::getRankingPosition($val) == 1)
                            return '<span class="glyphicon glyphicon-star-empty"></span> 1st';

                        if(Gamer::getRankingPosition($val) == 2 )
                            return '<span class="glyphicon glyphicon-star"></span> 2nd';

                        if(Gamer::getRankingPosition($val) == 3 )
                            return '<span class="glyphicon glyphicon-star"></span> 3rd';

                        return Gamer::getRankingPosition($val);
                    }),
                (new FieldConfig('battletag'))
                    ->addFilter(getFilterILike('email'))
                    ->setSortable(true)
                    ->setCallback(function ($val) {

                        if (!empty($val))
                            return $val . ' <a href="mailto:'.$val.'"><i class="fa fa-envelope-o"></i></a> ';
                    }),
                (new FieldConfig('points'))
                    ->setLabel('Pontos'),

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
