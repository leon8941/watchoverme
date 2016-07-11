@extends('layouts.main')

@section('content')
        <!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">News</a></li>
        <li class="active">{{ $post->title }}</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">{{ $post->title }} </h1>
    <!-- end page-header -->
    <!-- begin profile-container -->
    <div class="profile-container" style="margin-left: 4%; margin-right: 16%;">
        <!-- begin profile-section -->
        <div class="profile-section">
            <!-- begin profile-left -->
            <div class="post-left">
                <!-- begin profile-image -->
                <div class="post-image">
                    <img src="{{ asset($post->image) }}" width="272px">
                    <i class="fa fa-user hide"></i>
                </div>
                <!-- end profile-image -->
                <!-- begin profile-highlight
                <div class="profile-highlight">
                    <h4><i class="fa fa-cog"></i> Only My Contacts</h4>
                    <div class="checkbox m-b-5 m-t-0">
                        <label><input type="checkbox" /> Show my timezone</label>
                    </div>
                    <div class="checkbox m-b-0">
                        <label><input type="checkbox" /> Show i have 14 contacts</label>
                    </div>
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
                        <h4>{!! $post->description !!}</h4>
                        {!! $post->text !!}
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

    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="assets/js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
@endsection
