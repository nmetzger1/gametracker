@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h3>Top Games Played</h3>
                    @foreach($playData as $game)
                        <p><a href="/game/{{$game->GameID}}">{{$game->name}}</a></p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
