
<script>
    function ativarJogador( battletag ) {

        $('#gamer_activation_error_panel').hide();
        $('#gamer_update_error_panel').hide();

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

                /*
                $('#gamer_activation_error_panel').show();
                $('#gamer_activation_error_msg').html(obj.msg);

                $('#gamer_update_error_panel').show();
                $('#gamer_update_error_msg').html(obj.msg);
*/
                $.gritter.add({
                    title: "Ops! Erro ao consultar jogador!",
                    text: obj.msg,
                    sticky:true,
                    before_open:function(){
                        //alert("I am a sticky called before it opens")
                    },
                    after_open:function(e){
                        //alert("I am a sticky called after it opens: \nI am passed the jQuery object for the created Gritter element...\n"+e)
                    },
                    before_close:function(e){
                        //alert("I am a sticky called before it closes: I am passed the jQuery object for the Gritter element... \n"+e)
                    },
                    after_close:function(){
                        //alert("I am a sticky called after it closes")
                    }
                });
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


    function editTeamInfo(team_id, field, value) {

        return $.ajax({
            url: "{{ url('teams') }}/" + team_id,
            dataType: "html",
            type: "PUT",
            data: {
                field: field,
                value: value,
                _token: '{{ csrf_token() }}',
            }
        }).done(function(data) {

            //console.debug(data);

            var obj = JSON.parse(data);

            $.gritter.add({
                title: obj.title,
                text: obj.msg,
                sticky:true,
            });

            return obj.status == '200'? true : false;
        });
    }

    // Get current events
    function getEvents() {

        $.ajax({
            url: "{{ url('events.get') }}",
            dataType: "html",
            type: "GET",
        }).done(function(data) {

            //console.debug(data);

            var events = JSON.parse(data);

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultDate: '{{ Carbon\Carbon::now()->toDateString() }}',
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: events
            });
        });
    }

    // Get current events
    function inviteGamerToInhouse(gamer_id, element) {

        $.ajax({
            url: "{{ route('inhouse.invite') }}",
            dataType: "html",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                gamer_id: gamer_id
            }
        }).done(function(data) {

            var obj = JSON.parse(data);

            if (obj.code == '1') {
                alert('Vouch enviado com sucesso.');

                setTime
            }

        });
    }
</script>
