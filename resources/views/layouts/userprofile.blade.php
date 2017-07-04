@extends('./layouts.app');

@section('content')
    @if (Auth::guest() || Auth::user()->id != $profile->id)
        <h1>No Match</h1>
    @else
        <div>
            <h1>Match</h1>
            <form method="post" action="{{route('user.update', ['id' => $profile->id])}}">
                <p>Enter BoardGameGeek Username:<input type="text" name="name" /></p>
                {{method_field('PUT')}}
                <p><input type="submit" value="Sync with BoardGameGeek" /></p>
                {{csrf_field()}}
            </form>
        </div>
    @endif
@endsection