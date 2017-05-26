
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

            console.log('done');
            console.debug(data);

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

    /**
     * get partidas for the inhouse home
     *
     * param type
     */
    function getPartidas(type) {

        var where = '#matchs_' + type;

        $.ajax({
            url: "{{ route('inhouse.getMatchs') }}",
            dataType: "html",
            type: "GET",
            data: {
                _token: '{{ csrf_token() }}',
                type: type
            }
        }).done(function(data) {

            $(where).empty();

            var partidas = JSON.parse(data);

            for (key in partidas) {

                if (typeof (partidas[key].inscritos) != 'undefined')
                    var inscritos = partidas[key].inscritos
                else
                    var inscritos = '-';

                // Match open?
                if (type == 'open') {
                    var row = '<tr>'+
                            '<td><label class="label label-primary">Partida '+ partidas[key].id + '</label></td>'+
                            '<td>'+inscritos+'</td>'+
                            '</tr>';
                }
                else {
                    var row = '<tr>'+
                            '<td><label class="label label-primary">Partida '+ partidas[key].id + '</label></td>'+
                            '<td>'+partidas[key].rating+'</td>'+
                            '<td>'+inscritos+'</td>'+
                            '</tr>';
                }


                $(where).append(row);
            }
        });
    }

    // for inhouse
    function getOnlinePlayers() {

        $.ajax({
            url: "{{ route('inhouse.getOnlinePlayers') }}",
            dataType: "html",
            type: "GET",
        }).done(function(data) {

            $('#players_online').empty();

            var players = JSON.parse(data);

            for (key in players) {

                var row = '<tr>'+
                        '<td></td>'+
                        '<td><label class="label label-primary">'+ players[key].gamer.battletag + '</label></td>'+
                        '<td>'+players[key].rating+'</td>'+
                        '</tr>';

                $('#players_online').append(row);
            }

        });
    }

    // for admin home
    function getColaborators() {

        var where = '#colaborators_list';

        $.ajax({
            url: "{{ route('getColaborators') }}",
            dataType: "html",
            type: "GET",
        }).done(function(data) {

            $(where).empty();

            var users = JSON.parse(data);
            var i = 1;

            for (key in users) {

                var row = '<tr>'+
                        '<td>'+i+'</td>'+
                        '<td><label class="label label-primary">'+ users[key].name + '</label></td>'+
                        '<td>'+users[key].artigos+'</td>'+
                        '</tr>';

                $(where).append(row);

                i++;
            }

        });
    }

    // for admin home
    function getStats(stats) {

        var route = '';
        var where = '';

        switch (stats) {
            case 'players':
                route = "{{ route('getStatsPlayers') }}";
                where = '#stats_total_players';
                break;
            case 'teams':
                route = "{{ route('getStatsTeams') }}";
                where = '#stats_total_teams';
                break;
            case 'updates':
                route = "{{ route('getStatsUpdates') }}";
                where = '#stats_total_updates';
                break;
            case 'events':
                route = "{{ route('getStatsEvents') }}";
                where = '#stats_events';
                break;
        }

        $.ajax({
            url: route,
            dataType: "html",
            type: "GET",
        }).done(function(data) {

            $(where).empty();

            var obj = JSON.parse(data);

            console.debug(obj);
            $(where).html(obj);

        });
    }

</script>
