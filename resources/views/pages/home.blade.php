@extends('layouts.main')

@section('content')
        <!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class="active">News</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">News <small></small></h1>
    <!-- end page-header -->

    <div id="options" class="m-b-10">
        <span class="gallery-option-set" id="filter" data-option-key="filter">
            <a href="#show-all" class="btn btn-default btn-xs active" data-option-value="*">
                Show All
            </a>
        </span>
    </div>
    <div id="gallery" class="gallery">
        @foreach($posts as $post)
            <div class="image gallery-group-1">
                <div class="image-inner">
                    <a href="{{ route('posts.show', [$post->slug]) }}" >
                        <img src="{{ asset($post->image) }}" alt="" />
                    </a>
                    <p class="image-caption">
                        {{ $post->title }}
                    </p>
                </div>
                <div class="image-info">
                    <h5 class="title">{{ link_to( route('posts.show', [$post->slug]), $post->title) }}</h5>
                    <div class="pull-right">
                        <small>by</small> <a href="javascript:;">{{ $post->user->name }}</a>
                    </div>
                    <div class="rating">
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star active"></span>
                    </div>
                    <div class="desc">
                        {!! substr($post->text,0, 126) !!} ...
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
<!-- end #content -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/isotope/jquery.isotope.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/lightbox/js/lightbox-2.6.min.js') }}"></script>
    <script src="{{ asset('assets/js/gallery.demo.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            App.init();
            Gallery.init();
        });
    </script>
@endsection