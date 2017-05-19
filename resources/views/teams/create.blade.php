@extends('layouts.main')

@section('content')
        <!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Times</a></li>
        <li class="active">Criar Time</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Criar Time <small>faz acontecer mlk...</small></h1>
    <!-- end page-header -->

    <div class="panel panel-inverse" data-sortable-id="index-4">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            <h4 class="panel-title">Criar Time</h4>
        </div>
        {!! Form::open(array('route' => 'teams.store', 'id' => 'form-team', 'class' => 'form-horizontal')) !!}
            <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-horizontal">
                    <div class="form-group">
                        {!! Form::label('title', 'Nome*', array('class'=>'col-sm-2 control-label')) !!}
                        <div class="col-md-9">
                            {!! Form::text('title', old('title'), array('class'=>'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('description', 'Descrição', array('class'=>'col-sm-2 control-label')) !!}
                        <div class="col-md-9">
                            <textarea class="form-control no-rounded-corner bg-silver" rows="4" name="description">Descrição do time...
                            Descreva os horários de treinos e objetivos do time...
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="note note-success">
                    <h3>Atenção</h3>
                    <p>
                        Seu time será criado e aparecerá na lista de times.
                    </p>
                    <p>Para incluir jogadores no time, envie o link do perfil do time para que o jogador acesse e solicite a entrada.</p>
                    <p>Em seguida, basta que você ou qualquer integrante do time aprove a entrada do jogador.</p>
                </div>
            </div>

            <div class="panel-footer text-right">
                <button type="submit" class="btn btn-primary btn-sm m-l-5">Criar</button>
            </div>
        {!! Form::close() !!}
    </div>
</div>
<!-- end #content -->
@endsection

@section('scripts')
    @include('elements.scripts')
    <script>
        $(document).ready(function() {
            App.init();
        });

    </script>
@endsection

