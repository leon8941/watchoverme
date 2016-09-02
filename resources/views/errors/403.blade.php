@extends('layouts.main')

@section('content')

    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">Errors</a></li>
            <li class="active">Forbidden</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Forbidden! <small>onde vai?</small></h1>
        <!-- end page-header -->

        <div class="panel panel-inverse">

            <div class="panel-body">
                <div class="note note-danger">
                    <p>Seu verme imundo. Onde pensa que vai?</p>
                    <p>Você não tem permissão pra fazer isso.</p>
                </div>
            </div>
        </div>
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
                    <h4>Permissão</h4>
                    <p>
                        Caso você queira permissão para fazer alguma tarefa específica no Watch OVerme, contate-nos
                        enviando um email para {{ 'staff@watchoverme.com.br' }} .
                        <br><br>Ficaremos contentes em receber mais um verme
                        na família.
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
        });
    </script>
@endsection