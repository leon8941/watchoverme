@extends('layouts.main')

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">Home</a></li>
            <li class="active">Players</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Players <small>current ranked players</small></h1>
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
                    <h4>Entre em um time</h4>
                    <p>
                        Para entrar em um time, vá para a página do time selecionado e clique em <b>"Entrar"</b>.
                    </p>
                    <p>Uma requisição será enviada para que os responsáveis pelo time aprovem ou não sua entrada.</p>
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

            $('#create-team').click(function() {

                location.href = '{{ route('teams.create') }}';
            });
        });
    </script>
@endsection

