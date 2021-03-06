@extends('layouts.app')
@if(empty($user) == false)
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        var gameArray = {!! json_encode($tenByTen) !!};
        var color = '';
        function drawChart() {
            var data = google.visualization.arrayToDataTable(gameArray);

            if(gameArray[1][1] < 25){
                color = "red"
            }
            else if (gameArray[1][1] < 80){
                color = "orange"
            }
            else {
                color = "green"
            }

            var options = {
                pieHole: 0.3,
                legend: 'none',
                slices: {
                    0: { color: color },
                    1: { color: 'transparent' }
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>
@endif

@section('content')
    {{--PROFILE HEADER--}}
    <div>
        <div class="header-div">
            @if(empty($user))
                <h1 class="profile-header text-center">User not found.</h1>
            @else

                <h1 class="profile-header text-center">{{$user->name}}</h1>

                @if (Auth::guest() || Auth::user()->id != $user->id)
                @else
                    <div class="sync-buttons text-center">
                        <form method="post" action="{{route('user.update', ['id' => $user->id])}}">
                            <input type="hidden" name="name" value="{{Auth::user()->name}}" />
                            {{method_field('PUT')}}
                            <input class="btn btn-default btn-sync" type="submit" value="Sync Plays with BoardGameGeek" />
                            {{csrf_field()}}
                        </form>
                        <form method="post" action="{{route('collection.update', ['id' => $user->id])}}">
                            <input type="hidden" name="name" value="{{Auth::user()->name}}" />
                            {{method_field('PUT')}}
                            <input class="btn btn-default btn-sync" type="submit" value="Sync Collection with BoardGameGeek" />
                            {{csrf_field()}}
                        </form>
                    </div>
                @endif
        </div>
        {{--END PROFILE HEADER--}}
        {{--USER STATS--}}
        <div class="page-content">
            <div class="row">
                <div class="user-table top10 col-md-6">
                    <div class="table-title">
                        <h2 class="text-center">Most Played Games of 2017</h2>
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Game</th>
                            <th>Plays</th>
                            <th>Last Played</th>
                        </tr>
                        </thead>
                        @foreach($currentYear as $game)

                            <tr>
                                <td><a href="/game/{{$game->GameID}}">{{$game->name}}</a></td>
                                <td>{{$game->NumPlays}}</td>
                                <td>{{$game->LastPlayed}}</td>
                            </tr>

                        @endforeach
                    </table>
                </div>
                <div class="tenByten col-md-4">
                    <div class="tenByTen-main">
                        <div class="table-title">
                            <h2>10x10 Challenge</h2>
                        </div>
                        <div id="donutchart" style="width: 100%; height: 450px"></div>
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">What is this?</a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        The challenge is to play TEN GAMES TEN TIMES EACH within a year.  This site tracks your ten most played games for the current year.  Each play per game is counted (with a max of 10) then subtracted from 100 to determine your percentage.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row user-history">
                <div class="user-table top100 col-md-5">
                    <div class="table-title">
                        <h2>Top 100 Plays (All Time)</h2>
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Game</th>
                            <th>Plays</th>
                        </tr>
                        </thead>
                        @foreach($allPlays as $game)
                            <tr>
                                <td><a href="/game/{{$game->GameID}}">{{$game->name}}</a></td>
                                <td>{{$game->NumPlays}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>


                <div class="user-table sixmonths col-md-5">
                    <div class="table-title">
                        <h2 class="text-center">No Plays in 6 months</h2>
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Game</th>
                            <th>Last Play</th>
                        </tr>
                        </thead>
                        @foreach($noPlays as $game)
                            @if(is_null($game->LastPlayed))
                                <tr>
                                    <td><a href="/game/{{$game->gameID}}">{{$game->name}}</a></td>
                                    <td>No Play Logged</td>
                                </tr>
                            @else
                                <tr>
                                    <td><a href="/game/{{$game->gameID}}">{{$game->name}}</a></td>
                                    <td>{{$game->LastPlayed}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
    {{--END USER STATS--}}
@endsection