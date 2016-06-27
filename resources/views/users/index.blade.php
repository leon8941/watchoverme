@extends('layouts.manager')

@section('content')
    <!-- Top Bar starts -->
    <div class="top-bar">
        <div class="page-title">
            Management
        </div>
    </div>
    <!-- Top Bar ends -->

    <!-- Main Container starts -->
    <div class="main-container">

        <!-- Container fluid starts -->
        <div class="container-fluid">
            <!-- Spacer starts -->
            <div class="spacer">

                <!-- Row Starts -->
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- Widget starts -->
                        <div class="blog">
                            <div class="blog-header">
                                <div class="text-left" style="float:left">
                                    <h5 class="blog-title">Users / Technicians</h5>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-info btn-rounded" id="new">New</button>
                                </div>
                                @if (session('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @endif
                            </div>
                            <div class="blog-body">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        {!! $grid !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Widget ends -->
                    </div>
                </div>
                <!-- Row Ends -->

            </div>
            <!-- Spacer ends -->
        </div>
        <!-- Container fluid ends -->

    </div>
    <!-- Main Container ends -->

    <!-- Right sidebar starts -->
    <div class="right-sidebar">


    </div>
    <!-- Right sidebar ends -->
@endsection

@section('footer')

    <script>
        $('#new').click(function(){
            location.href = '{{ route('users.create') }}';
        });

        $('.edit-entity').click(function(){

            var ref = $(this).data('ref');

            location.href = ref;
        });

        // View all function
        $('#show-all').click(function() {
            location.href = '{{ route('users.index', ['all' => true]) }}';
        });

        // View default
        $('#show-clean').click(function(){
            location.href = '{{ route('users.index') }}';
        });
    </script>
@endsection
