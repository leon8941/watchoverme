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
            </div>
        </div>
    </div>
    <!-- end #content -->

@endsection