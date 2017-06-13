<?php

namespace App\Http\Controllers;

use App\Event;
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
use SEO;

class EventsController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        SEO::setTitle('Eventos');
        SEO::setDescription('Lista dos eventos de Overwatch, campeonatos, encontros, torneios, ligas.');
        SEO::opengraph()->setUrl('http://nerfthis.com.br/events');
        //SEO::setCanonical('https://codecasts.com.br/lesson');
        SEO::opengraph()->addProperty('type', 'articles');

        // If user didnt defined filters or order, define order
        if ($request->query->count() <= 0) {
            // Define Query
            $query = (new Event())
                ->newQuery()
                ->orderBy('starts','DESC');
        }
        else {
            // Define Query
            $query = (new Event())
                ->newQuery();
        }

        // Define query
        $config = (new GridConfig())
            ->setName('Gamers')
            ->setDataProvider(
                new EloquentDataProvider(
                    $query
                )
            )
            ->setPageSize(50)
            ->setColumns([
                (new FieldConfig('image'))
                    ->setLabel(' ')
                    ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                        $event = $row->getSrc();

                        return '<a href="'.$event->url.'">'.
                            '<img src="'.asset('uploads/'.$event->image).'" width="240px"></a>';
                    }),
                (new FieldConfig('title'))
                    ->addFilter(getFilterILike('title'))
                    ->setLabel('Evento')
                    ->setSortable(true)
                    ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                        return '<a href="'.$row->getSrc()->url.'">' . $val . ' <i class="fa fa-external-link"></i></a>';
                    }),
                (new FieldConfig('streamer'))
                    ->setSortable(true)
                    ->setLabel('Streamer')
                    ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                        return '<a href="'.$val.'"><i class="fa fa-caret-square-o-right"></i></a>';
                    }),
                (new FieldConfig('from'))
                    ->setSortable(true)
                    ->setLabel('Região'),
                (new FieldConfig('starts'))
                    ->setSortable(true)
                    ->setLabel('Início')
                    ->setCallback(function ($val) {
                        return date('d/m/Y',strtotime($val));
                    }),
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

        return view('events.index', compact('grid'));
    }

    public function get()
    {

        $events = Event::
            select('starts as start','title')
            ->get();

        return Response::json($events);
    }
}
