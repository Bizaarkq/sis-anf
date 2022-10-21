@extends('layouts.app')
@section('content')
@endsection
@section('js')
    
    <h1>Bienvenido @auth {{Auth::user()->name}} @endauth </h1>
    <nav><a href="{{route('logout')}}">SALIR</a></nav>

@endsection