@extends('layouts.main')

@section('content')

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin row -->
    <div class="row">
        <!-- begin col-8 -->
        <div class="col-md-8">
            <div class="panel panel-inverse" data-sortable-id="index-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">InHouse O Verme</h4>
                </div>
                <div class="panel-body">
                    <div class="ui stackable padded grid">

                        <div class="ten wide column chat-column">

                            <div class="panel-body fixed-panel" id="chat_panel">
                                <ul class="media-list">
                                </ul>
                            </div>
                            <div class="panel-footer">
                                <div class="input-group">
                                    @if ($isInhouser)
                                        <input type="text" class="form-control" placeholder="Enter Message" id="messageText" autofocus/>
                                        <span class="input-group-btn">
                                                <button class="btn btn-info" type="button" id="sendMessage">ENVIAR <span class="glyphicon glyphicon-send"></span></button>
                                        </span>
                                    @else
                                        <div class="alert alert-warning fade in m-b-15">
                                            <strong>Jogador Inativo!</strong>
                                            Você não pode enviar mensagens.
                                            <span class="close" data-dismiss="alert">×</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- end col-8 -->
        <!-- begin col-4 -->
        <div class="col-md-4">
            <div class="panel panel-inverse panel-with-tabs" data-sortable-id="index-6">
                <div class="panel-heading p-0">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <div class="tab-overflow overflow-right">
                        <ul class="nav nav-tabs nav-tabs-inverse">
                            <li class="active"><a href="#nav-tab-1" data-toggle="tab"><h4 class="panel-title">Partidas Abertas</h4></a></li>
                            <li class=""><a href="#nav-tab-2" data-toggle="tab"><h4 class="panel-title">Partidas em Andamento</h4></a></li>
                            <li class=""><a href="#nav-tab-3" data-toggle="tab"><h4 class="panel-title">Partidas Encerradas</h4></a></li>
                        </ul>
                    </div>

                </div>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="nav-tab-1">
                        <table class="table table-valign-middle m-b-0">
                            <thead>
                            <tr>
                                <th>Partida</th>
                                <th>Inscritos</th>
                            </tr>
                            </thead>
                            <tbody id="matchs_open">
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-tab-2">
                        <table class="table table-valign-middle m-b-0">
                            <thead>
                            <tr>
                                <th>Partida</th>
                                <th>Rating</th>
                                <th>Jogadores</th>
                            </tr>
                            </thead>
                            <tbody id="matchs_running">
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-tab-3">
                        <table class="table table-valign-middle m-b-0">
                            <thead>
                            <tr>
                                <th>Partida</th>
                                <th>Rating</th>
                                <th>Jogadores</th>
                            </tr>
                            </thead>
                            <tbody id="matchs_closed">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="panel panel-inverse" data-sortable-id="index-8">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Jogadores online</h4>
                </div>
                <div class="panel-body p-0">
                    <aside class="three wide column users-column">
                        <div class="users-list">
                            <div class="online-users ui tiny middle aligned list">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Player</th>
                                        <th>Rating</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </aside>
                </div>
            </div>

            <div class="panel panel-inverse" data-sortable-id="ui-general-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Alertas e Informações</h4>
                </div>
                <div class="panel-body">
                    @if (!$isInhouser)
                        <div class="alert alert-danger fade in m-b-15">
                            <strong>Jogador Inativo!</strong>
                            Você ainda não está ativo como um InHouser. <a href="{{ route('inhouse.entrar') }}">Veja aqui</a>.
                            <span class="close" data-dismiss="alert">×</span>
                        </div>
                    @else
                        <div class="alert alert-success fade in m-b-15">
                            <strong>Ativo!</strong>
                            Você está ativo como um InHouser e já pode jogar.
                            <span class="close" data-dismiss="alert">×</span>
                        </div>
                        @if ($vouchs && $vouchs > 0)
                            <div class="alert alert-info fade in m-b-15">
                                <strong>Vouchs!</strong>
                                Você pode convidar {{ $vouchs }} jogadores para a InHouse.
                                <a href="{{ route('inhouse.invite') }}">Convide aqui</a>.
                                <span class="close" data-dismiss="alert">×</span>
                            </div>
                        @else
                            <div class="alert alert-warning fade in m-b-15">
                                <strong>Vouchs!</strong>
                                Você está sem Vouchs no momento.
                                <span class="close" data-dismiss="alert">×</span>
                            </div>
                        @endif
                    @endif
                    <!--
                    <div class="alert alert-info fade in m-b-15">
                        <strong>Info!</strong>
                        Morbi sed nibh ac tortor laoreet blandit sed eu ligula.
                        <span class="close" data-dismiss="alert">×</span>
                    </div>-->
                    <div class="alert alert-warning fade in m-b-15">
                        <strong>BETA!</strong>
                        Este sistema ainda está em fase Beta. Reporte erros para {{ 'staff@watchoverme.com.br' }}
                        <span class="close" data-dismiss="alert">×</span>
                    </div>

                </div>
            </div>

        </div>
        <!-- end col-4 -->
    </div>
    <!-- end row -->

