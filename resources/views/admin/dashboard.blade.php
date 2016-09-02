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
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">Como Postar</div>
                        </div>
                        <div class="portlet-body">
                            <p>Oi pessoal sou o Jhon “Opactor”, vou dar algumas dicas que eu conheço de responsividade em
                            post que contenha ( imagens, vídeos, tabelas, iframe e etc). Vou tentar ser direto e simples
                            na explicação resumindo tudo antes para quem já tem um conhecimento sobre.</p>
                            <br>
                            Vou usar como base esta postagem que fiz:<br>
                            <a href="http://www.watchoverme.com.br/posts/revelado-os-times-overwatch-world-cup"
                               target="blank">Link do post</a>
                            <br><br>
                            <b>Resumo de tudo:</b> Seja qual for o tamanho em px da width (largura) substitua por “100%”
                            <br><br>
                            Exemplo :<br>
                            width: 500px<br>
                            width:100%<br>
                            width="500"<br>
                            width="100%"<br>
                            <br><br>
                            Imagens: Por padrão as imagens usam “ px ” na largura e na altura (width, height) devemos usar “ 100% ” fazendo a imagem se ajustar respeitando o espaço do post detalhe ignoramos a altura.
                            <br><br>
                            Vídeo:  No caso do vídeo deve-se utilizar “ px ” na altura e “100%” na largura por ele ser um iframe.
                            <br><br>
                            Tabela:  Na tabela usamos a mesma ideia da imagem de forma substituindo “ px ” por “100%”
                            <br><br>
                            ----Fim do Resumo----
                            <br><br>
                            <h3>Imagens</h3>
                            <br>
                            Padrão: Dessa forma <b>não temos responsividade</b> nenhuma fazendo a imagem fica cortada ou até passar do post
                            <img alt="" src="https://s20.postimg.io/qzr6ugdst/post_cup_overwatch.png" />
                            <br><br>

                            <b>Responsivo:</b> Veja abaixo o código que usei na postagem
                            <img src="https://s20.postimg.io/qzr6ugdst/post_cup_overwatch.png" style="margin:0px; width:100%" />
                            Para deixa a imagem responsiva usei apenas (width:100% ) oque acontece e que se a imagem tiver um tamanho X seja ela maior ou menor que o espaço do post o ( width:100%) vai força a imagem a se ajustar automaticamente.
                            Usei (margin:0px) para deixa ela sem espaço, por precaução apenas.

                            <h3>Vídeos</h3>
                            Youtube<br>
                            <iframe frameborder="0" height="400" src="https://www.youtube.com/embed/6WFlSvF19hU" width="100%"></iframe>
                            <br>
                            Facebook <br>
                            <iframe src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2FOverwatchBrasil%2Fvideos%2F1037991372986996%2F&show_text=0&width=auto" width="100%" height="400" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>
                            Com o Facebook devemos deixar o width em azul em “auto” ao inves de “100%”.
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