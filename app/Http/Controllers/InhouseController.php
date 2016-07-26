<?php

namespace App\Http\Controllers;

use App\Fila;
use App\Gamer;
use App\Inhouser;
use App\Match;
use App\Message;
use App\Team;
use App\User;
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

        SEOMeta::setTitle('InHouse - O Verme');
        SEOMeta::setDescription('Melhor sistema de ranking brasileiro de Overwatch no modo InHouse');
        SEOMeta::setCanonical('http://watchoverme.com.br/inhouse');
        SEOMeta::addKeyword(['inhouse', 'ranking', 'rating', 'campeonato','overwatch',
            'o verme', 'verme', 'campeonatos overwatch', 'ranking overwatch', 'ranking nacional']);

        $credentials['pusher_app_id'] = getenv('PUSHER_APP_ID');
        $credentials['pusher_key'] = getenv('PUSHER_KEY');
        $credentials['pusher_secret'] = getenv('PUSHER_SECRET');

        $partidas_abertas = Match::open()->get();

        $partidas_encerradas = Match::closed()->get();

        $partidas_andamento = Match::running()->get();

        $online_inhousers = Inhouser::online()
            ->with('gamer')
            ->get();


        return view('inhouse.index', compact(
            'credentials',
            'partidas_abertas',
            'partidas_encerradas',
            'partidas_andamento',
            'online_inhousers',
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
            ->setName('InHouse Ranking')
            ->setDataProvider(
                new EloquentDataProvider(
                    $query
                )
            )
            ->setPageSize(30)
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

        return view('inhouse.ranking');

    }

    public function join()
    {
        $fila_espera = Fila::orderBy('created_at','DESC')->get();

        return view('inhouse.join',compact('fila_espera'));
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
                    ->setLabel('Gamers')
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

        // Check for commands, and do what you must do
        $return = $this->checkForCommand($data['message'], $data['test']);

        // Create msg on DB
        $message = new Message();
        $message->user_id = Auth::user()->id;
        $message->message = $data["message"];
        $message->save();

        // Send to pusher if is not a Test
        if (!isset($data['test']) && $data['test'] != '1')
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
        ];

        // Message is a command?
        if (in_array($message, $commands)) {

            switch ($message) {
                case '/start':
                case '/iniciar':

                    $start = $this->comStart();

                    // Try to start a match
                    if (!$start) {
                        $msg = config('verme.msg_no_permission');
                        $msg .= '<br>Uma partida pode estar aberta ou você tem restrições.';

                        $return = $this->formatReturn(0,$msg);
                    }
                    else {
                        $return = $this->formatReturn(1, "Partida $start aberta! Jogadores podem entrar digitando: /entrar");
                    }

                    break;

                case '/close':
                case '/fechar':

                    $close = $this->comClose();

                    if ($close) {
                        $msg = 'Partida 666 fechada! Time vencedor: A ';
                        $msg .= '<br>Jogador 1 : +15pts ';

                        $return = $this->formatReturn(1,$msg);
                    }
                    else
                        $return = $this->formatReturn(0,'Você não pode fechar a partida.');

                    break;

                case '/join':
                case '/entrar':

                    $join = $this->comJoin();

                    if ($join)
                        $return = $this->formatReturn(1,'N entrou na partida. X vagas restantes');
                    else
                        $return = $this->formatReturn(0,'Você não pode entrar na partida.');

                    // Check if N = 12 players, and start

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

                    $start = $this->comCancel();

                    // Try to start a match
                    if (!$start)
                        $return = $this->formatReturn(0,'Você não pode cancelar a partida.');
                    else {
                        $return = $this->formatReturn(1, "Partida $start cancelada! Nenhum ponto foi computado.");
                    }

                    break;
            }

            // Save the bot answer
            $message = new Message();
            $message->user_id = config('verme.bot_id');
            $message->message = $return['message'];
            $message->save();

            // Send to pusher if is not a Test
            if (!isset($test) && $test != '1')
                LaravelPusher::trigger('chat', 'message', ['message' => $message->message]);
        }
        else {
            $return = $this->formatReturn(1,'Mensagem normal');
        }

        return $return;
    }

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
     * Execute an Inhouse command
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
     * Execute an Inhouse command
     *
     */
    public function comClose()
    {
        // Check for permission for this command
        if (Auth::user()->role_id <= config('verme.role_user'))
            return false;

        // Checks for any open match
        $match = Match::open()->first();

        // Checks if
    }

    /**
     * Execute an Inhouse command
     *
     */
    public function comJoin()
    {
        // Check if user Can Play
        if (!Inhouser::isInhouser(true))
            return false;

        // get gamer
        $gamer = Gamer::getGamer();

        // Get open match
        $match = Match::open()->first();

        $gamer->matchs()->attach($match->id);

        return true;
    }

    /**
     * Execute an Inhouse command
     *
     */
    public function comLeave()
    {

    }

    /**
     * Execute an Inhouse command
     *
     */
    public function comContest()
    {

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


}
