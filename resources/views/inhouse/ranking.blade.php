@extends('layouts.main')

@section('content')
        <!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">InHouse</a></li>
        <li class="active">Ranking</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">InHouse Ranking <small>os melhores vermes da atualidade</small></h1>
    <!-- end page-header -->

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif

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
                        <h4 class="panel-title">Ranking</h4>
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
                        Para aparecer na lista de jogadores, voc� deve autorizar a importa��o de seus dados reais do
                        Overwatch, inserindo
                        a sua battle-tag no seu perfil.
                        <br><br>
                        @if (\Illuminate\Support\Facades\Auth::check())
                            <a href="{{ route('users.show',[\Illuminate\Support\Facades\Auth::user()->slug]) }}">Clique
                                aqui</a> para ir para o seu perfil.
                        @else
                            Voc� deve <a href="{{ url('register') }}">ter uma conta</a> e
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

        <!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
    });
</script>
@endsection

