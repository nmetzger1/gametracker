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
                    <p>Enter BoardGameGeek Username:<input type="text" name="name" /></p>
                    {{method_field('PUT')}}
                    <p><input type="submit" value="Sync with BoardGameGeek" /></p>
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
    @endif

@endsection