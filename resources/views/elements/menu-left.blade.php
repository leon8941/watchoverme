
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                @if (Auth::check())

                    <div class="image">
                        <a href="{{ route('users.show',[ \Illuminate\Support\Facades\Auth::user()->id]) }}">
                            <img src="{{ asset('assets/img/user-13.jpg') }}" alt="" />
                        </a>
                    </div>
                    <div class="info">
                        <a href="{{ route('users.show',[\Illuminate\Support\Facades\Auth::user()->id]) }}">
                            {{ \Illuminate\Support\Facades\Auth::user()->name }}
                        </a>
                    </div>
                @else
                    <div class="info">
                        <a class="" href="{{ url('auth/login') }}">
                            Faça Login
                        </a>
                    </div>
                @endif
            </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav">
            <li class="nav-header">Navigation</li>
            <li class=" active">
                <a href="{{ route('home') }}">
                    <i class="fa fa-laptop"></i>
                    <span>Home</span>
                </a>
            </li>
            <!--
            <li class="has-sub">
                <a href="{{ route('gamers.index') }}">
                    <i class="fa fa-users"></i>
                    <span>Players</span>
                </a>
            </li>
            -->
            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>