@extends('./layouts.app');

@section('content')
    @if (Auth::guest() || Auth::user()->id != $profile->id)
        <h1>No Match</h1>
    @else
        <h1>Match</h1>
    @endif
@endsection