<?php

namespace App\Http\Controllers;

use App\Fila;
use App\Gamer;
use App\Inhouser;
use App\Match;
use App\Message;
use App\Team;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use LaravelPusher;
use Vinkla\Pusher\Facades\Pusher;
use SEO;
use Sitemap;
use OpenGraph;
use SEOMeta;

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


class InhouseController extends Controller
{
    public function tests()
    {
        return view('inhouse.tests');
    }

    public function testGamer(Request $request, $gamer_id)
    {

        $gamer = Gamer::where('id',$gamer_id)
            ->with('inhouser')
            ->first();

        var_dump($gamer->inhouser->rating);exit;
    }

    public function getLowestPlayer($match_id)
    {
        $lowest = Match::getLowestPlayer($match_id);

        var_dump($lowest[0]->id);exit;

        //dd(DB::getQueryLog());
        //DB::enableQueryLog();
    }

    //
    public function index()
    {
        // Checks if user is inhouser, to update online time
        $isInhouser = Inhouser::isInhouser();

        $vouchs = 0;

        if ($isInhouser) {

            Inhouser::goOnline();

            $vouchs = Inhouser::getVouchs();
        }

        SEOMeta::setTitle('InHouse - NerfThis');
        SEOMeta::setDescription('Melhor sistema de ranking brasileiro de Overwatch no modo InHouse');
        SEOMeta::setCanonical('http://nerfthis.com.br/inhouse');
        SEOMeta::addKeyword(['inhouse', 'ranking', 'rating', 'campeonato','overwatch',
            'nerfthis', 'verme', 'campeonatos overwatch', 'ranking overwatch', 'ranking nacional']);

        $credentials['pusher_app_id'] = getenv('PUSHER_APP_ID');
        $credentials['pusher_key'] = getenv('PUSHER_KEY');
        $credentials['pusher_secret'] = getenv('PUSHER_SECRET');

        /*
        $partidas_abertas = Match::open()->get();

        $partidas_encerradas = Match::closed()->get();

        $partidas_andamento = Match::running()->get();

        $online_inhousers = Inhouser::online()
            ->with('gamer')
            ->get();
*/

        return view('inhouse.index', compact(
            'credentials',
            'isInhouser',
            'vouchs'
        ));
    }

    /**
     * InHouse Ranking view
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ranking(Request $request)
    {

        $query = (new Inhouser())
            ->newQuery()
            ->with('gamer')
            ->orderBy('rating','DESC');

        // Define query
        $config = (new GridConfig())
            ->setName('InHouse Ranking')
            ->setDataProvider(
                new EloquentDataProvider(
                    $query
                )
            )
            ->setPageSize(30)
            ->setColumns([
                (new FieldConfig('rating'))
                    ->setLabel('Rating')
                    ->setSortable(true)
                    ->setCallback(function ($val) {

                        if (!empty($val))
                            return $val ;
                    }),
                (new FieldConfig('gamer.battletag'))
                    ->addFilter(getFilterILike('battletag'))
                    ->setSortable(true)
                    ->setLabel('Jogador')
                    ->setCallback(function ($val) {

                        if (!empty($val))
                            return $val;
                            //return '<a href="' . route('users.show',[$gamer->user->slug]) . '">' . $val . '</a>';
                    }),
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

        return view('inhouse.ranking', compact('grid'));

    }

    public function join()
    {
        $fila_espera = Fila::orderBy('created_at','DESC')->get();

        return view('inhouse.join',compact('fila_espera'));
    }

    public function doJoin()
    {
        //$user = Input::get('')
    }

    public function invite()
    {
        //$fila_espera = Fila::orderBy('created_at','DESC')->get();

        $vouchs = Inhouser::getVouchs();

        if (!$vouchs || $vouchs == 0)
            return view('inhouse.invite',compact('vouchs'));


        // Define Query
        $query = (new Gamer())
            ->newQuery()
            ->whereNotExists(function($query)
            {
                $query->select(DB::raw(1))
                    ->from('inhousers')
                    ->whereRaw('inhousers.gamer_id = gamers.id');
            });

        // Define query
        $config = (new GridConfig())
            ->setName('Gamers')
            ->setDataProvider(
                new EloquentDataProvider(
                    $query
                )
            )
            ->setPageSize(200)
            ->setColumns([
                (new FieldConfig('battletag'))
                    ->addFilter(getFilterILike('battletag'))
                    ->setSortable(true)
                    ->setCallback(function ($val) {

                        $gamer = Gamer::where('battletag',$val)->first();

                        if (!$gamer->user)
                            return $val . ' (!)';

                        return '<a href="' . route('users.show',[$gamer->user->slug]) . '">' . $val . '</a>';
                    }),
                (new FieldConfig('competitive_rank'))
                    ->setLabel('competitive rank')
                    ->setSortable(true)
                    ->setCallback(function ($val) {

                        if (!empty($val))
                            return $val ;
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
                (new FieldConfig('invite'))
                    ->setSortable(true)
                    ->setLabel('Convidar')
                    ->setCallback(function ($val, \Nayjest\Grids\EloquentDataRow $row) {

                        if (!$row->getSrc()->user)
                            return '';

                        // Checks if current user has vouchs
                        $current_gamer = Gamer::where('user_id',Auth::user()->id)
                            ->with('inhouser')
                            ->first();

                        if (!$current_gamer)
                            return '';

                        if ($current_gamer->inhouser->vouchs <= 0)
                            return '';

                        return '<button type="button" class="btn btn-info convidar_user" data-gamer="'.
                                $row->getSrc()->user->gamer->id.'">Convidar</button>';
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
                    ])
                    ->getParent()
                ,
                new TFoot()
            ]);

        $grid = (new Grid($config))->render();

        return view('inhouse.invite',compact('vouchs','grid'));
    }


    /**
     * Someone invites someone to Inhouse
     *
     * @return mixed
     */
    public function doInvite()
    {
        $return['code'] = '0';
        $return['success'] = false;

        $gamer_id = Input::get('gamer_id');

        $inhouser = Inhouser::create([
            'gamer_id' => $gamer_id,
            'voucher_id' => Auth::user()->gamer->id
        ]);

        if ($inhouser) {
            $return['code'] = '1';
            $return['success'] = true;
        }

        return Response::json($return);
    }

