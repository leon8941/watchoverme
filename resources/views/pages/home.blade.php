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

                <ul class="nav nav-tabs nav-justified nav-justified-mobile" data-sortable-id="index-2">
                    <li class="active"><a href="#parceiros" data-toggle="tab"><i class="fa fa-glass m-r-5"></i> <span class="hidden-xs">Parceiros</span></a></li>
                </ul>
                <div class="tab-content" data-sortable-id="index-3">
                    <div class="tab-pane fade active in" id="parceiros">
                        <div class="height-250" data-scrollbar="true">
                            <ul class="media-list media-list-with-divider">
                                <li class="media media-sm">
                                    <a href="http://www.bestgamers.com.br"
                                       target="_blank" class="pull-left">
                                        <img src="{{ asset('img/partners/best-gamers.png') }}" alt="" class="" width="160px"/>
                                    </a>
                                    <div class="media-body">
                                        <a href="javascript:;"><h4 class="media-heading">BestGamers</h4></a>
                                        <p class="m-b-5">
                                            Uma das maiores e melhores lojas para gamers do Brasil
                                        </p>
                                        <i class="text-muted">
                                            <a href="http://www.bestgamers.com.br"
                                               target="_blank">www.BestGamers.com.br</a>
                                        </i>
                                    </div>
                                </li>
                                <li class="media media-sm">
                                    <a href="https://www.youtube.com/channel/UC4JKcRevcfS1cKDwmYY4acg"
                                       target="_blank" class="pull-left">
                                        <img src="{{ asset('img/partners/gaming-room.PNG') }}" alt="" class="" width="160px"/>
                                    </a>
                                    <div class="media-body">
                                        <a href="javascript:;"><h4 class="media-heading">Gaming Room</h4></a>
                                        <p class="m-b-5">
                                            Gaming Room é um canal de debate de games que começa a ganhar volume no YouTube.
                                        </p>
                                        <i class="text-muted">
                                            <a href="www.gamingroom.net"
                                               target="_blank">www.GamingRoom.net</a>
                                        </i>
                                    </div>
                                </li>
                            </ul>
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

                    <!-- begin panel -->
                    <div class="panel panel-inverse" data-sortable-id="index-6">
                        <div class="panel-heading">
                            <h4 class="panel-title">New Registered Users <span class="pull-right label label-success">{{ $count_new_users }} new users</span></h4>
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