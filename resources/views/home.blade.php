@extends('layouts.app')

@section('content')
    <div>
        <div class="container-fluid home-main-div">
            <div class="col-md-6 main-img-div">
                <img src="{{URL::asset('/images/PlayWhat.png')}}" class="main-img">
            </div>
            <div class="col-md-6 main-text-div">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ultricies ultricies nulla ut fermentum. Vestibulum ullamcorper tincidunt rhoncus. Duis vel velit at leo dapibus mattis. Praesent facilisis venenatis porta. Sed malesuada in quam et consequat. Mauris finibus ligula eu nulla porta luctus.</p>
                <p>Nam nec nulla facilisis, euismod est ut, mattis orci. Mauris iaculis, lacus at luctus condimentum, arcu ligula tristique magna, at egestas nulla orci a diam. Morbi semper libero et turpis iaculis mattis. Vivamus id nisi eget nibh malesuada faucibus. Maecenas eget nibh et mauris pharetra volutpat. Duis aliquet aliquet felis in vehicula. Curabitur tempor ligula sed suscipit euismod.</p>
                @if(Auth::guest())
                    <p>
                        <a href="/login">Login</a> or <a href="/register">Register</a> to see your stats.
                    </p>
                @endif
            </div>
        </div>
    </div>
    <div>

    </div>
@endsection
