
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                @if (Auth::check())
                    <div class="image">
                        <a href="{{ route('users.show',[ \Illuminate\Support\Facades\Auth::user()->slug]) }}">
                            <img src="{{ getUserAvatar(\Illuminate\Support\Facades\Auth::user()->avatar) }}"
                                 alt="{{ \Illuminate\Support\Facades\Auth::user()->name }}" />
                        </a>
                    </div>
                    <div class="info">
                        <a href="{{ route('users.show',[\Illuminate\Support\Facades\Auth::user()->slug]) }}">
                            {{ \Illuminate\Support\Facades\Auth::user()->name }}
                        </a>
                    </div>
                @else
                    <div class="info">
                        <a class="" href="{{ url('login') }}">
                            Faça Login
                        </a>
                        |
                        <a class="" href="{{ url('register') }}">
                            Registrar
                        </a>
                    </div>
                @endif
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav">
            <li class="nav-header">Navigation</li>
            <li class="has-sub {{ isActive('home') }}">
                <a href="javascript:;">
                    <b class="caret pull-right"></b>
                    <i class="fa fa-laptop"></i>
                    <span>Dashboard</span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ isActive('home') }}"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="{{ isActive('posts') }}"><a href="{{ route('posts.index') }}">Notícias</a></li>
                </ul>
            </li>
            <li class="{{ isActive('events') }}">
                <a href="{{ route('events.index') }}">
                    <i class="fa fa-trophy"></i>
                    <span>Eventos</span>
                </a>
            </li>
            <li class="{{ isActive('gamers') }}">
                <a href="{{ route('gamers.index') }}">
                    <i class="fa fa-star"></i>
                    <span>Rankings</span>
                </a>
            </li>
            <li class="{{ isActive('gamers') }}">
                <a href="{{ route('gamers.streams') }}">
                    <i class="fa fa-twitch"></i>
                    <span>LIVE Streams</span>
                </a>
            </li>
            <li class="{{ isActive('teams') }}">
                <a href="{{ route('teams.index') }}">
                    <i class="fa fa-users"></i>
                    <span>Times</span>
                </a>
            </li>
            <li class="{{ isActive('about') }}">
                <a href="{{ route('about') }}">
                    <i class="fa fa-heart"></i>
                    <span>NerfThis</span>
                </a>
            </li>
            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>