@extends('admin.layouts.master')

@section('content')

        <!-- begin #content -->
    <div id="content" class="content">
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Bem Vindo</h1>
        <!-- end page-header -->

        <div class="panel panel-inverse">
            <div class="panel-body">
                <p>Você está no painel administrativo do Verme.</p>
                <p>Você pode:</p>
                <ul>
                    <li><a href="{{ url('admin/posts') }}">Postar uma notícia</a></li>
                    <li><a href="{{ url('home') }}">Voltar para o site</a></li>
                </ul>
                <hr>
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">Maiores Colaboradores</div>
                    </div>
                    <div class="portlet-body">
                        <div id="datatable_wrapper" class="dataTables_wrapper no-footer">
                            <div id="datatable_filter" class="dataTables_filter"></div>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Colaborador</th>
                                    <th>Artigos</th>
                                </tr>
                                </thead>
                                <tbody id="colaborators_list">
                                </tbody>
                            </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end #content -->

    <script src="{{ asset('assets/plugins/jquery/jquery-1.9.1.min.js') }}"></script>
    @include('elements.scripts')

    <script>
        $(function() {

            getColaborators();
        });
    </script>
@endsection