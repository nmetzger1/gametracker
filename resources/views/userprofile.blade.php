@extends('./layouts.app');

@section('content')
    @if(empty($user))
        <h1 class="text-center">User not found.</h1>
    @else

        <h1 class="text-center">{{$user->name}}</h1>


        @if (Auth::guest() || Auth::user()->id != $user->id)
        @else
            <div>
                <form method="post" action="{{route('user.update', ['id' => $user->id])}}">
                    <input type="hidden" name="name" value="{{Auth::user()->name}}" />
                    {{method_field('PUT')}}
                    <input type="submit" value="Sync Plays with BoardGameGeek" />
                    {{csrf_field()}}
                </form>
                <form method="post" action="{{route('collection.update', ['id' => $user->id])}}">
                    <input type="hidden" name="name" value="{{Auth::user()->name}}" />
                    {{method_field('PUT')}}
                    <input type="submit" value="Sync Collection with BoardGameGeek" />
                    {{csrf_field()}}
                </form>
            </div>
        @endif
        <div class="panel">
            <div class="panel-heading">
                <h2>Most Played Games of 2017</h2>
            </div>
            <div class="panel-body">
                @foreach($tenByTen as $game)

                    <h4><a href="/game/{{$game->GameID}}">{{$game->name}}</a> - {{$game->NumPlays}} </h4>
                    <p>Last Played On: {{$game->LastPlayed}}</p>
                    <hr />

                @endforeach
            </div>
        </div>
        <div class="panel">
            <div class="panel panel-heading">
                <h2>Top 100 Most Played Games</h2>
            </div>
            <div class="panel panel-body">
                @foreach($allPlays as $game)
                    <p><a href="/game/{{$game->GameID}}">{{$game->name}}</a> - {{$game->NumPlays}}</p>
                @endforeach
            </div>
        </div>
        <div class="panel">
            <div class="panel panel-heading">
                <h2>Games you haven't played in 6 months</h2>
            </div>
            <div class="panel panel-body">
                @foreach($noPlays as $game)
                    @if(is_null($game->LastPlayed))
                        <p><a href="/game/{{$game->gameID}}">{{$game->name}}</a> - No Play Logged</p>
                    @else
                        <p><a href="/game/{{$game->gameID}}">{{$game->name}}</a> - Last Played: {{$game->LastPlayed}}</p>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

@endsection