    /**
     * User is sending a message
     * Save on DB
     * Post to Pusher API
     */
    public function saveMessage()
    {
        // Receive data
        $data = Input::all();

        $test = isset($data['test']);

        // Check for commands, and do what you must do
        $return = $this->checkForCommand($data['message'], $test);

        // Create msg on DB
        $message = new Message();
        $message->user_id = Auth::user()->id;
        $message->message = $data["message"];
        $message->save();

        // Send to pusher if is not a Test
        if (!$test)
            LaravelPusher::trigger('chat', 'message', ['message' => $message->message]);

        return Response::json($return);
    }

    /**
     * Check if message contains an Inhouse command
     */
    public function checkForCommand($message, $test = false)
    {
        $return['code'] = '0';
        $return['message'] = '';

        $command = $this->isThisMessageCommand($message);

        // Message is a command?
        if ($command['isCommand']) {

            switch ($command['command']) {
                case '/status':

                    $status = $this->comStatus();

                    $return = $this->formatReturn(1, $status);

                    break;
                case '/start':
                case '/iniciar':

                    $partida = $this->comStart();

                    // Try to start a match
                    if (!$partida) {
                        $msg = config('verme.msg_no_permission');
                        $msg .= '<br>Uma partida pode estar aberta ou você tem restrições.';

                        $return = $this->formatReturn(0,$msg);
                    }
                    else {
                        $return = $this->formatReturn(1, "Partida $partida aberta! Jogadores podem entrar digitando: /entrar");
                    }

                    break;

                case '/close':
                case '/fechar':

                    $close = $this->comClose($command['param']);

                    if ($close) {
                        $msg = 'Partida fechada! Time vencedor: ' . $command['param'];
                        $msg .= '<br>Os ratings foram atualizados. ';

                        $return = $this->formatReturn(1,$msg);
                    }
                    else
                        $return = $this->formatReturn(0,'Comando inválido, ou você tem restrições para fechar a partida.');

                    break;

                case '/join':
                case '/entrar':

                    $join = $this->comJoin();

                    if ($join)
                        // Todo: dizer vagas restantes na partida
                        $return = $this->formatReturn(1, Auth::user()->name . ' entrou na partida. ');
                    else
                        $return = $this->formatReturn(0,'Você não pode entrar na partida. '
                                    .'<br>A Partida pode não estar aberta, você pode já estar na partida ou ter restrições.');

                    break;

                case '/leave':
                case '/sair':

                    $leave = $this->comLeave();

                    if ($leave)
                        $return = $this->formatReturn(1,'N saiu da Partida. X vagas restantes na partida Y');
                    else
                        $return = $this->formatReturn(0,'Você não pode sair da partida.');

                    break;

                case '/contest':

                    $contest = $this->comContest();

                    if ($contest)
                        $return = $this->formatReturn(1,'N contestou a Partida. Esta partida será revisada pela administração.');
                    else
                        $return = $this->formatReturn(0,'Você não pode contestar a partida.');

                    break;

                case '/cancel':

                    $partida = $this->comCancel();

                    // Try to start a match
                    if (!$partida)
                        $return = $this->formatReturn(0,'Você não pode cancelar a partida.');
                    else {
                        $return = $this->formatReturn(1, "Partida $partida cancelada! Nenhum ponto foi computado.");
                    }

                    break;
            }

            // Testing?
            $isTest = $test? true : config('verme.inhouse_test_mode');

            // Bot response message
            $this->sendBotMessage($return['message'], false);
        }
        else {
            $return = $this->formatReturn(1,'Mensagem normal');
        }

        return $return;
    }

