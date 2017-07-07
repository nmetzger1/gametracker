@extends('./layouts.app');

@section('content')
    <div class="text-center">
        <h1>{{$gameDetail[0]->GameName}}</h1>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-heading">
            <h2>Top 50 Users with Most Plays</h2>
        </div>
        <div class="panel panel-body">

            @foreach($gameDetail as $user)
                <p><a href="/user/{{$user->Username}}">{{$user->Username}}</a> - {{$user->NumPlays}}</p>
            @endforeach

        </div>
    </div>

@endsection