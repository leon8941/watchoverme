@extends('layouts.main')

@section('content')
        <!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">News</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <!-- end page-header -->
    <!-- begin profile-container -->
    <div class="profile-container" style="margin-left: 4%; margin-right: 16%;">
        <!-- begin profile-section -->
        <div class="profile-section">
            <!-- begin profile-left -->
            <div class="post-left">
                <!-- begin profile-image -->
                <div class="post-image">
                    <i class="fa fa-user hide"></i>
                </div>
            </div>
            <!-- end profile-left -->
            <!-- begin profile-right -->
            <div class="profile-right">
                <!-- begin profile-info -->
                <div class="profile-info">
                    <!-- begin table -->
                    <div class="table-responsive">
                        <div class="article-header">
                            Tests
                        </div>
                        <div class="article-text">
                            <input type="text" id="command">
                            <button type="button" class="btn btn-info" id="send">enviar</button>
                            <br>
                            <div id="return" style="width: 100%; height: 150px"></div>
                            <br>
                            <ul>
                                <li>/start</li>
                                <li>/cancel</li>
                                <li>/close</li>
                                <li>/join</li>
                                <li>/leave</li>
                                <li>/contest</li>
                            </ul>
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


    <script>
        $(document).ready(function() {
            App.init();

            $('#send').click(function () {
                var command = $('#command').val();

                sendMessage(command);
            });
        });

        function sendMessage(msg) {

            var gamer_id = '1';

            $.ajax({
                url: "{{ route('messages') }}",
                dataType: "html",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    gamer_id: gamer_id,
                    test: '1',
                    message: msg
                }
            }).done(function(data) {

                var obj = JSON.parse(data);

                $('#return').html(obj.code + ' - ' + obj.message);
            });
        }
    </script>
@endsection
