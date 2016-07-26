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
                            <h4>Convidar para InHouse</h4>
                        </div>
                        <div class="article-text">
                            <p>Mantenha o alto padrão da <b>InHouse</b>.</p>
                            <p>Convide apenas jogadores que você sabe que irão se comportar, e que tenha um bom nível competitivo. </p>
                            <br>
                            <!-- begin col-12 -->
                            <div class="col-md-12">
                                <div class="alert alert-warning fade in m-b-15">
                                    <strong>Atenção!</strong>
                                    Jogadores que tiverem um mal comportamento serão banidos junto com seu Voucher (quem o convidou).
                                    <span class="close" data-dismiss="alert">×</span>
                                </div>
                                <br>
                                @if (!$vouchs || $vouchs <= 0)
                                    <!-- begin panel -->
                                    <div class="alert alert-warning fade in m-b-15">
                                        <strong>No Vouchs!</strong>
                                        Você tem 0 vouchs.
                                        <span class="close" data-dismiss="alert">×</span>
                                    </div>
                                    <!-- end panel -->
                                @else
                                    <h4>Selecione quem deseja convidar:</h4>
                                    <!-- begin panel -->
                                    <div class="panel panel-inverse" data-sortable-id="table-basic-4">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Jogadores</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                {!! $grid !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end panel -->
                                @endif
                            </div>
                            <!-- end col-12 -->
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
    @include('elements.scripts')
    <script>
        $(document).ready(function() {
            App.init();

            $('.convidar_user').click(function () {

                var gamer_id = $(this).data('gamer');

                inviteGamerToInhouse(gamer_id, this );
            });
        });
    </script>
@endsection
