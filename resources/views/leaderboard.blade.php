@extends('layouts.app')

@section('content')
    <div>
        <div class="header-div">
            <h1 class="header text-center">Leaderboards</h1>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="leaderboard col-md-6">
                    <div class="user-table">
                        <div class="table-title">
                            <h2>Most Played Games</h2>
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Game</th>
                                <th>Plays</th>
                            </tr>
                            </thead>
                            @foreach($games as $game)
                                <tr>
                                    <td><a href="/game/{{$game->GameID}}">{{$game->name}}</a></td>
                                    <td>{{$game->NumPlays}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="leaderboard col-md-6">
                    <div class="user-table">
                        <div class="table-title">
                            <h2>Users With Most Plays</h2>
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Plays</th>
                            </tr>
                            </thead>
                            @foreach($users as $user)
                                <tr>
                                    <td><a href="/user/{{$user->name}}">{{$user->name}}</a></td>
                                    <td>{{$user->Plays}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection