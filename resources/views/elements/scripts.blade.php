
<script>
    function ativarJogador( battletag ) {

        $('#gamer_activation_error_panel').hide();

        $.ajax({
            url: "{{ route('gamers.activate') }}",
            dataType: "html",
            type: "GET",
            data: {
                battletag: battletag,
                _token: '{{ csrf_token() }}',
            }
        }).done(function(data) {

            //console.debug(data);

            var obj = JSON.parse(data);

            if (obj.code != '1') {

                $('#gamer_activation_error_panel').show();
                $('#gamer_activation_error_msg').html(obj.msg);

            }
            else {
                alert('Gamer atualizado com sucesso.');
                $('.close').click();

                setTimeout(function(){
                    location.reload();
                }, 600);
            }

        });
    }


    function requestJoinTeam( team_id ) {

        $.ajax({
            url: "{{ route('teams.request') }}",
            dataType: "html",
            type: "GET",
            data: {
                team_id: team_id,
                _token: '{{ csrf_token() }}',
            }
        }).done(function(data) {

            console.debug(data);

            //var obj = JSON.parse(data);

            if (data) {

                setTimeout(function(){
                    location.reload();
                }, 400);
            }
        });
    }

    function aproveRequest(user_id, team_id) {

        $.ajax({
            url: "{{ route('teams.aproveRequest') }}",
            dataType: "html",
            type: "GET",
            data: {
                user_id: user_id,
                team_id: team_id,
                _token: '{{ csrf_token() }}',
            }
        }).done(function(data) {

            console.debug(data);

            //var obj = JSON.parse(data);

            if (data) {

                setTimeout(function(){
                    location.reload();
                }, 400);

            }
        });
    }

</script>
