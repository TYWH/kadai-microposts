@extends("layouts.app")

@section("content")
    <div class="center jumbotron">
        @if (Auth::check())
            {{ Auth::user()->name }}
        @else    
            <div class="text-center">
                <h1>Welcome to the Microposts</h1>
                {!! link_to_route("signup.get","Sign up now!",[],["class" => "btn btn-lg btn-primary"]) !!}
            </div>
        @endif
    </div>
@endsection    
