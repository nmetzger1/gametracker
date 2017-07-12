@extends('./layouts.app');

@section('content')
    <div class="text-center">
        <h1>{{$gamePlays[0]->GameName}}</h1>
        <img src="{{$gameDetail["item"]["image"]}}">
        <p><a href="https://boardgamegeek.com/boardgame/{{$gamePlays[0]->bggID}}" target="_blank">View on BoardGameGeek</a></p>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-heading">
            Description:
        </div>
        <div class="panel panel-body">
            {{$gameDetail["item"]["description"]}}
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-heading">
            <h2>Top 50 Users with Most Plays</h2>
        </div>
        <div class="panel panel-body">

            @foreach($gamePlays as $user)
                <p><a href="/user/{{$user->Username}}">{{$user->Username}}</a> - {{$user->NumPlays}}</p>
            @endforeach

        </div>
    </div>

        <div class="panel panel-default">
            <div class="panel panel-heading">Your Stats</div>
            @if (Auth::guest())
                <div class="panel panel-body">
                    Sign In / Register to See Your Stats
                </div>
            @else
                <div class="panel panel-body">
                    Your Stats
                </div>
            @endif
        </div>
@endsection