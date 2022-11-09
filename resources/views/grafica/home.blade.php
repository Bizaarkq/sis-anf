@extends('layouts.main')
@section('content')

<section class="section">
    <h4>Cuentas</h4>
    <select class="selectpicker my-2" data-live-search="true" data-width="100%" name="account1">
        @foreach($cuentas as $account)
                <option value="{{$account->ID_CUENTA_FINANCIERA}}">{{$account->ID_CUENTA_FINANCIERA}} - {{$account->NOMBRE_CUENTA_FINANCIERA}}</option>  
        @endforeach
    </select>
</section>
@endsection
@section('js')

@endsection