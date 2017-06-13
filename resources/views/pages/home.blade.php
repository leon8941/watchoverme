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
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-green">
                    <div class="stats-icon"><i class="fa fa-child"></i></div>
                    <div class="stats-info">
                        <h4>TOTAL PLAYERS</h4>
                        <p id="stats_total_players">
                            <i class="fa fa-refresh fa-spin"></i>
                        </p>
                    </div>
                    <div class="stats-link">
                        <a href="{{ route('gamers.index') }}">Ver Lista <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-blue">
                    <div class="stats-icon"><i class="fa fa-users"></i></div>
                    <div class="stats-info">
                        <h4>TOTAL TIMES</h4>
                        <p id="stats_total_teams">
                            <i class="fa fa-refresh fa-spin"></i>
                        </p>
                    </div>
                    <div class="stats-link">
                        <a href="{{ route('teams.index') }}">Ver Lista <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-purple">
                    <div class="stats-icon"><i class="fa fa-trophy"></i></div>
                    <div class="stats-info">
                        <h4>EVENTOS ABERTOS</h4>
                        <p id="stats_events">
                            <i class="fa fa-refresh fa-spin"></i>
                        </p>
                    </div>
                    <div class="stats-link">
                        <a href="{{ route('events.index') }}">Ver Lista <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-red">
                    <div class="stats-icon"><i class="fa fa-retweet"></i></div>
                    <div class="stats-info">
                        <h4>PLAYER UPDATES SEMANA</h4>
                        <p id="stats_total_updates"><i class="fa fa-refresh fa-spin"></i></p>
                    </div>
                    <div class="stats-link">
                        <a href="{{ route('gamers.index') }}">Ver Ranking <i class="fa fa-arrow-circle-o-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
        </div>
        <!-- end row -->

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
                                            <img src="{{ getPostImage($post->image) }}" alt="" class="media-object" width="172px"
                                                 style="max-height: 172px" />
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading">
                                                <a href="{{ route('posts.show',[$post->slug]) }}">{{ $post->title }}</a>
                                            </h4>
                                            {{ $post->description }}
                                            <div class="text text-right text-muted text-align-reverse" style="margin-right: 4px">
                                                @foreach($post->categories as $category)
                                                    <label class="label label-{{ getCategoryColor($category) }}">{{$category->title}}</label>
                                                @endforeach
                                                    <br>
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
                                    <th>Link</th>
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
                                        <td>{!! getRegionFlag($event->from) !!}</td>
                                        <td>{{ $event->description }}</td>
                                        <td>
                                            @if ($event->streamer)
                                                <a href="{{ $event->streamer }}" target="_blank"><i class="fa fa-caret-square-o-right"></i></a>
                                            @endif
                                        </td>
                                        <td><a href="{{ $event->url }}" target="_blank"><i class="fa fa-2x fa-link"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="widget-chart with-sidebar bg-black">
                    <div class="widget-chart-content">
                        <h4 class="chart-title">
                            Live Streams
                            <small>acompanhe os melhores jogadores brasileiros</small>
                        </h4>
                        <div id="visitors-line-chart" class="morris-inverse" style="height: 260px; position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                            <ul class="registered-users-list clearfix">
                                @foreach ($streams as $stream)
                                    <li>
                                        <a href="http://twitch.tv/{{ $stream->twitch }}" target="_blank">
                                            <img src="{{ $stream->twitch_logo }}" alt="{{ $stream->name }} stream">
                                        </a>
                                        <h4 class="username text-ellipsis">
                                            {{ $stream->twitch_title }}
                                            <small>{{ $stream->name }}</small>
                                        </h4>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="widget-chart-sidebar bg-black-darker">
                        <div class="chart-number">
                            {{ $followers->followers }}
                            <small>total seguidores</small>
                        </div>
                        <div id="visitors-donut-chart" style="height: 160px">
                        </div>
                        <ul class="chart-legend">
                            <li><i class="fa fa-circle-o fa-fw text-success m-r-5"></i> {{ $streams->count() }} <span>Live Streams</span></li>
                            <li><i class="fa fa-circle-o fa-fw text-info m-r-5"></i> <span><a href="{{ route('gamers.streams') }}">Ver Todos</a></span></li>
                        </ul>
                    </div>
                </div>

            </div>
            <!-- end col-8 -->
            <!-- begin col-4 -->
            <div class="col-md-4">
                <div class="panel panel-inverse" data-sortable-id="index-4">
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

                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="index-6">
                    <div class="panel-heading">
                        <h4 class="panel-title">Mercado<span class="label label-success pull-right">últimas</span></h4>
                    </div>
                    <div class="panel-body">
                        <div data-scrollbar="true" data-height="310px">
                            <ul class="chats">
                                <?php $row = 0; ?>
                                @foreach ($mercado as $item)
                                    <li class="{{ $row%2==0? 'left' : 'right' }}">
                                        <a href="{{ route('teams.show', ['slug' => $item->team->slug]) }}"
                                           target="_blank" class="name">{{ $item->team->title }}</a>
                                        <a href="{{ route('teams.show', ['slug' => $item->team->slug]) }}"
                                           target="_blank" class="image pull-{{ $row%2==0? 'left' : 'right' }}">
                                            <img src="{{ getTeamAvatar($item->team->image) }}" alt="" class="" width="160px"/>
                                        </a>
                                        <div class="message">
                                            @if ($item->action == 'I')
                                                <i class="text-success fa fa-arrow-down"></i>
                                            @else
                                                <i class="text-danger fa fa-arrow-up"></i>
                                            @endif
                                                {{ $item->description }}
                                        </div>
                                    </li>
                                    <?php $row++; ?>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end panel -->

                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="index-2">
                    <div class="panel-heading">
                        <h4 class="panel-title">Top 5 Players <span class="label label-success pull-right">Ranking</span></h4>
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
                        <br>
                        <div class="panel-footer text-center">
                            <a href="{{ route('gamers.index') }}" class="text-inverse">Ver Ranking</a>
                        </div>
                    </div>
                </div>
                <!-- end panel -->

                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="index-3">
                    <div class="panel-heading">
                        <h4 class="panel-title">Top 5 Times <span class="pull-right label label-success">Ranking </span></h4>
                    </div>
                    <table id="data-table" class="table table-striped nowrap dataTable no-footer dtr-inline" width="100%" role="grid" aria-describedby="data-table_info" style="width: 100%;">
                        <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 222px;">#</th>
                            <th class="sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 322px;">Jogador</th>
                            <th class="sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 293px;">Pontos</th>
                            <th class="sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 190px;">Vitórias</th>
                            <th class="sorting" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 139px;">Derrotas</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; ?>
                        @foreach ($teams as $team)
                            <tr class="gradeA odd" role="row">
                                <td class="sorting_1">{{ $i }}</td>
                                <td>
                                    <a href="{{ route('teams.show', [$team->slug]) }}" target="_blank">
                                        {{ $team->title }}
                                    </a>
                                </td>
                                <td><span class="badge badge-primary">{{ $team->points }}</span></td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                        </tbody>
                    </table>
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

            getStats('players');
            getStats('teams');
            getStats('updates');
            getStats('events');
        });
    </script>
@endsection