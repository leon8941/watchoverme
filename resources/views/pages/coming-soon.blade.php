<!DOCTYPE html>
<html lang="en">

<!-- {{ \Illuminate\Support\Facades\Config::get('custom.html_developer_description') }} -->
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- start: Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- end: Mobile Specific -->

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <link href="{{ asset('assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/css/style-responsive.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('assets/css/theme/default.css') }}" rel="stylesheet" type="text/css" id="theme">
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE CSS STYLE ================== -->
    <link href="{{ asset('assets/plugins/jquery.countdown/jquery.countdown.css') }}" rel="stylesheet" type="text/css">
    <!-- ================== END PAGE CSS STYLE ================== -->


    <!-- ================== BEGIN BASE JS ================== -->
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/pace/pace.min.js') }}"></script>
    <!-- ================== END BASE JS ================== -->

    <link rel="shortcut icon" href="img/favicon.ico">

    <title>Watch Over Me</title>

</head>
<body class="bg-white p-t-0 pace-top">

<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin coming-soon -->
    <div class="coming-soon">
        <div class="coming-soon-header">
            <div class="bg-cover"></div>
            <div class="brand">
                <img src="{{ asset('img/overwatch.png') }}" width="70px"> WatchOver Me
            </div>
            <div class="timer">
                <div id="timer"></div>
            </div>
            <div class="desc">
                Nosso site está quase pronto e fornecerá boas ferramentas <br />para a comunidade de <b>OverWatch</b> brasileira.
            </div>
        </div>
        <div class="coming-soon-content">
            <div class="desc">
                Cadastre-se agora para receber <b>benefícios</b> no lançamento.
            </div>
            <div class="input-group">
                <input type="text" class="form-control" id="email" placeholder="Email Address" />
                <div class="input-group-btn">
                    <button type="button" class="btn btn-success" id="subscribe-go">Quero</button>
                </div>
            </div>
            <p class="help-block m-b-25"><i>Não fazemos spam. Seu email está seguro conosco.</i></p>

        </div>
    </div>
    <!-- end coming-soon -->

</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/jquery/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/jquery/jquery-migrate-1.1.0.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!--[if lt IE 9]>
<script type="text/javascript" src="{{ URL::asset('assets/crossbrowserjs/html5shiv.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/crossbrowserjs/respond.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/crossbrowserjs/excanvas.min.js') }}"></script>
<![endif]-->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/jquery-cookie/jquery.cookie.js') }}"></script>
<!-- ================== END BASE JS ================== -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/jquery.countdown/jquery.plugin.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/jquery.countdown/jquery.countdown.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/coming-soon.demo.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/apps.min.js') }}"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        ComingSoon.init();

        $('#subscribe-go').click(function () {

            var email = $('#email').val();

            if (email.length <= 5) {
                alert('Por favor, digite um email válido!');
            }
            else {
                // Get the user profile
                $.ajax({
                    url: "{{ route('pages.subscribe') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email
                    },
                }).done(function(data) {

                    alert('Agradecemos seu cadastro!\nVocê receberá em breve um email com novas informações.');
                });
            }

        });
    });
</script>

    @if (getenv('APP_ENV') == 'production')
        <script type="text/javascript" src="{{ URL::asset('js/analytics/analytics.js') }}"></script>
    @endif

</body>

</html>


