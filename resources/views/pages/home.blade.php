@extends('layouts.main')

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">Home</a></li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Dashboard <small></small></h1>
        <!-- end page-header -->

        <!-- begin row -->
        <div class="row">
            <!-- begin col-8 -->
            <div class="col-md-8">

                <ul class="nav nav-tabs nav-tabs-inverse nav-justified nav-justified-mobile" data-sortable-id="index-1">
                    <li class="active"><a href="#latest-post" data-toggle="tab"><i class="fa fa-comment-o m-r-5"></i> <span class="hidden-xs">Últimas Notícias</span></a></li>
                    <li class=""><a href="#purchase" data-toggle="tab"><i class="fa fa-trophy m-r-5"></i> <span class="hidden-xs">Próximos Eventos</span></a></li>
                </ul>
                <div class="tab-content" data-sortable-id="index-2">
                    <div class="tab-pane fade active in" id="latest-post">
                        <div class="height-sm" data-scrollbar="true">
                            <ul class="media-list media-list-with-divider">
                                @foreach ($posts as $post)
                                    <li class="media media-lg" style="min-height: 90px;">
                                        <a href="{{ route('posts.show', [$post->slug]) }}" class="pull-left">
                                            <img src="{{ getPostImage($post->image) }}" alt="" class="media-object" width="206px"
                                                 style="max-height: 290px" />
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                <a href="{{ route('posts.show',[$post->slug]) }}">{{ $post->title }}</a>
                                            </h4>
                                            {{ $post->description }}
                                            <div class="text text-right text-muted text-align-reverse">
                                                {{ $post->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="{{ route('posts.index') }}" class="text-inverse">Ver Todas</a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="purchase">
                        <div class="height-sm" data-scrollbar="true">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Início</th>
                                    <th></th>
                                    <th>Evento</th>
                                    <th>Região</th>
                                    <th>Descrição</th>
                                    <th>Stream</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($events as $event)
                                    <tr>
                                        <td>{{ $event->starts->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ $event->url }}" target="_blank">
                                                <img src="{{ asset('uploads/'.$event->image) }}" alt="" width="220px"/>
                                            </a>
                                        </td>
                                        <td class="hidden-sm">
                                            {{ $event->title }}
                                        </td>
                                        <td>{{ getRegion($event->from) }}</td>
                                        <td>{{ $event->description }}</td>
                                        <td>
                                            @if ($event->streamer)
                                                <a href="{{ $event->streamer }}" target="_blank"><i class="fa fa-caret-square-o-right"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col-8 -->
            <!-- begin col-4 -->
            <div class="col-md-4">
                <div class="panel panel-inverse" data-sortable-id="index-11">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Últimas atualizações</h4>
                    </div>
                    <div class="panel-body p-t-0">
                        <table class="table table-valign-middle m-b-0">
                            <thead>
                            <tr>
                                <th>Player</th>
                                <th>Competitive Rank</th>
                                <th>Level</th>
                                <th>Competitive Wins</th>
                                <th>Competitive Lost</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($updated_players as $player)
                                <tr>
                                    <td>
                                        @if ($player->user)
                                            <a href="{{route('users.show',[$player->user->slug]) }}"> {{ $player->battletag }}</a></td>
                                        @endif
                                    <td>
                                        @if ($player->competitive_rank)
                                            {{ $player->competitive_rank }}
                                            <span class="text-success"><i class="fa fa-arrow-up"></i></span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $player->level }}</td>
                                    <td>{{ $player->competitive_wins }}</td>
                                    <td>{{ $player->competitive_lost }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="panel-footer text-center">
                            <a href="{{ route('gamers.index') }}" class="text-inverse">Ver Ranking</a>
                        </div>
                    </div>
                </div>

                <!-- calendar -->
                <div class="panel panel-inverse" data-sortable-id="index-5">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Calendário</h4>
                    </div>
                    <div class="panel-body">
                        <div id="calendar"></div>
                        <br>
                        <div class="panel-footer text-center">
                            <a href="{{ route('events.index') }}" class="text-inverse">Ver Eventos</a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end col-4 -->
        </div>
        <!-- end row -->

        <!-- begin row -->
        <div class="row">
            <!-- begin col-4 -->
            <div class="col-md-4">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="index-2">
                    <div class="panel-heading">
                        <h4 class="panel-title">Parceiros<span class="label label-success pull-right">3 deuses</span></h4>
                    </div>
                    <div class="panel-body bg-silver">
                        <div data-scrollbar="true" data-height="310px">
                            <ul class="chats">
                                <li class="left">
                                    <a href="http://www.bestgamers.com.br"
                                       target="_blank" class="name">Best Gamers</a>
                                    <a href="http://www.bestgamers.com.br"
                                       target="_blank" class="image pull-left">
                                        <img src="{{ asset('img/partners/best-gamers.jpg') }}" alt="" class="" width="160px"/>
                                    </a>
                                    <div class="message">
                                        Uma das maiores e melhores lojas <b>para gamers</b> do Brasil.<br>
                                        Patrocinamos a Temporada Best Gamers do ranking nacional de Overwatch pois acreditamos
                                        no cenário de e-sports brasileiro.
                                    </div>
                                </li>
                                <li class="right">
                                    <a href="https://www.youtube.com/channel/UCcpyVzY-cxTTmacKZM3_edQ"
                                       target="_blank" class="name">pOkiz Games - YouTube Channel</a>
                                    <a href="https://www.youtube.com/channel/UCcpyVzY-cxTTmacKZM3_edQ"
                                       target="_blank"  class="image"><img alt="" src="{{ asset('img/partners/pokiz.PNG') }}" /></a>
                                    <div class="message">
                                        Canal de games no Youtube com foco em Overwatch.
                                    </div>
                                </li>
                                <li class="left">
                                    <span class="date-time">09:20am</span>
                                    <a href="http://gamingroom.net" class="name">Gaming Room</a>
                                    <a href="www.gamingroom.net"
                                       target="_blank" class="image pull-left">
                                        <img src="{{ asset('img/partners/gaming-room-square.PNG') }}" alt="" class="" width="160px"/>
                                    </a>
                                    <div class="message">
                                        Gaming Room é um canal de debate de games que começa a ganhar volume no YouTube.
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="index-3">
                    <div class="panel-heading">
                        <h4 class="panel-title">Top 5 Ranking <span class="label label-success pull-right">5 lendas</span></h4>
                    </div>
                    <div id="schedule-calendar" class="bootstrap-calendar"></div>
                    <div class="list-group">
                        <table id="data-table" class="table table-striped nowrap dataTable no-footer dtr-inline" width="100%" role="grid" aria-describedby="data-table_info" style="width: 100%;">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 222px;">#</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 322px;">Jogador</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 293px;">Rank</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 190px;">Vitórias</th>
                                <th class="sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 139px;">Derrotas</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; ?>
                            @foreach ($tops as $top)
                                <tr class="gradeA odd" role="row">
                                    <td class="sorting_1">{{ $i }}</td>
                                    <td>
                                        <a href="{{ route('users.show', [$top->user->slug]) }}" target="_blank">
                                            {{ $top->battletag }}
                                        </a>
                                    </td>
                                    <td><span class="badge badge-primary">{{ $top->competitive_rank }}</span></td>
                                    <td>{{ $top->competitive_wins }}</td>
                                    <td>{{ $top->competitive_lost }}</td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-body">
                        <div id="calendar"></div>
                        <br>
                        <div class="panel-footer text-center">
                            <a href="{{ route('gamers.index') }}" class="text-inverse">Ver Ranking</a>
                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-4 -->
            <!-- begin col-4 -->
            <div class="col-md-4">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="index-6">
                    <div class="panel-heading">
                        <h4 class="panel-title">Novos Vermes <span class="pull-right label label-success">{{ $count_new_users }} larvinhas </span></h4>
                    </div>
                    <ul class="registered-users-list clearfix">
                        @foreach($new_registered_users as $user)
                            <li>
                                <a href="{{ route('users.show',[$user->slug]) }}">
                                    <img src="{{ getUserImage($user->avatar) }}" alt="{{ $user->name }}" width="114px" style="max-height: 114px"/></a>
                                <h4 class="username text-ellipsis">
                                    {{ $user->name }}
                                    <small></small>
                                </h4>
                            </li>
                        @endforeach
                    </ul>
                    <div class="panel-footer text-center">
                        <a href="{{ route('gamers.index') }}" class="text-inverse">Ver Todos</a>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-4 -->
        </div>
        <!-- end row -->

    </div>
    <!-- end #content -->
@endsection

@section('scripts')
    @include('elements.scripts')
    <script src="{{ asset('assets/plugins/isotope/jquery.isotope.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/lightbox/js/lightbox-2.6.min.js') }}"></script>

    <script src="{{ asset('js/moment/moment.js') }}"></script>
    <script src="{{ asset('js/fullcalendar/fullcalendar.min.js') }}"></script>
    <link href="{{ asset('css/fullcalendar/fullcalendar.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/fullcalendar/fullcalendar.print.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('assets/js/gallery.demo.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            App.init();
            Gallery.init();

            getEvents();

        });
    </script>
@endsection