@extends('layouts.main')

@section('content')
        <!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">InHouse</a></li>
        <li class="active">Entrar</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Entrar na InHouse</h1>
    <!-- end page-header -->
    <!-- begin profile-container -->
    <div class="profile-container" style="margin-left: 4%; margin-right: 16%;">
        <!-- begin profile-section -->
        <div class="profile-section">
            <!-- begin profile-left -->
            <div class="post-left">
                <!-- begin profile-image -->
                <div class="post-image">
                    <img src="{{ asset('img/competitive-esports.jpg') }}" width="272px">
                    <i class="fa fa-user hide"></i>
                </div>
                <!-- end profile-image -->
                <!-- begin profile-highlight -->
                <div class="profile">
                </div>
                <!-- end profile-highlight -->
            </div>
            <!-- end profile-left -->
            <!-- begin profile-right -->
            <div class="profile-right">
                <!-- begin profile-info -->
                <div class="profile-info">
                    <!-- begin table -->
                    <div class="table-responsive">
                        <div class="article-header">
                            <h4>Como entrar na InHouse</h4>
                        </div>
                        <div class="article-text">
                            <p>A <b>InHouse do Verme</b> é o maior e melhor núcleo competitivo de <b>Overwatch</b> do Brasil.</p>
                            <p>Aqui você aprimora suas skills de jogador, conhece os melhores jogadores do país,
                            recebe feedbacks com análises refinadas da sua performance, dentre outras inúmeras vantagens.</p>
                            <p>Para mantermos o nível competitivo alto, temos um filtro para a entrada de novos jogadores.</p>
                            <p>Apenas jogadores que já estão na InHouse, e que possuem um <b>Vouch</b>, podem te convidar para participar.</p>
                            <p><b>Caso você ainda não tenha um Voucher</b>, você pode colocar o seu nome na fila de espera, na esperança de que uma boa alma te convide.</p>
                            <br>
                            <p><button type="button" class="btn btn-info" id="entrar_fila">Entrar na Fila</button> </p>
                            <br>
                            <br>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Vouch</th>
                                    </tr>
                                    </thead>
                                <tbody>
                                @foreach($fila_espera as $fila)
                                    <tr>
                                        <td>{{ $fila->id }}</td>
                                        <td>{{ $fila->user->name }}</td>
                                        <td>{{ $fila->received }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <!-- end table -->
                </div>
                <!-- end profile-info -->
            </div>
            <!-- end profile-right -->
        </div>
        <!-- end profile-section -->

    </div>
    <!-- end profile-container -->
</div>
<!-- end #content -->

@endsection

@section('scripts')


    <script>
        $(document).ready(function() {
            App.init();

            $('#entrar_fila').click(function () {
                alert('A fila de espera será ativada em: \n15/08/2016');
            });
        });
    </script>
@endsection
