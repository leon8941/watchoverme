@extends('layouts.main')

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">NerfThis</a></li>
            <li class="active">Sobre</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">NerfThis <small>um pouco sobre nós..</small></h1>
        <!-- end page-header -->

        <!-- begin row -->
        <div class="row">
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-green">
                    <div class="stats-icon"><i class="fa fa-desktop"></i></div>
                    <div class="stats-info">
                        <h4>VISITAS ÚNICAS</h4>
                        <p>6.827</p>
                    </div>
                    <div class="stats-link">
                        <a href="javascript:;">desde 01/07/2016 <i class="fa fa-check"></i></a>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-blue">
                    <div class="stats-icon"><i class="fa fa-chain-broken"></i></div>
                    <div class="stats-info">
                        <h4>RETORNO DE VISITANTES</h4>
                        <p>39,88%</p>
                    </div>
                    <div class="stats-link">
                        <a href="javascript:;">alto bounce rate <i class="fa fa-arrows-h"></i></a>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-purple">
                    <div class="stats-icon"><i class="fa fa-users"></i></div>
                    <div class="stats-info">
                        <h4>USUÁRIOS CADASTRADOS</h4>
                        <p>172</p>
                    </div>
                    <div class="stats-link">
                        <a href="javascript:;">gamers ativos <i class="fa fa-gamepad"></i></a>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->
            <!-- begin col-3 -->
            <div class="col-md-3 col-sm-6">
                <div class="widget widget-stats bg-red">
                    <div class="stats-icon"><i class="fa fa-clock-o"></i></div>
                    <div class="stats-info">
                        <h4>TIMES CADASTRADOS</h4>
                        <p>9</p>
                    </div>
                    <div class="stats-link">
                        <a href="javascript:;">times ativos <i class="fa fa-group"></i></a>
                    </div>
                </div>
            </div>
            <!-- end col-3 -->

            <div class="col-md-8">
                <div class="panel panel-primary panel-with-tabs" data-sortable-id="index-1">
                    <div class="panel-heading">
                        <ul id="myTab" class="nav nav-tabs pull-right">
                            <li class="active"><a href="#home" data-toggle="tab"><i class="fa fa-caret-square-o-right"></i> <span class="hidden-xs">Cenário Atual</span></a></li>
                            <li><a href="#profile" data-toggle="tab"><i class="fa fa-rocket"></i> <span class="hidden-xs">Futuro</span></a></li>
                        </ul>
                        <h4 class="panel-title">Perspectivas</h4>
                    </div>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade in active" id="home">
                            <h4>Você deve estar se perguntando. Porque investir em nossa comunidade?</h4>
                            <p>É bem simples na verdade.</p>
                            <p>Somos a <b>única comunidade brasileira que fornece ferramentas para os gamers</b> se desenvolverem. <br>Dentre as principais, temos:
                                <dl class="dl-horizontal">
                                    <dt>Importar dados do game</dt>
                                    <dd>Nossa API captura os dados reais dos jogadores no Overwatch, através de uma API.</dd>
                                    <dd>-</dd>
                                    <dt>Sistema de Ranking</dt>
                                    <dd>Com as estatísticas dos jogadores capturadas, conseguimos colocá-los em rankings, comparando os atributos</dd>
                                    <dd>-</dd>
                                    <dt>100% de retorno</dt>
                                    <dd>Somos uma comunidade sem fins lucrativos. Todo e qualquer investimento ou lucro feito nNerfThis é retornado para a própria comunidade,
                                    seja em forma de prêmios, ou pagando desenvolvedores, designers, para aprimorar a nossa plataforma.</dd>
                                </dl>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <p>Estamos investindo em mais ferramentas.</p>
                            <p>Neste momento, estamos desenvolvendo um sistema chamado InHouse, que já está em testes, e irá elevar o nível do cenário competitivo nacional de Overwatch.</p>
                            <p>Faremos um vídeo em breve explicando como a InHouse vai funcionar. Prepare-se, pois com ela virão prêmios incríveis!</p>
                        </div>
                    </div>
                </div>

                <!-- begin panel -->
                <div class="panel panel-inverse panel-info" data-sortable-id="index-2">
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
                                        Canal dedicado exclusivamente à abordagem de assuntos técnicos, informativos e gameplays.
                                    </div>
                                </li>
                                <li class="left">
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

            <div class="col-md-4">
                <div class="panel panel-inverse" data-sortable-id="index-8">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Quem Somos</h4>
                    </div>
                    <div class="panel-body p-0">
                        <div class="media media-lg">
                            <a class="media-left" href="javascript:;">
                                <img src="{{ asset('img/verme.png') }}" alt="" class="media-object">
                            </a>
                            <div class="media-body">
                                <br>
                                <p>Somos a maior comunidade de brasileira focada no cenário competitivo de OverWatch.</p>
                                <p>Damos as melhores ferramentas e informações que os gamers precisam.</p>
                                <h4>Entre em contato</h4>
                                <p>Você quer ser um parceiro, um colaborador, um investidor? Mande-nos um email: {{ 'staff@watchoverme.com.br' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-inverse" data-sortable-id="index-9">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Todo List</h4>
                    </div>
                    <div class="panel-body p-0">
                        <ul class="todolist">
                            <li>
                                <a href="javascript:;" class="todolist-container" data-click="todolist">
                                    <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                                    <div class="todolist-title">InHouse</div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="todolist-container" data-click="todolist">
                                    <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                                    <div class="todolist-title">Aprimoramento dos recursos de conteúdo</div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="todolist-container" data-click="todolist">
                                    <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                                    <div class="todolist-title">Sistema de mensagens</div>
                                </a>
                            </li>
                            <li class="active">
                                <a href="javascript:;" class="todolist-container active" data-click="todolist">
                                    <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                                    <div class="todolist-title">Importar dados e estatísticas de jogador do game</div>
                                </a>
                            </li>
                            <li class="active">
                                <a href="javascript:;" class="todolist-container active" data-click="todolist">
                                    <div class="todolist-input"><i class="fa fa-square-o"></i></div>
                                    <div class="todolist-title">Sistema de Ranking</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            App.init();
        });

    </script>
@endsection

