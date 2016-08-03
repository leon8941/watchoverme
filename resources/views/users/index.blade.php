@extends('layouts.main')

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">Home</a></li>
            <li class="active">Ranking</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Ranking <small>brasileiro de Overwatch</small></h1>
        <!-- end page-header -->

        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12 ui-sortable">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="ui-icons-6">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Temporada Best Gamers</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <p>
                                <i class="fa fa-child fa-4x pull-left muted fa-border"></i>
                                Você está no Ranking brasileiro de Overwatch. <br>
                                O único que dá prêmios sensacionais a cada temporada, sem te cobrar nada.<br>
                                Neste ranking nacional, você é comparado aos demais jogadores brasileiros através de dados reais do Overwatch,
                                importando suas estatísticas diretamente do jogo.
                            </p>
                            <br style="clear:both">
                            <p>
                                <a href="http://www.bestgamers.com.br" target="_blank">
                                    <img src="{{ asset('img/partners/best-gamers.png') }}">
                                </a>
                            </p>
                            <p>
                                <i class="fa fa-quote-left fa-4x pull-left muted fa-border"></i>
                                Estamos apoiando <b>O Verme</b> em busca do fortalecimento do cenário competitivo nacional de Overwatch.<br>
                                Desejamos a todos boa sorte e que vença o melhor!<br>
                                Lembre-se que temos <a href="http://www.bestgamers.com.br" target="_blank">preços especiais</a> para usuários do Verme.
                            </p>
                            <br>
                            <p>
                                <h4>Premiação e Regras</h4>
                                <img style="float: left; margin: 0px 15px 15px 0px;"
                                     src="http://watchoverme.com.br/uploads/1468882970-deathadder-overwatch-2.jpg"
                                     width="140px" class="fa-border" />
                                Para entender sobre a premiação e regras da temporada você pode:<br>
                                - Ver <a href="https://www.youtube.com/watch?v=GD6DvXGncSs" target="_blank">esse vídeo do pOkiz</a></a> explicando a temporada<br>
                                - Ler <a href="http://watchoverme.com.br/posts/nosso-ranking-nacional-de-overwatch-tera-premiacao" target="_blank">esse artigo</a> com tudo detalhado por escrito
                            </p>
                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
        </div>

        <!-- begin row -->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="table-basic-7">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                        <h4 class="panel-title">Ranked Players</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            {!! $grid !!}
                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->

        <div class="panel panel-inverse" data-sortable-id="ui-general-2">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h4 class="panel-title">Notes</h4>
            </div>
            <div class="panel-body">
                <div class="note note-success">
                    <h4>Como ser Rankeado</h4>
                    <p>
                        Para aparecer na lista de jogadores, você deve autorizar a importação de seus dados reais do
                        Overwatch, inserindo
                        a sua battle-tag no seu perfil.
                        <br><br>
                            @if (\Illuminate\Support\Facades\Auth::check())
                                <a href="{{ route('users.show',[\Illuminate\Support\Facades\Auth::user()->slug]) }}">Clique
                                aqui</a> para ir para o seu perfil.
                            @else
                                Você deve <a href="{{ url('register') }}">ter uma conta</a> e
                                <a href="{{ url('login') }}">estar logado</a>, depois visite seu perfil.
                            @endif

                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- end #content -->

@endsection

@section('scripts')


    <script>
        $(document).ready(function() {
            App.init();

            // View all function
            $('#show-all').click(function() {
                location.href = '{{ route('gamers.index', ['all' => true]) }}';
            });
        });
    </script>
@endsection

