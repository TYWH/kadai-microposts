@extends("layouts.app")

@section("content")
    @include("users.users",["users" => $users])
    {{-- 何やってるのか？　後で調べる --}}
@endsection