</div>
@endsection

@section('scripts')
    @include('elements.scripts')
    <script>
         $.ajaxSetup({
            headers: { 'X-CSRF-Token' : '{!! csrf_token() !!}' }
         });
    </script>
    <script src="{{ asset('js/pusher/pusher.js') }}"></script>
    <script src="{{ asset('js/jquery/jquery.cookie.js') }}"></script>

    <script>
         $(function(){

             // Pusher connect
             var pusher = new Pusher( '{{ $credentials['pusher_key'] }}', {
                 authEndpoint: "pusher/auth",
                 auth: {
                     headers: { "X-CSRF-Token": '{!! csrf_token() !!}' },
                 },
                 encrypted: true
             });

             // Channel Subscription
             var channel = pusher.subscribe('chat');
             channel.bind('message', function(data) {

                 console.debug(data);
                 var message = data;

                 var author = message.author? message.author : '';

                 //$(".media-list li").first().remove();
                 $(".media-list").append('<li class="media"><div class="media-body"><div class="media"><div class="media-body">'
                         + message.message + '<br/><small class="text-muted">' + author + ' | ' + message.created_at + '</small><hr/></div></div></div></li>');

                 // Scroll down
                 var objDiv = document.getElementById("chat_panel");
                 objDiv.scrollTop = objDiv.scrollHeight;
             });

             $.get( '{{ route('messages') }}', function (messages) {
                refreshMessages(messages)
             });

             $('#messageText').keyup(function(e){
                 if(e.keyCode == 13)
                 {
                    sendMessage();
                 }
             });

             $("#sendMessage").click( function() {
                 sendMessage();
             });
        });

         // Post message to BackEnd
        function sendMessage() {
            $container = $('.media-list');
            $container[0].scrollTop = $container[0].scrollHeight;
            var message = $("#messageText").val();

            //var author = $.cookie("realtime-chat-nickname");
            var author = 'tester';

            console.log('posting message: ' + message);

            $.post( '{{ route('messages') }}', {message: message, author: author}, function( data ) {
                $("#messageText").val("")
            });

            $container.animate({ scrollTop: $container[0].scrollHeight }, "slow");
        }

         // Print initial messages
         function refreshMessages(messages) {

             $.each(messages.reverse(), function(i, message) {
                 $(".media-list").append('<li class="media"><div class="media-body">'
                         + message.message + '<br/><small class="text-muted">' + message.author + ' | ' + message.created_at + '</small><hr/></div></li>');
             });
         }
    </script>
    <style type="text/css">
        .fixed-panel {
            min-height: 320px;
            max-height: 400px;
            height: 395px;
            overflow-x: auto;
        }
        .media-list {
            overflow: auto;
        }
        .media, .media-body{
            height: 32px !important;
        }
    </style>
    <script>

        $(document).ready(function() {
            App.init();

            getPartidas('open');
            getPartidas('closed');
            getPartidas('running');

            getOnlinePlayers();
        });


    </script>
@endsection