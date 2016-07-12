<?php

namespace App\Http\Controllers;

use App\Gamer;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
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


class GamersController extends Controller
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
            $query = (new Gamer())
                ->newQuery()
                ->orderBy('competitive_rank','DESC');
        }
        else {
            // Define Query
            $query = (new Gamer())
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

    /**
     * Activate a user as a player
     * Request player data through API, using battletag
     *
     * @return bool
     */
    public function activate()
    {
        $battletag = Input::get('battletag');

        $return = [
            'code' => '0',
            'success' => false,
            'msg'   => ''
        ];

        try {

            if (!strpos($battletag,'#')) {

                $return['msg'] = 'Certifique-se de digitar uma battletag válida. Exemplo: nome#9999 ';

                return $return;
            }

            // TODO: checar se já existe alguem com essa battletag.

            $explode_tag = explode('#',$battletag);

            // The API requests a battle tag as name-9999 , not name#9999
            $filtered_tag = $explode_tag[0] . '-' . $explode_tag[1];

            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => 'https://api.lootbox.eu/',
                // You can set any number of default request options.
                'timeout'  => 999,
            ]);

            // Send a request to https://foo.com/api/test
            $response = $client->request('GET', "pc/us/$filtered_tag/profile");

            // Decode response body
            $obj = json_decode($response->getBody());

        }
        catch (\Exception $e) {

            $return['code'] = $e->getCode();
            $return['msg'] = 'Erro ao buscar battletag.';

            return $return;
        }

        // No user returned?
        if (!isset($obj->data)) {
            $return['msg'] = 'Nenhum usuário encontrado.';
            return $return;
        }

        // If have a username, its a succesfull transaction
        if ($obj->data->username && !empty($obj->data->username)) {

            $gamer = Gamer::where('user_id',Auth::user()->id)
                ->first();

            if ($gamer) {
                $gamer->level = $obj->data->level;
                $gamer->quick_wins = $obj->data->games->quick->wins;
                $gamer->quick_lost = $obj->data->games->quick->lost;
                $gamer->quick_played = $obj->data->games->quick->played;
                $gamer->competitive_wins = $obj->data->games->competitive->wins;
                $gamer->competitive_lost = $obj->data->games->competitive->lost;
                $gamer->competitive_played = $obj->data->games->competitive->played;
                $gamer->competitive_playtime = $obj->data->playtime->competitive;
                $gamer->quick_playtime = $obj->data->playtime->quick;
                $gamer->avatar = $obj->data->avatar;
                $gamer->competitive_rank = $obj->data->competitive->rank;
                $gamer->competitive_rank_img = $obj->data->competitive->rank_img;

                $gamer->save();
            }
            else {
                // Fields that may come null
                $rank = isset($obj->data->competitive->rank)? $obj->data->competitive->rank: '';
                $rank_img = isset($obj->data->competitive->rank_img)? $obj->data->competitive->rank_img: '';

                $gamer = Gamer::create([
                    'battletag' => $battletag,
                    'username' => $obj->data->username,
                    'level' => $obj->data->level,
                    'quick_wins' => $obj->data->games->quick->wins,
                    'quick_lost' => $obj->data->games->quick->lost,
                    'quick_played' => $obj->data->games->quick->played,
                    'competitive_wins' => $obj->data->games->competitive->wins,
                    'competitive_lost' => $obj->data->games->competitive->lost,
                    'competitive_played' => $obj->data->games->competitive->played,
                    'competitive_playtime' => $obj->data->playtime->competitive,
                    'quick_playtime' => $obj->data->playtime->quick,
                    'avatar' => $obj->data->avatar,
                    'competitive_rank' => $rank,
                    'competitive_rank_img' => $rank_img,
                    'user_id' => Auth::user()->id
                ]);
            }

            $return['code'] = '1';
            $return['success'] = true;

            return Response::json($return);
        }
        else {
            $possible_responses = [
                '404' => 'User not found'
            ];

            return Response::json( $possible_responses[$obj->statusCode] );
        }

        return Response::json(false);
    }

    /*
     * How the obj returns from API
     *
     * stdClass Object
    (
    [data] => stdClass Object
        (
            [username] => kzz
            [level] => 78
            [games] => stdClass Object
                (
                    [quick] => stdClass Object
                        (
                            [wins] => 207
                            [lost] => 185
                            [played] => 392
                        )

                    [competitive] => stdClass Object
                        (
                            [wins] => 54
                            [lost] => 55
                            [played] => 109
                        )

                )

            [playtime] => stdClass Object
                (
                    [quick] => 49 hours
                    [competitive] => 21 hours
                )

            [avatar] => https://blzgdapipro-a.akamaihd.net/game/unlocks/0x025000000000054C.png
            [competitive] => stdClass Object
                (
                    [rank] => 49
                    [rank_img] => https://blzgdapipro-a.akamaihd.net/game/rank-icons/rank-5.png
                )

        )

    )

     */
}
