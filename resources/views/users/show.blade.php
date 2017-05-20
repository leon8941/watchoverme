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
                        @if (Auth::check() && Auth::user()->id == $user->id)
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
                                            @if (Auth::check() && Auth::user()->id == $user->id)
                                                <button class="btn btn-info btn-xs" id="update-gamer">Update</button>
                                                <br>
                                                <span class=""
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

            <!-- begin profile-section -->
            <div class="profile-section">
                <!-- begin row -->
                <div class="row">
                    <!-- begin col-4 -->
                    <div class="col-md-4">
                        <h4 class="title">Mensagens <small>0 messages</small></h4>
                        <!-- begin scrollbar -->
                        <div data-scrollbar="true" data-height="280px" class="bg-silver">
                            <div class="text text-center" style="margin-top: 50px">
                                Em breve
                            </div>
                        </div>
                        <!-- end scrollbar -->
                    </div>
                    <!-- end col-4 -->
                    @if ($user->stats)
                        <!-- begin col-4 -->
                        <div class="col-md-4">
                            <h4 class="title">Quick-Match <small>stats all heroes</small></h4>
                            <!-- begin scrollbar -->
                            <div data-scrollbar="true" data-height="280px" class="bg-silver">
                                <!-- begin todolist -->
                                <ul class="todolist">
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Medals</div>
                                            <div class="todolist-title">{{ $stats['quick']->Medals }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Medals Gold</div>
                                            <div class="todolist-title"><span class="label label-warning">{{ $stats['quick']->Medals_Gold }}</span></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Medals Silver</div>
                                            <div class="todolist-title"><span class="label label-default">{{ $stats['quick']->Medals_Silver }}</span></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Medals Bronze</div>
                                            <div class="todolist-title"><span class="label label-inverse">{{ $stats['quick']->Medals_Bronze }}</span></div>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="javascript:;" class="todolist-container active" data-click="todolist">
                                            <div class="todolist-input">Melee Final Blows</div>
                                            <div class="todolist-title">{{ $stats['quick']->MeleeFinalBlows }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Solo Kills</div>
                                            <div class="todolist-title">{{ $stats['quick']->SoloKills }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Objective Kills</div>
                                            <div class="todolist-title">{{ $stats['quick']->ObjectiveKills }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Final Blows</div>
                                            <div class="todolist-title">{{ $stats['quick']->FinalBlows }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Damage Done</div>
                                            <div class="todolist-title">{{ $stats['quick']->DamageDone }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Eliminations</div>
                                            <div class="todolist-title">{{ $stats['quick']->Eliminations }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Environmental Kills</div>
                                            <div class="todolist-title">{{ $stats['quick']->EnvironmentalKills }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Multi Kills</div>
                                            <div class="todolist-title">{{ $stats['quick']->Multikills }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Healing Done</div>
                                            <div class="todolist-title">{{ $stats['quick']->HealingDone }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Teleporter Pads Destroyed</div>
                                            <div class="todolist-title">{{ $stats['quick']->TeleporterPadsDestroyed }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Eliminations Most inGame</div>
                                            <div class="todolist-title">{{ $stats['quick']->Eliminations_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Final Blows Most inGame</div>
                                            <div class="todolist-title">{{ $stats['quick']->FinalBlows_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Damage Done Most inGame</div>
                                            <div class="todolist-title">{{ $stats['quick']->DamageDone_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Healing Done Most inGame</div>
                                            <div class="todolist-title">{{ $stats['quick']->HealingDone_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Defensive Assists Most inGame</div>
                                            <div class="todolist-title">{{ $stats['quick']->DefensiveAssists_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Offensive Assists Most inGame</div>
                                            <div class="todolist-title">{{ $stats['quick']->OffensiveAssists_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Objective Kills Most inGame</div>
                                            <div class="todolist-title">{{ $stats['quick']->ObjectiveKills_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Objective Time Most inGame</div>
                                            <div class="todolist-title">{{ $stats['quick']->ObjectiveTime_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Multi kill Best</div>
                                            <div class="todolist-title">{{ $stats['quick']->Multikill_Best }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Solo Kills Most inGame</div>
                                            <div class="todolist-title">{{ $stats['quick']->SoloKills_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Time Spenton Fire Mostin Game</div>
                                            <div class="todolist-title">{{ $stats['quick']->TimeSpentonFire_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Melee Final Blows Average</div>
                                            <div class="todolist-title">{{ $stats['quick']->MeleeFinalBlows_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Time Spent on Fire Average</div>
                                            <div class="todolist-title">{{ $stats['quick']->TimeSpentonFire_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Solo Kills Average</div>
                                            <div class="todolist-title">{{ $stats['quick']->SoloKills_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Objective Time Average</div>
                                            <div class="todolist-title">{{ $stats['quick']->ObjectiveTime_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Objective Kills Average</div>
                                            <div class="todolist-title">{{ $stats['quick']->ObjectiveKills_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Healing Done Average</div>
                                            <div class="todolist-title">{{ $stats['quick']->HealingDone_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Final Blows Average</div>
                                            <div class="todolist-title">{{ $stats['quick']->FinalBlows_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Deaths Average</div>
                                            <div class="todolist-title">{{ $stats['quick']->Deaths_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">DamageDone Average</div>
                                            <div class="todolist-title">{{ $stats['quick']->DamageDone_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Eliminations Average</div>
                                            <div class="todolist-title">{{ $stats['quick']->Eliminations_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Deaths</div>
                                            <div class="todolist-title">{{ $stats['quick']->Deaths }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Environmental Deaths</div>
                                            <div class="todolist-title">{{ $stats['quick']->EnvironmentalDeaths }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Cards</div>
                                            <div class="todolist-title">{{ $stats['quick']->Cards }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Games Won</div>
                                            <div class="todolist-title">{{ $stats['quick']->GamesWon }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Games Played</div>
                                            <div class="todolist-title">{{ $stats['quick']->GamesPlayed }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Time Spent on Fire</div>
                                            <div class="todolist-title">{{ $stats['quick']->TimeSpentonFire }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Objective Time</div>
                                            <div class="todolist-title">{{ $stats['quick']->ObjectiveTime }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Time Played</div>
                                            <div class="todolist-title">{{ $stats['quick']->TimePlayed }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Melee Final Blow Most inGame</div>
                                            <div class="todolist-title">{{ $stats['quick']->MeleeFinalBlow_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Defensive Assists</div>
                                            <div class="todolist-title">{{ $stats['quick']->DefensiveAssists }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Defensive Assists Average</div>
                                            <div class="todolist-title">{{ $stats['quick']->DefensiveAssists_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Offensive Assists</div>
                                            <div class="todolist-title">{{ $stats['quick']->OffensiveAssists }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Offensive Assists Average</div>
                                            <div class="todolist-title">{{ $stats['quick']->OffensiveAssists_Average }}</div>
                                        </a>
                                    </li>
                                </ul>
                                <!-- end todolist -->
                            </div>
                            <!-- end scrollbar -->
                        </div>
                        <!-- end col-4 -->
                        <!-- begin col-4 -->
                        <div class="col-md-4">
                            <h4 class="title">Competitivo <small>stats all heroes</small></h4>
                            <!-- begin scrollbar -->
                            <div data-scrollbar="true" data-height="280px" class="bg-silver">
                                <!-- begin todolist -->
                                <ul class="todolist">
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Medals</div>
                                            <div class="todolist-title">{{ $stats['competitive']->Medals }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Medals Gold</div>
                                            <div class="todolist-title"><span class="label label-warning">{{ $stats['competitive']->Medals_Gold }}</span></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Medals Silver</div>
                                            <div class="todolist-title"><span class="label label-default">{{ $stats['competitive']->Medals_Silver }}</span></div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Medals Bronze</div>
                                            <div class="todolist-title"><span class="label label-inverse">{{ $stats['competitive']->Medals_Bronze }}</span></div>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="javascript:;" class="todolist-container active" data-click="todolist">
                                            <div class="todolist-input">Melee Final Blows</div>
                                            <div class="todolist-title">{{ $stats['competitive']->MeleeFinalBlows }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Solo Kills</div>
                                            <div class="todolist-title">{{ $stats['competitive']->SoloKills }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Objective Kills</div>
                                            <div class="todolist-title">{{ $stats['competitive']->ObjectiveKills }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Final Blows</div>
                                            <div class="todolist-title">{{ $stats['competitive']->FinalBlows }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Damage Done</div>
                                            <div class="todolist-title">{{ $stats['competitive']->DamageDone }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Eliminations</div>
                                            <div class="todolist-title">{{ $stats['competitive']->Eliminations }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Environmental Kills</div>
                                            <div class="todolist-title">{{ $stats['competitive']->EnvironmentalKills }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Multi Kills</div>
                                            <div class="todolist-title">{{ $stats['competitive']->Multikills }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Healing Done</div>
                                            <div class="todolist-title">{{ $stats['competitive']->HealingDone }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Teleporter Pads Destroyed</div>
                                            <div class="todolist-title">{{ $stats['competitive']->TeleporterPadsDestroyed }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Eliminations Most inGame</div>
                                            <div class="todolist-title">{{ $stats['competitive']->Eliminations_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Final Blows Most inGame</div>
                                            <div class="todolist-title">{{ $stats['competitive']->FinalBlows_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Damage Done Most inGame</div>
                                            <div class="todolist-title">{{ $stats['competitive']->DamageDone_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Healing Done Most inGame</div>
                                            <div class="todolist-title">{{ $stats['competitive']->HealingDone_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Defensive Assists Most inGame</div>
                                            <div class="todolist-title">{{ $stats['competitive']->DefensiveAssists_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Offensive Assists Most inGame</div>
                                            <div class="todolist-title">{{ $stats['competitive']->OffensiveAssists_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Objective Kills Most inGame</div>
                                            <div class="todolist-title">{{ $stats['competitive']->ObjectiveKills_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Objective Time Most inGame</div>
                                            <div class="todolist-title">{{ $stats['competitive']->ObjectiveTime_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Multi kill Best</div>
                                            <div class="todolist-title">{{ $stats['competitive']->Multikill_Best }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Solo Kills Most inGame</div>
                                            <div class="todolist-title">{{ $stats['competitive']->SoloKills_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Time Spenton Fire Mostin Game</div>
                                            <div class="todolist-title">{{ $stats['competitive']->TimeSpentonFire_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Melee Final Blows Average</div>
                                            <div class="todolist-title">{{ $stats['competitive']->MeleeFinalBlows_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Time Spent on Fire Average</div>
                                            <div class="todolist-title">{{ $stats['competitive']->TimeSpentonFire_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Solo Kills Average</div>
                                            <div class="todolist-title">{{ $stats['competitive']->SoloKills_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Objective Time Average</div>
                                            <div class="todolist-title">{{ $stats['competitive']->ObjectiveTime_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Objective Kills Average</div>
                                            <div class="todolist-title">{{ $stats['competitive']->ObjectiveKills_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Healing Done Average</div>
                                            <div class="todolist-title">{{ $stats['competitive']->HealingDone_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Final Blows Average</div>
                                            <div class="todolist-title">{{ $stats['competitive']->FinalBlows_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Deaths Average</div>
                                            <div class="todolist-title">{{ $stats['competitive']->Deaths_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">DamageDone Average</div>
                                            <div class="todolist-title">{{ $stats['competitive']->DamageDone_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Eliminations Average</div>
                                            <div class="todolist-title">{{ $stats['competitive']->Eliminations_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Deaths</div>
                                            <div class="todolist-title">{{ $stats['competitive']->Deaths }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Environmental Deaths</div>
                                            <div class="todolist-title">{{ $stats['competitive']->EnvironmentalDeaths }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Cards</div>
                                            <div class="todolist-title">{{ $stats['competitive']->Cards }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Games Won</div>
                                            <div class="todolist-title">{{ $stats['competitive']->GamesWon }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Games Played</div>
                                            <div class="todolist-title">{{ $stats['competitive']->GamesPlayed }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Time Spent on Fire</div>
                                            <div class="todolist-title">{{ $stats['competitive']->TimeSpentonFire }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Objective Time</div>
                                            <div class="todolist-title">{{ $stats['competitive']->ObjectiveTime }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Time Played</div>
                                            <div class="todolist-title">{{ $stats['competitive']->TimePlayed }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Melee Final Blow Most inGame</div>
                                            <div class="todolist-title">{{ $stats['competitive']->MeleeFinalBlow_MostinGame }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Defensive Assists</div>
                                            <div class="todolist-title">{{ $stats['competitive']->DefensiveAssists }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Defensive Assists Average</div>
                                            <div class="todolist-title">{{ $stats['competitive']->DefensiveAssists_Average }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input">Offensive Assists</div>
                                            <div class="todolist-title">{{ $stats['competitive']->OffensiveAssists }}</div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="todolist-container" data-click="todolist">
                                            <div class="todolist-input alert-success">Offensive Assists Average</div>
                                            <div class="todolist-title">{{ $stats['competitive']->OffensiveAssists_Average }}</div>
                                        </a>
                                    </li>
                                </ul>
                                <!-- end todolist -->
                            </div>
                            <!-- end scrollbar -->
                        </div>
                        <!-- end col-4 -->
                    @else
                        <!-- begin col-4 -->
                        <div class="col-md-4">
                            <h4 class="title">Quick Match <small>todos heróis</small></h4>
                            <!-- begin scrollbar -->
                            <div data-scrollbar="true" data-height="280px" class="bg-silver">
                                <!-- begin todolist -->
                                <ul class="todolist">
                                    <li class="">
                                        <a href="javascript:;" class="todolist-container " data-click="todolist">
                                            <div class="todolist-title">Este jogador não tem detalhes estatísticos.</div>
                                        </a>
                                    </li>
                                </ul>
                                <!-- end todolist -->
                            </div>
                            <!-- end scrollbar -->
                        </div>
                        <!-- end col-4 -->
                    <!-- begin col-4 -->
                    <div class="col-md-4">
                        <h4 class="title">Competitivo <small>todos heróis</small></h4>
                        <!-- begin scrollbar -->
                        <div data-scrollbar="true" data-height="280px" class="bg-silver">
                            <!-- begin todolist -->
                            <ul class="todolist">
                                <li class="">
                                    <a href="javascript:;" class="todolist-container " data-click="todolist">
                                        <div class="todolist-title">Este jogador não tem detalhes estatísticos.</div>
                                    </a>
                                </li>
                            </ul>
                            <!-- end todolist -->
                        </div>
                        <!-- end scrollbar -->
                    </div>
                    <!-- end col-4 -->
                    @endif
                </div>
                <!-- end row -->
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

