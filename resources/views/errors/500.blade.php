@extends('layouts.main')

@section('content')

    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">Errors</a></li>
            <li class="active">Error</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Ooops! <small>algum verme aconteceu ...</small></h1>
        <!-- end page-header -->

        <div class="panel panel-inverse">

            <div class="panel-body">
                Dica: Jamais contrarie OVerme
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