    /**
     * Checks if message is a command
     *
     * @param $message
     * @return array
     */
    public function isThisMessageCommand($message)
    {
        $return = [
            'isCommand' => false,
            'param' => false
        ];

        $commands = [
            '/start',
            '/iniciar',
            '/close',
            '/fechar',
            '/join',
            '/entrar',
            '/sair',
            '/leave',
            '/contest',
            '/cancel',
            '/status'
        ];

        // if is a command, return true
        if (in_array($message, $commands)) {
            $return['isCommand'] = true;
            $return['command'] = $message;
            return $return;
        }

        // Check for close command
        if (strpos($message, '/close') !== false) {
            $all = explode(' ', $message);
            $winner = $all[1];

            $return['isCommand'] = true;
            $return['command'] = '/close';
            $return['param'] = $winner;

            return $return;
        }
    }

    /**
     * Send a message as the BOT
     *
     * @param $msg
     * @param $test
     */
    public function sendBotMessage($msg, $test = true)
    {
        // Save the bot answer
        $message = new Message();
        $message->user_id = config('verme.bot_id');
        $message->message = $msg;
        $message->save();

        // Send to pusher if is not a Test
        if (!$test)
            LaravelPusher::trigger('chat', 'message', ['message' => $message->message]);
    }

    /**
     * Format return of response
     *
     * @param $code
     * @param $msg
     * @return array
     */
    public function formatReturn($code, $msg)
    {
        return [
            'code' => $code,
            'message' => $msg
        ];
    }

    /**
     * Get last messages
     *
     * @param Message $message
     * @return mixed
     */
    public function listMessages(Message $message) {
        return response()->json($message->orderBy("created_at", "DESC")->take(5)->get());
    }

    /**
     * Execute inhouse command: Get status
     *
     * @return bool
     */
    public function comStatus()
    {
        // Check if there is a match open
        $open = Match::open()->first();

        if (!$open) {

            $running = Match::running()->first();

            if ($running)
                return '1 partida <b>em andamento</b> e nenhuma aberta.';

            return 'Nenhuma partida aberta ou em andamento';
        }

        // Check how many on match
        $players_amount = Match::countPlayers($open->id);

        $msg = '<label class="label label-primary">Partida '.$open->id.'</label> aberta com ' . $players_amount . ' jogadores';

        // send msg
        //$this->sendBotMessage($msg, config('verme.inhouse_test_mode'));

        return $msg;
    }

    /**
     * Execute an Inhouse command: user open a new match
     *
     * Can open a match:
     * role > user
     * have inhouser id
     * canPlay
     */
    public function comStart()
    {
        // Check for permission for this command
        if (Auth::user()->role_id <= config('verme.role_user'))
            return false;

        // Check if Can Play
        if (!Inhouser::isInhouser(true))
            return false;

        // Check if there is a match open
        $open = Match::open()->first();

        if ($open)
            return false;

            $match = Match::create([
                'user_id' => Auth::user()->id,
                'status' => '1'
            ]);

        return $match->id;
    }

