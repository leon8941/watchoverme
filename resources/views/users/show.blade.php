@extends('layouts.main')

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">Home</a></li>
            <li class="active">User Profile</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">User Profile <small> you are looking good...</small></h1>
        <!-- end page-header -->
        <!-- begin profile-container -->
        <div class="profile-container">
            <!-- begin profile-section -->
            <div class="profile-section">
                <!-- begin profile-left -->
                <div class="profile-left">
                    <!-- begin profile-image -->
                    <div class="profile-image">
                        <img src="{{ getUserAvatar($user->avatar) }}" />
                        <i class="fa fa-user hide"></i>
                    </div>
                    <!-- end profile-image -->
                    <div class="m-b-10">
                        @if (\Illuminate\Support\Facades\Auth::user()->id == $user->id)
                            {!! Form::open(array('url'=> 'users/upload','method'=>'POST', 'files'=>true, 'id' => 'form-upload-picture')) !!}
                                @if(Session::has('error'))
                                    <p class="errors">{!! Session::get('error') !!}</p>
                                @endif
                                <div class="btn btn-warning btn-block btn-sm" id="change-picture">Change Picture</div>
                                <input type="file" name="image" style="opacity: 0" id="upload-picture">
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
                <!-- end profile-left -->
                <!-- begin profile-right -->
                <div class="profile-right">
                    <!-- begin profile-info -->
                    <div class="profile-info">
                        <!-- begin table -->
                        <div class="table-responsive">
                            <table class="table table-profile">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>
                                        <h4>{{ $user->name }} <small></small></h4>
                                    </th>
                                </tr>
                                </thead>
                                @if($user->gamer)
                                <tbody>
                                    <tr class="highlight">
                                        <td class="field">Battle Tag</td>
                                        <td><a href="#">{{ $user->gamer->battletag }}</a></td>
                                    </tr>
                                    <tr class="highlight">
                                        <td class="field">Time</td>
                                        <td>
                                            @if ($user->team->count() >1)
                                                @foreach($user->team as $team)
                                                    <a href="{{ route('teams.show',[$team->slug]) }}">
                                                        {{ $team->title }}
                                                    </a>
                                                @endforeach
                                            @elseif (isset($user->team) && $user->team->count() == 1)
                                                <a href="{{ route('teams.show',[$user->team->first()->slug]) }}">
                                                    <img src="{{ getTeamAvatar($user->team->first()->image) }}" width="100px">
                                                    {{ $user->team->first()->title or 'nenhum' }}
                                                </a>
                                            @else
                                                nenhum
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="highlight">
                                        <td>Gamer Profile</td>
                                        <td>
                                            @if (\Illuminate\Support\Facades\Auth::user()->id == $user->id)
                                                <button class="btn btn-info btn-xs" id="update-gamer">Update</button>
                                                <br>
                                            @else
                                                Ativo
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="highlight">
                                        <td class="field" colspan="2"><h4>General</h4></td>
                                    </tr>
                                    <tr class="divider">
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Avatar</td>
                                        <td><img src="{{ $user->gamer->avatar }}" width="68px"> </td>
                                    </tr>
                                    <tr>
                                        <td class="field">Level</td>
                                        <td>{{ $user->gamer->level }}</td>
                                    </tr>
                                    <tr class="divider">
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr class="highlight">
                                        <td class="field" colspan="2"><h4>Competitive</h4></td>
                                    </tr>
                                    <tr class="divider">
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Rank</td>
                                        <td>{{ $user->gamer->competitive_rank }}</td>
                                    </tr>
                                    <tr>
                                        <td class="field">Wins</td>
                                        <td>{{ $user->gamer->competitive_wins }}</td>
                                    </tr>
                                    <tr>
                                        <td class="field">Lost</td>
                                        <td>{{ $user->gamer->competitive_lost }}</td>
                                    </tr>
                                    <tr>
                                        <td class="field">Played</td>
                                        <td>{{ $user->gamer->competitive_played }}</td>
                                    </tr>
                                    <tr>
                                        <td class="field">Play Time</td>
                                        <td>{{ $user->gamer->competitive_playtime }}</td>
                                    </tr>
                                    <tr class="divider">
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr class="highlight">
                                        <td class="field" colspan="2"><h4>Quick Match</h4></td>
                                    </tr>
                                    <tr class="divider">
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td class="field">Wins</td>
                                        <td>{{ $user->gamer->quick_wins }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="field">Lost</td>
                                        <td>{{ $user->gamer->quick_lost }}</td>
                                    </tr>
                                    <tr>
                                        <td class="field">Played</td>
                                        <td>{{ $user->gamer->quick_played }}</td>
                                    </tr>
                                    <tr>
                                        <td class="field">Play Time</td>
                                        <td>{{ $user->gamer->quick_playtime }}</td>
                                    </tr>

                                </tbody>
                                @else
                                    <tbody>
                                    <tr class="highlight">
                                        <td colspan="2">Este usuário ainda não está ativo como um jogador.</td>
                                    </tr>
                                    @if (\Illuminate\Support\Facades\Auth::user()->slug == $user->slug)
                                        <tr class="highlight">
                                            <td>Gamer Profile</td>
                                            <td><a href="#modal-activate-player" class="btn btn-info btn-xs" data-toggle="modal">Ativar</a>
                                                <!-- #modal-activate-player -->
                                                <div class="modal fade" id="modal-activate-player">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h4 class="modal-title">Ativar Jogador</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label class="col-md-3 control-label">Battle Tag:</label>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="battletag" id="battletag"
                                                                               class="form-control" placeholder="verme#2424">
                                                                    </div>
                                                                    <br><br><br>
                                                                    <div class="alert alert-danger" id="gamer_activation_error_panel" style="display: none">
                                                                        <ul id="gamer_activation_error_msg">
                                                                        </ul>
                                                                    </div>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Fechar</a>
                                                                <a href="javascript:;" class="btn btn-sm btn-success" id="ativar-jogador">Ativar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br><br>
                                                <div class="note note-success">
                                                    <p>
                                                        Ao ativar seu perfil de gamer, você irá importar seus dados e
                                                        estatísticas do Overwatch, e autorizar a visualização e inclusão
                                                        do seu perfil de jogador no WatchOverMe.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            </table>
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
        });

        $('#ativar-jogador').click(function() {

            var battletag = $('#battletag').val();

            // Ativa
            if ( ativarJogador( battletag ) ) {

            }
            else {

            }
        });

        $('#change-picture').click(function() {
            $('#upload-picture').click();
            return false;
        });

        $('#upload-picture').change(function() {
            $('#form-upload-picture').submit();
        });

        @if($user->gamer)
            $('#update-gamer').click(function() {
                var battletag = '{{ $user->gamer->battletag }}';

                ativarJogador( battletag );
            });
        @endif
    </script>
@endsection

