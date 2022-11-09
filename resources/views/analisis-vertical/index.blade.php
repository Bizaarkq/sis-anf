@extends('layouts.main')
@section('content')
<div class="my-4 p-4 rounded-3 shadow" style="background-color: white; width:90%;" id="mayorizacion">
    <h1 class="text-center h4">Análisis Vertical</h1>

    <h3 class="text-left h4">Balance General</h3>
    <table class="table table-bordered mt-4 mx-auto" style="width:90%;">
        <tbody>


            <tr>
                <th colspan="3" class="table-light">ACTIVO</th>
            </tr>
            <tr>
                <th colspan="3" class="table-light">Activo Corriente</th>
            </tr>
                @foreach($cuentas['ACTIVO'][1] as $llave => $cuenta)
                    <tr>
                        <td>{{$cuenta}}</td>
                        <td>$ {{ number_format($total[$llave]) }}</td>
                        <td>{{round(($total[$llave]/$sumaActivo)*100, 2)}}%</td>
                    </tr>
                @endforeach
            <tr>
                <th colspan="3" class="table-light">Activo No Corriente</th>
            </tr>
            </tr>
                @foreach($cuentas['ACTIVO'][0] as $llave => $cuenta)
                    <tr>
                        <td>{{$cuenta}}</td>
                        <td>$ {{ number_format($total[$llave]) }}</td>
                        <td>{{round(($total[$llave]/$sumaActivo)*100, 2)}}%</td>
                    </tr>
                @endforeach
            <tr>
            <tr>
                <th class="table-light">Total Activo</th>
                <th class="table-light">$ {{ number_format($sumaActivo) }}</th>
                <th class="table-light">100%</th>
            </tr>

            <tr>
                <th colspan="3" class="table-light">PASIVO</th>
            </tr>
            <tr>
                <th colspan="3" class="table-light">Pasivo Corriente</th>
            </tr>
            </tr>
                @foreach($cuentas['PASIVO'][1] as $llave => $cuenta)
                    <tr>
                        <td>{{$cuenta}}</td>
                        <td>$ {{ number_format($total[$llave]) }}</td>
                        <td>{{round(($total[$llave]/$sumaPasivo)*100, 2)}}%</td>
                    </tr>
                @endforeach
            <tr>
            @if(array_key_exists(0, $cuentas['PASIVO']))
                <tr>
                <th colspan="3" class="table-light">Pasivo No Corriente</th>
                </tr>
                </tr>
                    @foreach($cuentas['PASIVO'][0] as $llave => $cuenta)
                        <tr>
                            <td>{{$cuenta}}</td>
                            <td>$ {{ number_format($total[$llave]) }}</td>
                            <td>{{round(($total[$llave]/$sumaPasivo)*100, 2)}}%</td>
                        </tr>
                    @endforeach
                <tr>
            @endif
            <tr>
                <th class="table-light">Total Pasivo</th>
                <th class="table-light">$ {{ number_format($sumaPasivo) }}</th>
                <th class="table-light">100%</th>
            </tr>

            <tr>
                <th colspan="3" class="table-light">CAPITAL</th>
            </tr>
                @foreach($cuentas['CAPITAL'] as $llave => $cuenta)
                    <tr>
                        <td>{{$cuenta}}</td>
                        <td>$ {{ number_format($total[$llave]) }}</td>
                        <td>{{round(($total[$llave]/$sumaCapital)*100, 2)}}%</td>
                    </tr>
                @endforeach
            <tr>
            <tr>
                <th class="table-light">Total Capital</th>
                <th class="table-light">$ {{ number_format($sumaCapital) }}</th>
                <th class="table-light">100%</th>
            </tr>
        </tbody>
    </table>

    <br>
    <h3 class="text-left h4">Estado de resultado</h3>
    <table class="table table-bordered mt-4 mx-auto" style="width:90%;">
        <tbody>
            @foreach($estados as $e)
                <tr>
                    <td>{{$e->NOMBRE_CUENTA_FINANCIERA}}</td>
                    <td>$ {{ number_format($e->MONTO_REGISTRO) }}</td>
                    <td>{{round(($e->MONTO_REGISTRO/$ingresos)*100, 2)}}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
