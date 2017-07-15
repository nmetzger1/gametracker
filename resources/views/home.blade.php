@extends('layouts.app')

@section('content')
    <div>
        <div class="container-fluid home-main-div">
            <div class="col-md-6 main-img-div">
                <img src="{{URL::asset('/images/PlayWhat2.png')}}" class="main-img">
            </div>
            <div class="col-md-6 main-text-div">
                <p class="text-center">Out with the new, in the with old. Dust off those games in the back of your closet and get to playing.</p>
                @if(Auth::guest())
                    <p class="text-center">
                        <a href="/login">Login</a> or <a href="/register">Register</a> to get started.
                    </p>
                @endif
            </div>
        </div>
    </div>
    <div>

    </div>
@endsection
