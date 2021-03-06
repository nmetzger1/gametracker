@extends('./layouts.app')

@section('content')
    <div class="img-div text-center">
        {{--Check BGG API if name is stored in array--}}
        @if(count($gameDetail["item"]["name"]) > 1)
            <h1>{{$gameDetail["item"]["name"][0]["@attributes"]["value"]}}</h1>
        @else
            <h1>{{$gameDetail["item"]["name"]["@attributes"]["value"]}}</h1>
        @endif
        <img src="{{$gameDetail["item"]["image"]}}" class="game-img">
        <p><a class="btn btn-default bgg-link" href="https://boardgamegeek.com/boardgame/{{$gameDetail["item"]["@attributes"]["id"]}}" target="_blank" role="button">View on BoardGameGeek</a></p>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-heading">
            Description:
        </div>
        <div class="panel panel-body">
            {{$gameDetail["item"]["description"]}}
        </div>
    </div>
    <div class="user-table col-md-6">
        <div class="table-title">
            <h2>Top 50 Users with Most Plays</h2>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>User</th>
                <th>Plays</th>
            </tr>
            </thead>
            @foreach($gamePlays as $user)
                <tr>
                    <td><a href="/user/{{$user->Username}}">{{$user->Username}}</a></td>
                    <td>{{$user->NumPlays}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="game-stats col-md-4">
        <div class="panel panel-default">
            <div class="panel panel-heading">Your Stats</div>
            @if (Auth::guest())
                <div class="panel panel-body">
                    Sign In / Register to See Your Stats
                </div>
            @else
                <div class="panel panel-body">
                    <p>Number of Plays: {{$userPlays["count"]}}</p>
                    <p>Total Time Played: {{$userPlays["time"]}}</p>
                </div>
            @endif
        </div>
    </div>
@endsection