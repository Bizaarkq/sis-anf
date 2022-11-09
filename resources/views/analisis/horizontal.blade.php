@extends('layouts.main')
@section('content')

<div class="my-4 p-4 rounded-3 shadow" style="background-color: white; width:90%;" id="mayorizacion">
    <h1 class="text-center h4">Análisis Horizontal</h1>

    <h3 class="text-left h4">Balance General</h3>
    <table class="table table-bordered mt-4 mx-auto" style="width:90%;">
        <thead>
            <tr class="table-light text-center">
                <th></th>
                @foreach($periodoscc as $periodo)
                    <th>{{$periodo}}</th>
                @endforeach
                @for($i=0; $i < count($periodoscc)- 1; $i++)
                    <th colspan="2">{{$periodoscc[$i]}} - {{$periodoscc[$i+1]}}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            <tr>
                <th colspan="{{count($periodoscc) + (count($periodoscc)-1)*2 + 1}}" class="table-light">ACTIVO</th>
            </tr>
            <tr>
                <th colspan="{{count($periodoscc) + (count($periodoscc)-1)*2 + 1}}" class="table-light">Activo Corriente</th>
            </tr>
                @foreach($cuentas['ACTIVO'][1] as $llave => $cuenta)
                    <tr>
                        <td>{{$cuenta}}</td>
                        @foreach($variaciones[$llave] as $periodo)
                            <td class="text-end">$ {{number_format($periodo, 2)}}</td>
                        @endforeach
                        @for($i=0; $i < count($variaciones[$llave]) - 1; $i++)
                            @php($negativo = $variaciones[$llave][$periodoscc[$i]] > $variaciones[$llave][$periodoscc[$i+1]])
                            <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($variaciones[$llave][$periodoscc[$i]] - $variaciones[$llave][$periodoscc[$i+1]], 2)}}</td>
                            <td class="text-end">{{$negativo ? '-':''}}
                                {{
                                number_format(
                                    ($variaciones[$llave][$periodoscc[$i]] - $variaciones[$llave][$periodoscc[$i+1]])
                                    /($variaciones[$llave][$periodoscc[$i]] == 0 ? 
                                    $variaciones[$llave][$periodoscc[$i+1]] == 0 ? 1 
                                    : $variaciones[$llave][$periodoscc[$i+1]] 
                                    : $variaciones[$llave][$periodoscc[$i]])
                                    , 2)
                            }} %</td>
                        @endfor
                    </tr>
                @endforeach
            
            <tr>
                <th colspan="{{count($periodoscc) + (count($periodoscc)-1)*2 + 1}}" class="table-light">Activo no Corriente</th>
            </tr>
                @foreach($cuentas['ACTIVO'][0] as $llave => $cuenta)
                    <tr>
                        <td>{{$cuenta}}</td>
                        @foreach($variaciones[$llave] as $periodo)
                            <td class="text-end">$ {{number_format($periodo, 2)}}</td>
                        @endforeach
                        @for($i=0; $i < count($variaciones[$llave]) - 1; $i++)
                            @php($negativo = $variaciones[$llave][$periodoscc[$i]] > $variaciones[$llave][$periodoscc[$i+1]])
                            <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($variaciones[$llave][$periodoscc[$i]] - $variaciones[$llave][$periodoscc[$i+1]], 2)}}</td>
                            <td class="text-end">{{$negativo ? '-':''}}{{
                                number_format(
                                    ($variaciones[$llave][$periodoscc[$i]] - $variaciones[$llave][$periodoscc[$i+1]])
                                    /($variaciones[$llave][$periodoscc[$i]] == 0 ? 
                                    $variaciones[$llave][$periodoscc[$i+1]] == 0 ? 1 
                                    : $variaciones[$llave][$periodoscc[$i+1]] 
                                    : $variaciones[$llave][$periodoscc[$i]])
                                    , 2)
                            }} %</td>
                        @endfor
                    </tr>
                @endforeach

            <tr>
                <th colspan="{{count($periodoscc) + (count($periodoscc)-1)*2 + 1}}" class="table-light">PASIVO</th>
            </tr>

            <tr>
                <th colspan="{{count($periodoscc) + (count($periodoscc)-1)*2 + 1}}" class="table-light">Pasivo Corriente</th>
            </tr>
                @foreach($cuentas['PASIVO'][1] as $llave => $cuenta)
                    <tr>
                        <td>{{$cuenta}}</td>
                        @foreach($variaciones[$llave] as $periodo)
                            <td class="text-end">$ {{number_format($periodo, 2)}}</td>
                        @endforeach
                        @for($i=0; $i < count($variaciones[$llave]) - 1; $i++)
                            @php($negativo = $variaciones[$llave][$periodoscc[$i]] > $variaciones[$llave][$periodoscc[$i+1]])
                            <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($variaciones[$llave][$periodoscc[$i]] - $variaciones[$llave][$periodoscc[$i+1]], 2)}}</td>
                            <td class="text-end">{{$negativo ? '-':''}}{{
                                number_format(
                                    ($variaciones[$llave][$periodoscc[$i]] - $variaciones[$llave][$periodoscc[$i+1]])
                                    /($variaciones[$llave][$periodoscc[$i]] == 0 ? 
                                    $variaciones[$llave][$periodoscc[$i+1]] == 0 ? 1 
                                    : $variaciones[$llave][$periodoscc[$i+1]] 
                                    : $variaciones[$llave][$periodoscc[$i]])
                                    , 2)
                            }} %</td>
                        @endfor
                    </tr>
                @endforeach

                @if(array_key_exists(0, $cuentas['PASIVO']))
                    <tr>
                        <th colspan="{{count($periodoscc) + (count($periodoscc)-1)*2 + 1}}" class="table-light">Pasivo no Corriente</th>
                    </tr>
                    
                    @foreach($cuentas['PASIVO'][0] as $llave => $cuenta)
                        <tr>
                            <td>{{$cuenta}}</td>
                                @foreach($variaciones[$llave] as $periodo)
                                    <td class="text-end">$ {{number_format($periodo, 2)}}</td>
                                @endforeach
                                @for($i=0; $i < count($variaciones[$llave]) - 1; $i++)
                                @php($negativo = $variaciones[$llave][$periodoscc[$i]] > $variaciones[$llave][$periodoscc[$i+1]])
                                    <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($variaciones[$llave][$periodoscc[$i]] - $variaciones[$llave][$periodoscc[$i+1]], 2)}}</td>
                                    <td class="text-end">{{$negativo ? '-':''}}{{
                                        number_format(
                                            ($variaciones[$llave][$periodoscc[$i]] - $variaciones[$llave][$periodoscc[$i+1]])
                                            /($variaciones[$llave][$periodoscc[$i]] == 0 ? 
                                            $variaciones[$llave][$periodoscc[$i+1]] == 0 ? 1 
                                            : $variaciones[$llave][$periodoscc[$i+1]] 
                                            : $variaciones[$llave][$periodoscc[$i]])
                                            , 2)
                                    }} %</td>
                                @endfor
                        </tr>
                    @endforeach
                @endif
            
            <tr>
                <th colspan="{{count($periodoscc) + (count($periodoscc)-1)*2 + 1}}" class="table-light">CAPITAL</th>
            </tr>
            @foreach($cuentas['CAPITAL'] as $llave => $cuenta)
                        <tr>
                            <td>{{$cuenta}}</td>
                                @foreach($variaciones[$llave] as $periodo)
                                    <td class="text-end">$ {{number_format($periodo, 2)}}</td>
                                @endforeach
                                @for($i=0; $i < count($variaciones[$llave]) - 1; $i++)
                                    <td class="text-end">$ {{number_format($variaciones[$llave][$periodoscc[$i]] - $variaciones[$llave][$periodoscc[$i+1]], 2)}}</td>
                                    <td class="text-end">{{number_format(($variaciones[$llave][$periodoscc[$i]] - $variaciones[$llave][$periodoscc[$i+1]])/$variaciones[$llave][$periodoscc[$i]], 2)}} %</td>
                                @endfor
                        </tr>
            @endforeach
            
        </tbody>
        <tfoot>
            {{-- <tr class="table-light text-center">
                <td class="text-end"><strong class="me-3">TOTAL :</strong></td>
                <td><strong>{{number_format($balanceSheet['totaldebit'],2,".",",")}}</strong></td>
                <td><strong>{{number_format($balanceSheet['totalcredit'],2,".",",")}}</strong></td>
            </tr> --}}
        </tfoot>
    </table>
</div>


@endsection
@section('js')
@endsection