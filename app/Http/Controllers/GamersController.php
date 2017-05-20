<?php

namespace App\Http\Controllers;

use App\Gamer;
use App\Stats;
use App\Team;
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

use SEO;

class GamersController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        // Requested to view all?
        $view_amount = $request->get('all')? '3000' : 30;
        //$view_amount = $request->get('all')? '3000' : config('verme.default_ranking_page_size');

        // If user didnt defined filters or order, define order
        if ($request->query->count() <= 0) {
            // Define Query
            $query = (new Gamer())
                ->newQuery()
                ->orderBy('competitive_rank','DESC');
        }
        else {
            // Checks if there is a sorting request
            if(isset($request->get('Gamers')['sort'])) {
                $sort_array = $request->get('Gamers')['sort'];
                reset($sort_array);
                $sort = key($sort_array);
                $order = $request->get('Gamers')['sort'][$sort];
            }
            else {
                $sort = 'competitive_rank';
                $order = 'DESC';
            }

            // Define Query
            $query = (new Gamer())
                ->newQuery()
                ->orderBy($sort,$order);
        }

        // Define query
        $config = (new GridConfig())
            ->setName('Gamers')
            ->setCachingTime(0)
            ->setDataProvider(
                new EloquentDataProvider(
                    $query
                )
            )
            ->setPageSize($view_amount)
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
                (new FieldConfig('team'))
                    ->setSortable(true)
                    ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                        if (!$row->getSrc()->user)
                            return '';

                        $user = User::where('id',$row->getSrc()->user->id)
                            ->with('team')
                            ->first();

                        if (!$user || $user->team->count() < 1)
                            return '';

                        $team = Team::where('id',$row->getSrc()->user->team->first()->id)->first();

                        return '<a href="' . route('teams.show',[$team->slug]) . '">' .
                                '<img src="'.getTeamAvatar($team->image).'" width="40px"> '. $team->title . '</a>';
                    }),
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

        SEO::setTitle('Ranking brasileiro de Overwatch | Watch OVerme');
        SEO::setDescription('Ranking nacional de OverWatch - Lista dos melhores jogadores brasileiros rankeados no Overwatch, Ranking Competitvo, Ranking Quick Match');
        SEO::opengraph()->setUrl('http://watchoverme.com.br/gamers');
        //SEO::setCanonical('https://codecasts.com.br/lesson');
        SEO::opengraph()->addProperty('type', 'articles');

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
                'base_uri' => 'http://ow-api.herokuapp.com',
                // You can set any number of default request options.
                'timeout'  => 60,
            ]);

            // Send a request to https://foo.com/api/test
            //$response = $client->request('GET', "profile/pc/us/kzz-1722");
            $response = $client->request('GET', "profile/pc/us/$filtered_tag");

            // Decode response body
            $obj = json_decode($response->getBody());

        }
        catch (\Exception $e) {

            $return['code'] = $e->getCode();
            $return['msg'] = 'Erro ao buscar battletag.';

            dd($return);
            return $return;
        }

        // No user returned?
        if (!$obj) {
            $return['msg'] = 'Nenhum usuário encontrado.';
            return $return;
        }

        // If have a username, its a succesfull transaction
        if ($obj->username && !empty($obj->username)) {

            $gamer = Gamer::where('user_id',Auth::user()->id)
                ->first();

            $quick_wins = isset($obj->games->quickplay->wins)? $obj->games->quickplay->wins : '';
            $quick_lost = isset($obj->games->quickplay->lost)? $obj->games->quickplay->lost : '';
            $quick_played = isset($obj->games->quickplay->played)? $obj->games->quickplay->played: '';
            $competitive_wins = isset($obj->games->competitive->wins)? $obj->games->competitive->wins: '';
            $competitive_lost = isset($obj->games->competitive->lost)? $obj->games->competitive->lost: '';
            $competitive_played = isset($obj->games->competitive->played)? $obj->games->competitive->played: '';
            $competitive_playtime = isset($obj->playtime->competitive)? $obj->playtime->competitive: '';
            $quick_playtime = isset($obj->playtime->quickplay)? $obj->playtime->quickplay: '';
            $avatar = isset($obj->competitive->rank_image)? $obj->competitive->rank_image: '';
            $competitive_rank = isset($obj->competitive->rank)? $obj->competitive->rank: '';
            $competitive_rank_img = isset($obj->competitive->rank_img)? $obj->competitive->rank_img: '';

            if ($gamer) {
                $gamer->level = $obj->level;
                $gamer->quick_wins = $quick_wins;
                $gamer->quick_lost = $quick_lost;
                $gamer->quick_played = $quick_played;
                $gamer->competitive_wins = $competitive_wins;
                $gamer->competitive_lost = $competitive_lost;
                $gamer->competitive_played = $competitive_played;
                $gamer->competitive_playtime = $competitive_playtime;
                $gamer->quick_playtime = $quick_playtime;
                $gamer->avatar = $avatar;
                $gamer->competitive_rank = $competitive_rank;
                $gamer->competitive_rank_img = $competitive_rank_img;

                $gamer->save();
            }
            else {

                $gamer = Gamer::create([
                    'battletag' => $battletag,
                    'username' => $obj->username,
                    'quick_playtime' => $quick_playtime,
                    'quick_wins' => $quick_wins,
                    'competitive_wins' => $competitive_wins,
                    'competitive_lost' => $competitive_lost,
                    'competitive_played' => $competitive_played,
                    'competitive_playtime' => $competitive_playtime,
                    'avatar' => $avatar,
                    'competitive_rank' => $competitive_rank,
                    'competitive_rank_img' => $competitive_rank_img,
                    'user_id' => Auth::user()->id
                ]);
            }

            // Get user general stats
            //$this->updateUserStats($filtered_tag, 'competitive');
            //$this->updateUserStats($filtered_tag, 'quick');

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

    /**
     * Activate a user as a player
     * Request player data through API, using battletag
     *
     * @return bool
     */
    public function activateOldAPI()
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
                'timeout'  => 60,
            ]);

            // Send a request to https://foo.com/api/test
            $response = $client->request('GET', "pc/us/$filtered_tag/profile");

            // Decode response body
            $obj = json_decode($response->getBody());

        }
        catch (\Exception $e) {

            $return['code'] = $e->getCode();
            $return['msg'] = 'Erro ao buscar battletag.';

            dd($return);
            return $return;
        }

        // No user returned?
        if (!isset($obj->data)) {
            $return['msg'] = 'Nenhum usuário encontrado.';
            return $return;
        }

        // If have a username, its a succesfull transaction
        if ($obj->username && !empty($obj->username)) {

            $gamer = Gamer::where('user_id',Auth::user()->id)
                ->first();

            $quick_wins = isset($obj->games->quick->wins)? $obj->games->quick->wins : '';
            $quick_lost = isset($obj->games->quick->lost)? $obj->games->quick->lost : '';
            $quick_played = isset($obj->games->quick->played)? $obj->games->quick->played: '';
            $competitive_wins = isset($obj->games->competitive->wins)? $obj->games->competitive->wins: '';
            $competitive_lost = isset($obj->games->competitive->lost)? $obj->games->competitive->lost: '';
            $competitive_played = isset($obj->games->competitive->played)? $obj->games->competitive->played: '';
            $competitive_playtime = isset($obj->games->competitive->playtime)? $obj->games->competitive->playtime: '';
            $quick_playtime = isset($obj->playtime->quick)? $obj->playtime->quick: '';
            $avatar = isset($obj->avatar)? $obj->avatar: '';
            $competitive_rank = isset($obj->competitive->rank)? $obj->competitive->rank: '';
            $competitive_rank_img = isset($obj->competitive->rank_img)? $obj->competitive->rank_img: '';

            if ($gamer) {
                $gamer->level = $obj->level;
                $gamer->quick_wins = $quick_wins;
                $gamer->quick_lost = $quick_lost;
                $gamer->quick_played = $quick_played;
                $gamer->competitive_wins = $competitive_wins;
                $gamer->competitive_lost = $competitive_lost;
                $gamer->competitive_played = $competitive_played;
                $gamer->competitive_playtime = $competitive_playtime;
                $gamer->quick_playtime = $quick_playtime;
                $gamer->avatar = $avatar;
                $gamer->competitive_rank = $competitive_rank;
                $gamer->competitive_rank_img = $competitive_rank_img;

                $gamer->save();
            }
            else {

                $gamer = Gamer::create([
                    'battletag' => $battletag,
                    'username' => $obj->username,
                    'level' => $obj->level,
                    'quick_wins' => $quick_wins,
                    'quick_lost' => $quick_lost,
                    'quick_played' => $quick_played,
                    'competitive_wins' => $competitive_wins,
                    'competitive_lost' => $competitive_lost,
                    'competitive_played' => $competitive_played,
                    'competitive_playtime' => $competitive_playtime,
                    'quick_playtime' => $quick_playtime,
                    'avatar' => $obj->avatar,
                    'competitive_rank' => $competitive_rank,
                    'competitive_rank_img' => $competitive_rank_img,
                    'user_id' => Auth::user()->id
                ]);
            }

            // Get user general stats
            $this->updateUserStats($filtered_tag, 'competitive');
            $this->updateUserStats($filtered_tag, 'quick');

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

    /**
     * Get general player stats
     * Make sure BATTLETAG is already validated
     *
     * @param $battletag
     */
    public function updateUserStats($battletag, $mode = 'competitive')
    {
        $return = [
            'code' => '0',
            'success' => false,
            'msg'   => ''
        ];

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.lootbox.eu/',
            // You can set any number of default request options.
            'timeout'  => 60,
        ]);

        // Send a request to https://foo.com/api/test
        $response = $client->request('GET', "pc/us/$battletag/$mode-play/allHeroes/");

        // Decode response body
        $obj = json_decode($response->getBody());

        $obj = $this->filterResponseFields($obj);

        $stats = Stats::where('user_id',Auth::user()->id)
            ->where('mode',$mode)
            ->first();

        if (!$stats) {
            $stats = Stats::create([
                'user_id' => Auth::user()->id,
                'mode' => $mode,
                "MeleeFinalBlows" => $obj['MeleeFinalBlows'],
                "SoloKills" => $obj['SoloKills'],
                "ObjectiveKills" => $obj['ObjectiveKills'],
                "FinalBlows" => $obj['FinalBlows'],
                "DamageDone" => $obj['DamageDone'],
                "Eliminations" => $obj['Eliminations'],
                "EnvironmentalKills" => isset($obj['EnvironmentalKills'])? $obj['EnvironmentalKills'] : '',
                "Multikills" => $obj['Multikills'],
                "HealingDone" => $obj['HealingDone'],
                "TeleporterPadsDestroyed" => isset($obj['TeleporterPadsDestroyed'])? $obj['TeleporterPadsDestroyed'] : '',
                "Eliminations_MostinGame" => $obj['Eliminations-MostinGame'],
                "FinalBlows_MostinGame" => $obj['FinalBlows-MostinGame'],
                "DamageDone_MostinGame" => $obj['DamageDone-MostinGame'],
                "HealingDone_MostinGame" => $obj['HealingDone-MostinGame'],
                "DefensiveAssists_MostinGame" => $obj['DefensiveAssists-MostinGame'],
                "OffensiveAssists_MostinGame" => $obj['OffensiveAssists-MostinGame'],
                "ObjectiveKills_MostinGame" => $obj['ObjectiveKills-MostinGame'],
                "ObjectiveTime_MostinGame" => $obj['ObjectiveTime-MostinGame'],
                "Multikill_Best" => $obj['Multikill-Best'],
                "SoloKills_MostinGame" => $obj['SoloKills-MostinGame'],
                "TimeSpentonFire_MostinGame" => $obj['TimeSpentonFire-MostinGame'],
                "MeleeFinalBlows_Average" => $obj['MeleeFinalBlows-Average'],
                "TimeSpentonFire_Average" => $obj['TimeSpentonFire-Average'],
                "SoloKills_Average" => $obj['SoloKills-Average'],
                "ObjectiveTime_Average" => $obj['ObjectiveTime-Average'],
                "ObjectiveKills_Average" => $obj['ObjectiveKills-Average'],
                "HealingDone_Average" => $obj['HealingDone-Average'],
                "FinalBlows_Average" => $obj['FinalBlows-Average'],
                "Deaths_Average" => $obj['Deaths-Average'],
                "DamageDone_Average" => $obj['DamageDone-Average'],
                "Eliminations_Average" => $obj['Eliminations-Average'],
                "Deaths" => $obj['Deaths'],
                "EnvironmentalDeaths" => $obj['EnvironmentalDeaths'],
                "Cards" => $obj['Cards'],
                "Medals" => $obj['Medals'],
                "Medals_Gold" => $obj['Medals-Gold'],
                "Medals_Silver" => $obj['Medals-Silver'],
                "Medals_Bronze" => $obj['Medals-Bronze'],
                "GamesWon" => $obj['GamesWon'],
                "GamesPlayed" => $obj['GamesPlayed'],
                "TimeSpentonFire" => $obj['TimeSpentonFire'],
                "ObjectiveTime" => $obj['ObjectiveTime'],
                "TimePlayed" => $obj['TimePlayed'],
                "MeleeFinalBlow_MostinGame" => $obj['MeleeFinalBlow-MostinGame'],
                "DefensiveAssists" => $obj['DefensiveAssists'],
                "DefensiveAssists_Average" => $obj['DefensiveAssists-Average'],
                "OffensiveAssists" => $obj['OffensiveAssists'],
                "OffensiveAssists_Average" => $obj['OffensiveAssists-Average'],
            ]);
        }
        else {
            $stats->MeleeFinalBlows = $obj['MeleeFinalBlows'];
            $stats->SoloKills = $obj['SoloKills'];
            $stats->ObjectiveKills = $obj['ObjectiveKills'];
            $stats->FinalBlows = $obj['FinalBlows'];
            $stats->DamageDone = $obj['DamageDone'];
            $stats->Eliminations = $obj['Eliminations'];
            $stats->EnvironmentalKills = isset($obj['EnvironmentalKills'])? $obj['EnvironmentalKills'] : '';
            $stats->Multikills = $obj['Multikills'];
            $stats->HealingDone = $obj['HealingDone'];
            $stats->TeleporterPadsDestroyed = isset($obj['TeleporterPadsDestroyed'])? $obj['TeleporterPadsDestroyed'] : '';
            $stats->Eliminations_MostinGame = $obj['Eliminations-MostinGame'];
            $stats->FinalBlows_MostinGame = $obj['FinalBlows-MostinGame'];
            $stats->DamageDone_MostinGame = $obj['DamageDone-MostinGame'];
            $stats->HealingDone_MostinGame = $obj['HealingDone-MostinGame'];
            $stats->DefensiveAssists_MostinGame = $obj['DefensiveAssists-MostinGame'];
            $stats->OffensiveAssists_MostinGame = $obj['OffensiveAssists-MostinGame'];
            $stats->ObjectiveKills_MostinGame = $obj['ObjectiveKills-MostinGame'];
            $stats->ObjectiveTime_MostinGame = $obj['ObjectiveTime-MostinGame'];
            $stats->Multikill_Best = $obj['Multikill-Best'];
            $stats->SoloKills_MostinGame = $obj['SoloKills-MostinGame'];
            $stats->TimeSpentonFire_MostinGame = $obj['TimeSpentonFire-MostinGame'];
            $stats->MeleeFinalBlows_Average = $obj['MeleeFinalBlows-Average'];
            $stats->TimeSpentonFire_Average = $obj['TimeSpentonFire-Average'];
            $stats->SoloKills_Average = $obj['SoloKills-Average'];
            $stats->ObjectiveTime_Average = $obj['ObjectiveTime-Average'];
            $stats->ObjectiveKills_Average = $obj['ObjectiveKills-Average'];
            $stats->HealingDone_Average = $obj['HealingDone-Average'];
            $stats->FinalBlows_Average = $obj['FinalBlows-Average'];
            $stats->Deaths_Average = $obj['Deaths-Average'];
            $stats->DamageDone_Average = $obj['DamageDone-Average'];
            $stats->Eliminations_Average = $obj['Eliminations-Average'];
            $stats->Deaths = $obj['Deaths'];
            $stats->EnvironmentalDeaths = $obj['EnvironmentalDeaths'];
            $stats->Cards = $obj['Cards'];
            $stats->Medals = $obj['Medals'];
            $stats->Medals_Gold = $obj['Medals-Gold'];
            $stats->Medals_Silver = $obj['Medals-Silver'];
            $stats->Medals_Bronze = $obj['Medals-Bronze'];
            $stats->GamesWon = $obj['GamesWon'];
            $stats->GamesPlayed = isset($obj['GamesPlayed'])? $obj['GamesPlayed'] : '';
            $stats->TimeSpentonFire = $obj['TimeSpentonFire'];
            $stats->ObjectiveTime = $obj['ObjectiveTime'];
            $stats->TimePlayed = $obj['TimePlayed'];
            $stats->MeleeFinalBlow_MostinGame = $obj['MeleeFinalBlow-MostinGame'];
            $stats->DefensiveAssists = $obj['DefensiveAssists'];
            $stats->DefensiveAssists_Average = $obj['DefensiveAssists-Average'];
            $stats->OffensiveAssists = $obj['OffensiveAssists'];
            $stats->OffensiveAssists_Average = $obj['OffensiveAssists-Average'];

            $stats->save();
        }

    }

    public function filterResponseFields($obj)
    {
        $result = [];

        foreach($obj as $key => $field) {
            if ($field == null)
                $result[$key] = '';
            else
                $result[$key] = $field;
        }

        // Exceptions
        $exceptions = [
            'MeleeFinalBlow-MostinGame'
        ];

        foreach ($exceptions as $exp) {

            if (!isset($result[$exp]))
                $result[$exp] = '';
        }

        return $result;
    }
}