    /**
     * Execute an Inhouse command: user closes a match
     *
     */
    public function comClose($winner)
    {
        if (!$winner)
            return false;

        // Check for permission for this command
        if (Auth::user()->role_id < config('verme.role_user'))
            return false;

        // get current gamer
        $gamer = Gamer::getGamer();

        if (!$gamer)
            return false;

        // Checks for the match to close
        // must be a match that is running, and this user is on it
        $match = DB::select(DB::raw('SELECT m.* FROM matchs m
                  JOIN gamer_match gm on (gm.match_id = m.id AND gm.gamer_id = '.$gamer->id.')
                    WHERE m.status = "3"
              '));

        $match_id = $match[0]->id;

        if (!$match_id)
            return false;

        return $this->closeMatch($match_id, $winner);
    }

    /**
     * Execute an Inhouse command: user join a match
     *
     */
    public function comJoin()
    {
        // Check if user Can Play
        if (!Inhouser::isInhouser(true))
            return false;

        // Get open match
        $match = Match::open()->first();

        if (!$match)
            return false;

        // Checks if match is full
        if (Match::isFull($match->id))
            return false;

        // get gamer
        $gamer = Gamer::getGamer();

        // Check if user is already on match
        if (Gamer::isOnMatch($match->id, $gamer->id))
            return false;

        // ok to enter match
        $gamer->matchs()->attach($match->id);

        // Checks if match is full now
        if (Match::isFull($match->id)) {
            // Prepare to initiate match
            $this->prepareMatch($match->id);
        }

        return true;
    }

    /**
     * Execute an Inhouse command
     *
     */
    public function comLeave()
    {
        // Check if user Can Play
        if (!Inhouser::isInhouser(true))
            return false;

        // Get open match
        $match = Match::open()->first();

        if (!$match)
            return false;

        // get gamer
        $gamer = Gamer::getGamer();

        // Check if user is already on match
        if (!Gamer::isOnMatch($match->id, $gamer->id))
            return false;

        $gamer->matchs()->detach($match->id);

        return true;
    }

    /**
     * Execute an Inhouse command
     *
     */
    public function comContest()
    {

    }


    /**
     * Prepare a match to initiate
     *
     * @param $match_id
     * @return mixed
     */
    public function prepareMatch($match_id)
    {
        // Bot message
        $this->sendBotMessage('Partida completa. Preparando para iniciar...', true);

        // Change status to "Picking"
        $match = Match::where('id',$match_id)->update([
            'status' => '2'
        ]);

        // Calculate match rating
        $this->defineMatchRating($match_id);

        // Start picking
        $this->startPicks($match_id);

        // change status to running
        Match::where('id',$match_id)
            ->update([
                'status'    => '3'
            ]);
    }

    /**
     * Initiate a match
     *
     * @param $match_id
     * @return mixed
     */
    public function initiateMatch($match_id)
    {
        return Match::where('id',$match_id)->update([
            'status' => '3'
        ]);
    }

    /**
     * Start the picks of a match
     *
     * @param $match_id
     * @return bool
     */
    public function startPicks($match_id)
    {
        // 2x first pick
        $this->firstPicks($match_id);

        $last_picked = false;
        $pickeds = [];
        $teams = [];

        // 10 normal picks
        for ($i=0; $i<10; $i++) {

            // alternate teams
            $team = ($i & 1)? 'B' : 'A';

            // Pick for team
            $last_picked = $this->normalPick($match_id, $team, $last_picked, $pickeds);
            $pickeds[] = $last_picked;

            $teams[$team][] = $last_picked;
        }

        //
        $this->reportTeams($teams);

        $this->sendBotMessage('A partida já pode ser disputada. Boa sorte!',false);

        return true;
    }

    /**
     * Report the created teams and picks
     *
     * @param $teams
     */
    public function reportTeams($teams)
    {
        $teamA = '';
        $teamB = '';

        // Get team A
        foreach($teams['A'] as $player) {
            $inhouser = Inhouser::where('id',$player)->first();
            $teamA .= $inhouser->gamer->battletag . ',';
        }

        // Get team B
        foreach($teams['B'] as $player) {
            $inhouser = Inhouser::where('id',$player)->first();
            $teamB .= $inhouser->gamer->battletag . ',';
        }

        $this->sendBotMessage('<label class="label label-primary">Time A</label>: ' . $teamA,false);
        $this->sendBotMessage('<label class="label label-successs">Time B</label>: ' . $teamB,false);
    }

    /**
     * Perform a normal pick for a new match
     *
     * @param $match_id
     * @param $team
     * @param $last_picked_id
     * @param $pickeds (who is already picked)
     * @return mixed
     */
    public function normalPick($match_id, $team, $last_picked_id, $pickeds)
    {
        if (!$last_picked_id)
            // Get the next higher player
            $highest = Match::getHighestPlayer($match_id);

        else {

            $inhouser = Inhouser::where('id',$last_picked_id)->first();

            // Get the next higher player
            $highest = Match::getHighestPlayer($match_id, $inhouser->rating, $pickeds);
        }

        // Put player on team A
        Match::putPlayerOnTeam($highest[0]->id, $match_id, $team);

        return $highest[0]->id;
    }

    /**
     * First picks of the new match
     *
     * @param $match_id
     */
    public function firstPicks($match_id)
    {
        // select a player with lower rating
        $lower = Match::getLowestPlayer($match_id);

        // Put player on team A
        Match::putPlayerOnTeam($lower[0]->id, $match_id, 'A');

        $inhouser = Inhouser::where('id',$lower[0]->id)->first();

        // Get second lower to team B
        $next_lower = Match::getLowestPlayer($match_id, $inhouser->rating);

        // Put player on team A
        Match::putPlayerOnTeam($next_lower[0]->id, $match_id, 'B');
    }

    /**
     * Calculates the match rating average
     *
     * @param $match_id
     * @return mixed
     */
    public function defineMatchRating($match_id)
    {
        // get players of the match
        $players = Match::getPlayers($match_id);

        $match_rating = '0';
        $rating_sum = '0';

        foreach($players as $player) {
            $gamer = Gamer::where('id',$player->gamer_id)
                ->with('inhouser')
                ->first();

            // Soma o rating do jogador no rating da partida
            $rating_sum += $gamer->inhouser->rating;
        }

        // Divide o total por 12, e acha o rating medio da partida
        $match_rating = round($rating_sum / 12);

        Match::where('id',$match_id)->update([
            'rating' => $match_rating
        ]);

        // Bot message
        $this->sendBotMessage('<label class="label label-primary">Partida '.$match_id.
            '</label> iniciada. Rating da partida: ' . $match_rating, false);

        return true;
    }


    public function auth(Request $request, \Pusher $pusher)
    {
        return $pusher->presence_auth(
        //$request->input('channel_name'),
            'chat',
            $request->input('socket_id'),
            uniqid(),
            //['username' => $request->input('username')]
            ['username' => 'souto']
        );
    }

    /**
     * Get matchs and status
     *
     * @return mixed
     */
    public function getMatchs()
    {
        $type = Input::get('type');

        switch ($type) {
            case 'open':

                $partidas = Match::open()->get();

                foreach ($partidas as $key => $partida) {
                    $partidas[$key]['inscritos'] = Match::countPlayers($partida->id);
                }
                break;
            case 'running':

                $partidas = Match::running()->get();

                foreach ($partidas as $key => $partida) {
                    $partidas[$key]['inscritos'] = Match::countPlayers($partida->id);
                }

                break;
            case 'closed':

                $partidas = Match::closed()->get();
                break;
        }

        return Response::json($partidas);
    }

    /**
     * Get current online players
     * @return mixed
     */
    public function getOnlinePlayers()
    {
        // Checks if user is inhouser, to update online time
        $isInhouser = Inhouser::isInhouser();

        // if is requesting, he is online
        if ($isInhouser)
            Inhouser::goOnline();

        // get online players
        $online_inhousers = Inhouser::online()
            ->with('gamer')
            ->get();

        return Response::json($online_inhousers);
    }

    /**
     * Close a match and compute results
     *
     * @param $match_id
     * @param $winner
     */
    public function closeMatch($match_id,$winner)
    {
        if (Match::close($match_id, $winner)) {
            // Bot message
            $this->sendBotMessage('<label class="label label-primary">Partida '.$match_id.
                '</label> <b>encerrada</b>. Resultados já computados', false);

            return true;
        }

        return false;
    }
}
