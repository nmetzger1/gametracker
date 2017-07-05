@extends('./layouts.app');

@section('content')
    @if (Auth::guest() || Auth::user()->id != $profile->id)
    @else
        <div>
            <form method="post" action="{{route('user.update', ['id' => $profile])}}">
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
            @for($i = 0; $i < count($playData); $i++)

                <h4>{{$playData[$i]->name}} - {{$playData[$i]->NumPlays}} </h4>
                <p>Last Played On: {{$playData[$i]->LastPlayed}}</p>
                <hr />

                @break($i == 9)
            @endfor
        </div>
    </div>
    <div class="panel">
        <div class="panel panel-heading">
            <h2>Most Played Games All Time</h2>
        </div>
        <div class="panel panel-body">
            Stats go here
        </div>
    </div>

@endsection