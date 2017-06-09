@extends('layouts.main')

@section('content')
        <!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class="active">Streams</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Streams <small></small></h1>
    <!-- end page-header -->

    <div id="gallery" class="gallery">
        @foreach($streams as $stream)
            <div class="image isotope-item">
                <div class="image-inner">
                    <a href="{{ route('posts.show', [$stream->slug]) }}" data-lightbox="humor" >
                        <img src="{{ getPostImage($stream->image) }}" alt="" />
                    </a>
                    <p class="image-caption">
                        {{ $stream->title }}
                    </p>
                </div>
                <div class="image-info">
                    <h5 class="title">{{ link_to( route('posts.show', [$stream->slug]), $stream->title) }}</h5>
                    <div class="pull-right">
                        <small>by</small> <a href="javascript:;">{{ $stream->name }}</a>
                    </div>
                    <div class="rating">
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star active"></span>
                        <span class="star active"></span>
                    </div>
                    <div class="desc">

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