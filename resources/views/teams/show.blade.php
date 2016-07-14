@extends('layouts.main')

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        <!-- begin breadcrumb -->
        <ol class="breadcrumb pull-right">
            <li><a href="javascript:;">Home</a></li>
            <li class="active">Team Profile</li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">Team Profile <small> this team is looking really good...</small></h1>
        <!-- end page-header -->
        <!-- begin profile-container -->
        <div class="profile-container">
            <!-- begin profile-section -->
            <div class="profile-section">
                <!-- begin profile-left -->
                <div class="profile-left">
                    <!-- begin profile-image -->
                    <div class="profile-image">
                        <img src="{{ getTeamAvatar($team->image) }}" />
                        <i class="fa fa-team hide"></i>
                    </div>
                    <!-- end profile-image -->
                    <div class="m-b-10">
                    @if(\Illuminate\Support\Facades\Auth::check() && \App\User::isOnTeam($team->id))
                        {!! Form::open(array('url'=> 'teams/upload','method'=>'POST', 'files'=>true, 'id' => 'form-upload-picture')) !!}
                            @if(Session::has('error'))
                                <p class="errors">{!! Session::get('error') !!}</p>
                            @endif
                            <div class="btn btn-warning btn-block btn-sm" id="change-picture">Change Picture</div>
                            <input type="file" name="image" style="opacity: 0" id="upload-picture">
                            <input type="hidden" name="team_id" value="{{ $team->id }}">
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
                                        <h4>{{ $team->title }} <small></small></h4>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr class="highlight">
                                        <td class="field">Descrição</td>
                                        <td class="">{{ $team->description }}</td>
                                    </tr>
                                    <tr>
                                        <td class="field">Entrar</td>
                                        <td class="">
                                            @if(!\App\User::isOnTeam($team->id) && \App\Request::userCanRequest($team->id))
                                                <button type="button" class="btn btn-info btn-xs" id="request-join">Solicitar</button>
                                            @else
                                                Você já solicitou ou não pode entrar neste time.
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="highlight">
                                        <td class="field" colspan="2"><h4>Roster</h4></td>
                                    </tr>
                                    <tr class="divider">
                                        <td colspan="2"></td>
                                    </tr>
                                    @foreach($team->users as $player)
                                        <tr>
                                            <td class="field">
                                                <a href="{{ route('users.show',[$player->slug]) }}">
                                                    <img src="{{ getUserAvatar($player->avatar) }}" width="80px">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('users.show',[$player->slug]) }}">
                                                    {{ $player->name }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="divider">
                                        <td colspan="2"></td>
                                    </tr>
                                    @if (\App\User::isOnTeam($team->id))
                                        <tr class="highlight">
                                            <td class="field" colspan="2"><h4>Requisições</h4></td>
                                        </tr>
                                        <tr class="divider">
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr class="">
                                            <td class="field">Atenção</td>
                                            <td class="">Apenas integrantes do time visualizam as requisições.</td>
                                        </tr>
                                        @foreach($team->requests as $request)
                                            <tr>
                                                <td class="field">
                                                    <img src="{{ getUserAvatar($request->user->avatar) }}" width="80px"></td>
                                                <td>
                                                    <a href="{{ route('users.show',[$request->user->slug]) }}">
                                                        {{ $request->user->name }}
                                                    </a>
                                                    @if ($request->aproved)
                                                        <span>Aprovado</span>
                                                    @else
                                                        <button type="button" class="btn btn-xs btn-info btn-right"
                                                            id="aprove-request" data-user="{{ $request->user->id }}">Aprovar</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>

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

        $('#request-join').click(function() {

            var team_id = '{{ $team->id }}';

            requestJoinTeam(team_id);
        });

        $('#aprove-request').click(function () {

            var user_id = $(this).data('user');

            var team_id = '{{ $team->id }}';

            aproveRequest(user_id, team_id);
        });

        @if($team->gamer)
            $('#update-gamer').click(function() {
                var battletag = '{{ $team->gamer->battletag }}';

                ativarJogador( battletag );
            });
        @endif
    </script>
@endsection

