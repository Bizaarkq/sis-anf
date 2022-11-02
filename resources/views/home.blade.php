@extends('layouts.main')
@section('content')

<section class="section">
    <h1>Bienvenido @auth {{Auth::user()->username}} @endauth </h1>
</section>
@endsection
@section('js')

@endsection