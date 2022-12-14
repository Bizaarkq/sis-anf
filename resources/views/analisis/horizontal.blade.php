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
                @php($totalAC = [])
                @foreach($cuentas['ACTIVO'][1] as $llave => $cuenta)
                    <tr>
                        <td>{{$cuenta}}</td>
                        @foreach($variaciones[$llave] as $anio => $valor)
                            @php($totalAC[$anio] = ($totalAC[$anio] ?? 0) + $valor)
                            <td class="text-end">$ {{number_format($valor, 2)}}</td>
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
                    <td>Total Activos Corriente</td>
                    @foreach($totalAC as $anio => $valor)
                        <td class="text-end">$ {{number_format($valor, 2)}}</td>
                    @endforeach

                    @php($totalAC = array_values($totalAC))
                    @for($i=0; $i < count($totalAC) - 1; $i++)
                        @php($negativo = $totalAC[$i] > $totalAC[$i+1])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($totalAC[$i] - $totalAC[$i+1], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($totalAC[$i] - $totalAC[$i+1])
                                /($totalAC[$i]  == 0 ? 
                                $totalAC[$i+1] == 0 ? 1 
                                : $totalAC[$i+1] 
                                : $totalAC[$i] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>
            
            <tr>
                <th colspan="{{count($periodoscc) + (count($periodoscc)-1)*2 + 1}}" class="table-light">Activo no Corriente</th>
            </tr>
                @php($totalAN = [])
                @foreach($cuentas['ACTIVO'][0] as $llave => $cuenta)
                    <tr>
                        <td>{{$cuenta}}</td>
                        @foreach($variaciones[$llave] as $anio => $valor)
                            @php($totalAN[$anio] = ($totalAN[$anio] ?? 0) + $valor)
                            <td class="text-end">$ {{number_format($valor, 2)}}</td>
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
                    <td>Total Activos No Corrientes</td>
                    @foreach($totalAN as $anio => $valor)
                        <td class="text-end">$ {{number_format($valor, 2)}}</td>
                    @endforeach

                    @php($totalAN = array_values($totalAN))
                    @for($i=0; $i < count($totalAN) - 1; $i++)
                        @php($negativo = $totalAN[$i] > $totalAN[$i+1])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($totalAN[$i] - $totalAN[$i+1], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($totalAN[$i] - $totalAN[$i+1])
                                /($totalAN[$i]  == 0 ? 
                                $totalAN[$i+1] == 0 ? 1 
                                : $totalAN[$i+1] 
                                : $totalAN[$i] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>

                <tr>
                    <td class="table-light">Total Activos</td>
                    @php($totalA = [])
                    @for($i = 0; $i < count($periodoscc) ; $i++)
                        @php($totalA[$i] = ($totalAN[$i] ?? 0) + ($totalAC[$i] ?? 0))
                        <td class="text-end">$ {{number_format(($totalAC[$i] ?? 0) + ($totalAN[$i] ?? 0), 2)}}</td>
                    @endfor

                    @for($i=0; $i < count($periodoscc) - 1; $i++)
                        @php($negativo = $totalA[$i] > $totalA[$i+1])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($totalA[$i] - $totalA[$i+1], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($totalA[$i] - $totalA[$i+1])
                                /($totalA[$i]  == 0 ? 
                                $totalA[$i+1] == 0 ? 1 
                                : $totalA[$i+1] 
                                : $totalA[$i] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>
                <tr>

                </tr>

            <tr>
                <th colspan="{{count($periodoscc) + (count($periodoscc)-1)*2 + 1}}" class="table-light">PASIVO</th>
            </tr>

            @if(array_key_exists(1, $cuentas['PASIVO']))
            <tr>
                <th colspan="{{count($periodoscc) + (count($periodoscc)-1)*2 + 1}}" class="table-light">Pasivo Corriente</th>
            </tr>
                @php($totalAPC = [])
                @foreach($cuentas['PASIVO'][1] as $llave => $cuenta)
                    <tr>
                        <td>{{$cuenta}}</td>
                        @foreach($variaciones[$llave] as $anio => $valor)
                            @php($totalAPC[$anio] = ($totalAPC[$anio] ?? 0) + $valor)
                            <td class="text-end">$ {{number_format($valor, 2)}}</td>
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
                    <td>Total Pasivos Corrientes</td>
                    @foreach($totalAPC as $anio => $valor)
                        <td class="text-end">$ {{number_format($valor, 2)}}</td>
                    @endforeach

                    @php($totalAPC = array_values($totalAPC))
                    @for($i=0; $i < count($totalAPC) - 1; $i++)
                        @php($negativo = $totalAPC[$i] > $totalAPC[$i+1])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($totalAPC[$i] - $totalAPC[$i+1], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($totalAPC[$i] - $totalAPC[$i+1])
                                /($totalAPC[$i]  == 0 ? 
                                $totalAPC[$i+1] == 0 ? 1 
                                : $totalAPC[$i+1] 
                                : $totalAPC[$i] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>
                

            @endif

                @if(array_key_exists(0, $cuentas['PASIVO']))
                    <tr>
                        <th colspan="{{count($periodoscc) + (count($periodoscc)-1)*2 + 1}}" class="table-light">Pasivo no Corriente</th>
                    </tr>
                    @php($totalPNC = [])
                    @foreach($cuentas['PASIVO'][0] as $llave => $cuenta)
                        <tr>
                            <td>{{$cuenta}}</td>
                                @foreach($variaciones[$llave] as $anio => $valor)
                                    @php($totalPNC[$anio] = ($totalPNC[$anio] ?? 0) + $valor)
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
                        <td>Total Pasivos No Corrientes</td>
                        @foreach($totalPNC as $anio => $valor)
                            <td class="text-end">$ {{number_format($valor, 2)}}</td>
                        @endforeach
    
                        @php($totalPNC = array_values($totalPNC))
                        @for($i=0; $i < count($totalPNC) - 1; $i++)
                            @php($negativo = $totalPNC[$i] > $totalPNC[$i+1])
                            <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($totalPNC[$i] - $totalPNC[$i+1], 2)}}</td>
                            <td class="text-end">{{$negativo ? '-':''}}
                                {{
                                number_format(
                                    ($totalPNC[$i] - $totalPNC[$i+1])
                                    /($totalPNC[$i]  == 0 ? 
                                    $totalPNC[$i+1] == 0 ? 1 
                                    : $totalPNC[$i+1] 
                                    : $totalPNC[$i] )
                                    , 2)
                            }} %</td>
                        @endfor
                    </tr>
                @endif
            <tr>
                <td class="table-light">Total Pasivos</td>
                @php($totalP = [])
                @for($i = 0; $i < count($periodoscc) ; $i++)
                    @php($totalP[$i] = ($totalAPC[$i] ?? 0) + ($totalPNC[$i] ?? 0))
                    <td class="text-end">$ {{number_format(($totalAPC[$i] ?? 0) + ($totalPNC[$i] ?? 0), 2)}}</td>
                @endfor
                @for($i=0; $i < count($periodoscc) - 1; $i++)
                    @php($negativo = $totalP[$i] > $totalP[$i+1])
                    <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($totalP[$i] - $totalP[$i+1], 2)}}</td>
                    <td class="text-end">{{$negativo ? '-':''}}
                        {{
                        number_format(
                            ($totalP[$i] - $totalP[$i+1])
                            /($totalP[$i]  == 0 ? 
                            $totalP[$i+1] == 0 ? 1 
                            : $totalP[$i+1] 
                            : $totalP[$i] )
                            , 2)
                    }} %</td>
                @endfor
            </tr>
            
            <tr>
                <th colspan="{{count($periodoscc) + (count($periodoscc)-1)*2 + 1}}" class="table-light">CAPITAL</th>
            </tr>
            @php($totalPN = [])
            @foreach($cuentas['CAPITAL'] as $llave => $cuenta)
                        <tr>
                            <td>{{$cuenta}}</td>
                                @foreach($variaciones[$llave] as $anio => $valor)
                                    @php($totalPN[$anio] = ($totalPN[$anio] ?? 0) + $valor)
                                    <td class="text-end">$ {{number_format($valor, 2)}}</td>
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
                <td class="table-light">Total Patrimonio</td>
                @foreach($totalPN as $anio => $valor)
                    <td class="text-end">$ {{number_format($valor, 2)}}</td>
                @endforeach

                @php($totalPN = array_values($totalPN))
                @for($i=0; $i < count($totalPN) - 1; $i++)
                    @php($negativo = $totalPN[$i] > $totalPN[$i+1])
                    <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($totalPN[$i] - $totalPN[$i+1], 2)}}</td>
                    <td class="text-end">{{$negativo ? '-':''}}
                        {{
                        number_format(
                            ($totalPN[$i] - $totalPN[$i+1])
                            /($totalPN[$i]  == 0 ? 
                            $totalPN[$i+1] == 0 ? 1 
                            : $totalPN[$i+1] 
                            : $totalPN[$i] )
                            , 2)
                    }} %</td>
                @endfor
            </tr>

            <tr>
                <td class="table-light">Total Patrimonio mas Pasivo</td>
                @php($totalPP = [])
                @for($i = 0; $i < count($periodoscc) ; $i++)
                    @php($totalPP[$i] = ($totalPN[$i] ?? 0) + ($totalP[$i] ?? 0))
                    <td class="text-end table-light">$ {{number_format(($totalPN[$i] ?? 0) + ($totalP[$i] ?? 0), 2)}}</td>
                @endfor
                @for($i=0; $i < count($periodoscc) - 1; $i++)
                    @php($negativo = $totalPP[$i] > $totalPP[$i+1])
                    <td class="text-end table-light">{{$negativo ? '-':''}}$ {{number_format($totalPP[$i] - $totalPP[$i+1], 2)}}</td>
                    <td class="text-end table-light">{{$negativo ? '-':''}}
                        {{
                        number_format(
                            ($totalPP[$i] - $totalPP[$i+1])
                            /($totalPP[$i]  == 0 ? 
                            $totalPP[$i+1] == 0 ? 1 
                            : $totalPP[$i+1] 
                            : $totalPP[$i] )
                            , 2)
                    }} %</td>
                @endfor
            </tr>

            
            
        </tbody>
    </table>
    <br>
    <h3 class="text-left h4">Estados de Resultados</h3>
    <table class="table table-bordered mt-4 mx-auto" style="width:90%;">
        <thead>
            <tr class="table-light text-center">
                <th></th>
                @foreach($periodoser as $periodo)
                    <th>{{$periodo}}</th>
                @endforeach
                @for($i=0; $i < count($periodoser)- 1; $i++)
                    <th colspan="2">{{$periodoser[$i]}} - {{$periodoser[$i+1]}}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>Ingresos</td>
                    @foreach($periodoser as $periodo)
                        <td class="text-end">$ {{number_format($financieras[$periodo]['INGRESOS'] ?? 0, 2)}}</td>
                    @endforeach

                    @for($i=0; $i < count($periodoser)- 1; $i++)
                        @php($negativo = $financieras[$periodoser[$i]]['INGRESOS'] > $financieras[$periodoser[$i+1]]['INGRESOS'])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($financieras[$periodoser[$i]]['INGRESOS'] - $financieras[$periodoser[$i+1]]['INGRESOS'], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($financieras[$periodoser[$i]]['INGRESOS'] - $financieras[$periodoser[$i+1]]['INGRESOS'])
                                /($financieras[$periodoser[$i]]['INGRESOS']  == 0 ? 
                                $financieras[$periodoser[$i+1]]['INGRESOS'] == 0 ? 1 
                                : $financieras[$periodoser[$i+1]]['INGRESOS']
                                : $financieras[$periodoser[$i]]['INGRESOS'] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>
                <tr>
                    <td>Costos de Ventas</td>
                    @foreach($periodoser as $periodo)
                        <td class="text-end">$ {{number_format($financieras[$periodo]['COSTO_VENTAS'] ?? 0, 2)}}</td>
                    @endforeach

                    @for($i=0; $i < count($periodoser)- 1; $i++)
                        @php($negativo = $financieras[$periodoser[$i]]['COSTO_VENTAS'] > $financieras[$periodoser[$i+1]]['COSTO_VENTAS'])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($financieras[$periodoser[$i]]['COSTO_VENTAS'] - $financieras[$periodoser[$i+1]]['COSTO_VENTAS'], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($financieras[$periodoser[$i]]['COSTO_VENTAS'] - $financieras[$periodoser[$i+1]]['COSTO_VENTAS'])
                                /($financieras[$periodoser[$i]]['COSTO_VENTAS']  == 0 ? 
                                $financieras[$periodoser[$i+1]]['COSTO_VENTAS'] == 0 ? 1 
                                : $financieras[$periodoser[$i+1]]['COSTO_VENTAS']
                                : $financieras[$periodoser[$i]]['COSTO_VENTAS'] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>
                <tr>
                    <td>Utilidad Bruta</td>
                    @foreach($periodoser as $periodo)
                        <td class="text-end">$ {{number_format($financieras[$periodo]['UTILIDAD_BRUTA'] ?? 0, 2)}}</td>
                    @endforeach

                    @for($i=0; $i < count($periodoser)- 1; $i++)
                        @php($negativo = $financieras[$periodoser[$i]]['UTILIDAD_BRUTA'] > $financieras[$periodoser[$i+1]]['UTILIDAD_BRUTA'])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($financieras[$periodoser[$i]]['UTILIDAD_BRUTA'] - $financieras[$periodoser[$i+1]]['UTILIDAD_BRUTA'], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($financieras[$periodoser[$i]]['UTILIDAD_BRUTA'] - $financieras[$periodoser[$i+1]]['UTILIDAD_BRUTA'])
                                /($financieras[$periodoser[$i]]['UTILIDAD_BRUTA']  == 0 ? 
                                $financieras[$periodoser[$i+1]]['UTILIDAD_BRUTA'] == 0 ? 1 
                                : $financieras[$periodoser[$i+1]]['UTILIDAD_BRUTA']
                                : $financieras[$periodoser[$i]]['UTILIDAD_BRUTA'] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>
                <tr>
                    <td>Gastos de Operación</td>
                    @foreach($periodoser as $periodo)
                    <td class="text-end">$ {{number_format($financieras[$periodo]['GASTOS_OPERACION'] ?? 0, 2)}}</td>
                @endforeach

                @for($i=0; $i < count($periodoser)- 1; $i++)
                    @php($negativo = $financieras[$periodoser[$i]]['GASTOS_OPERACION'] > $financieras[$periodoser[$i+1]]['GASTOS_OPERACION'])
                    <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($financieras[$periodoser[$i]]['GASTOS_OPERACION'] - $financieras[$periodoser[$i+1]]['GASTOS_OPERACION'], 2)}}</td>
                    <td class="text-end">{{$negativo ? '-':''}}
                        {{
                        number_format(
                            ($financieras[$periodoser[$i]]['GASTOS_OPERACION'] - $financieras[$periodoser[$i+1]]['GASTOS_OPERACION'])
                            /($financieras[$periodoser[$i]]['GASTOS_OPERACION']  == 0 ? 
                            $financieras[$periodoser[$i+1]]['GASTOS_OPERACION'] == 0 ? 1 
                            : $financieras[$periodoser[$i+1]]['GASTOS_OPERACION']
                            : $financieras[$periodoser[$i]]['GASTOS_OPERACION'] )
                            , 2)
                    }} %</td>
                @endfor
                </tr>
                <tr>
                    <td>Utilidad de Operación</td>
                    @foreach($periodoser as $periodo)
                        <td class="text-end">$ {{number_format($financieras[$periodo]['UTILIDAD_OPERACION'] ?? 0, 2)}}</td>
                    @endforeach

                    @for($i=0; $i < count($periodoser)- 1; $i++)
                        @php($negativo = $financieras[$periodoser[$i]]['UTILIDAD_OPERACION'] > $financieras[$periodoser[$i+1]]['UTILIDAD_OPERACION'])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($financieras[$periodoser[$i]]['UTILIDAD_OPERACION'] - $financieras[$periodoser[$i+1]]['UTILIDAD_OPERACION'], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($financieras[$periodoser[$i]]['UTILIDAD_OPERACION'] - $financieras[$periodoser[$i+1]]['UTILIDAD_OPERACION'])
                                /($financieras[$periodoser[$i]]['UTILIDAD_OPERACION']  == 0 ? 
                                $financieras[$periodoser[$i+1]]['UTILIDAD_OPERACION'] == 0 ? 1 
                                : $financieras[$periodoser[$i+1]]['UTILIDAD_OPERACION']
                                : $financieras[$periodoser[$i]]['UTILIDAD_OPERACION'] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>
                <tr>
                    <td>Otros Ingresos</td>
                    @foreach($periodoser as $periodo)
                        <td class="text-end">$ {{number_format($financieras[$periodo]['OTROS_INGRESOS'] ?? 0, 2)}}</td>
                    @endforeach

                    @for($i=0; $i < count($periodoser)- 1; $i++)
                        @php($negativo = $financieras[$periodoser[$i]]['OTROS_INGRESOS'] > $financieras[$periodoser[$i+1]]['OTROS_INGRESOS'])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($financieras[$periodoser[$i]]['OTROS_INGRESOS'] - $financieras[$periodoser[$i+1]]['OTROS_INGRESOS'], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($financieras[$periodoser[$i]]['OTROS_INGRESOS'] - $financieras[$periodoser[$i+1]]['OTROS_INGRESOS'])
                                /($financieras[$periodoser[$i]]['OTROS_INGRESOS']  == 0 ? 
                                $financieras[$periodoser[$i+1]]['OTROS_INGRESOS'] == 0 ? 1 
                                : $financieras[$periodoser[$i+1]]['OTROS_INGRESOS']
                                : $financieras[$periodoser[$i]]['OTROS_INGRESOS'] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>
                <tr>
                    <td>Utilidad antes de Impuestos y Reserva Legal</td>
                    @foreach($periodoser as $periodo)
                        <td class="text-end">$ {{number_format($financieras[$periodo]['UTILIDAD_IMP_RES'] ?? 0, 2)}}</td>
                    @endforeach

                    @for($i=0; $i < count($periodoser)- 1; $i++)
                        @php($negativo = $financieras[$periodoser[$i]]['UTILIDAD_IMP_RES'] > $financieras[$periodoser[$i+1]]['UTILIDAD_IMP_RES'])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($financieras[$periodoser[$i]]['UTILIDAD_IMP_RES'] - $financieras[$periodoser[$i+1]]['UTILIDAD_IMP_RES'], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($financieras[$periodoser[$i]]['UTILIDAD_IMP_RES'] - $financieras[$periodoser[$i+1]]['UTILIDAD_IMP_RES'])
                                /($financieras[$periodoser[$i]]['UTILIDAD_IMP_RES']  == 0 ? 
                                $financieras[$periodoser[$i+1]]['UTILIDAD_IMP_RES'] == 0 ? 1 
                                : $financieras[$periodoser[$i+1]]['UTILIDAD_IMP_RES']
                                : $financieras[$periodoser[$i]]['UTILIDAD_IMP_RES'] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>
                <tr>
                    <td>Reservas</td>
                    @foreach($periodoser as $periodo)
                        <td class="text-end">$ {{number_format($financieras[$periodo]['RESERVA'] ?? 0, 2)}}</td>
                    @endforeach

                    @for($i=0; $i < count($periodoser)- 1; $i++)
                        @php($negativo = $financieras[$periodoser[$i]]['RESERVA'] > $financieras[$periodoser[$i+1]]['RESERVA'])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($financieras[$periodoser[$i]]['RESERVA'] - $financieras[$periodoser[$i+1]]['RESERVA'], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($financieras[$periodoser[$i]]['RESERVA'] - $financieras[$periodoser[$i+1]]['RESERVA'])
                                /($financieras[$periodoser[$i]]['RESERVA']  == 0 ? 
                                $financieras[$periodoser[$i+1]]['RESERVA'] == 0 ? 1 
                                : $financieras[$periodoser[$i+1]]['RESERVA']
                                : $financieras[$periodoser[$i]]['RESERVA'] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>
                <tr>
                    <td>Utilidad antes de Impuestos</td>
                    @foreach($periodoser as $periodo)
                        <td class="text-end">$ {{number_format($financieras[$periodo]['UTILIDAD_IMP'] ?? 0, 2)}}</td>
                    @endforeach

                    @for($i=0; $i < count($periodoser)- 1; $i++)
                        @php($negativo = $financieras[$periodoser[$i]]['UTILIDAD_IMP'] > $financieras[$periodoser[$i+1]]['UTILIDAD_IMP'])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($financieras[$periodoser[$i]]['UTILIDAD_IMP'] - $financieras[$periodoser[$i+1]]['UTILIDAD_IMP'], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($financieras[$periodoser[$i]]['UTILIDAD_IMP'] - $financieras[$periodoser[$i+1]]['UTILIDAD_IMP'])
                                /($financieras[$periodoser[$i]]['UTILIDAD_IMP']  == 0 ? 
                                $financieras[$periodoser[$i+1]]['UTILIDAD_IMP'] == 0 ? 1 
                                : $financieras[$periodoser[$i+1]]['UTILIDAD_IMP']
                                : $financieras[$periodoser[$i]]['UTILIDAD_IMP'] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>
                <tr>
                    <td>Impuestos</td>
                    @foreach($periodoser as $periodo)
                        <td class="text-end">$ {{number_format($financieras[$periodo]['IMPUESTO_RENTA'] ?? 0, 2)}}</td>
                    @endforeach

                    @for($i=0; $i < count($periodoser)- 1; $i++)
                        @php($negativo = $financieras[$periodoser[$i]]['IMPUESTO_RENTA'] > $financieras[$periodoser[$i+1]]['IMPUESTO_RENTA'])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($financieras[$periodoser[$i]]['IMPUESTO_RENTA'] - $financieras[$periodoser[$i+1]]['IMPUESTO_RENTA'], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($financieras[$periodoser[$i]]['IMPUESTO_RENTA'] - $financieras[$periodoser[$i+1]]['IMPUESTO_RENTA'])
                                /($financieras[$periodoser[$i]]['IMPUESTO_RENTA']  == 0 ? 
                                $financieras[$periodoser[$i+1]]['IMPUESTO_RENTA'] == 0 ? 1 
                                : $financieras[$periodoser[$i+1]]['IMPUESTO_RENTA']
                                : $financieras[$periodoser[$i]]['IMPUESTO_RENTA'] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>
                <tr>
                    <td>Utilidad Neta</td>
                    @foreach($periodoser as $periodo)
                        <td class="text-end">$ {{number_format($financieras[$periodo]['UTILIDAD_NETA'] ?? 0, 2)}}</td>
                    @endforeach

                    @for($i=0; $i < count($periodoser)- 1; $i++)
                        @php($negativo = $financieras[$periodoser[$i]]['UTILIDAD_NETA'] > $financieras[$periodoser[$i+1]]['UTILIDAD_NETA'])
                        <td class="text-end">{{$negativo ? '-':''}}$ {{number_format($financieras[$periodoser[$i]]['UTILIDAD_NETA'] - $financieras[$periodoser[$i+1]]['UTILIDAD_NETA'], 2)}}</td>
                        <td class="text-end">{{$negativo ? '-':''}}
                            {{
                            number_format(
                                ($financieras[$periodoser[$i]]['UTILIDAD_NETA'] - $financieras[$periodoser[$i+1]]['UTILIDAD_NETA'])
                                /($financieras[$periodoser[$i]]['UTILIDAD_NETA']  == 0 ? 
                                $financieras[$periodoser[$i+1]]['UTILIDAD_NETA'] == 0 ? 1 
                                : $financieras[$periodoser[$i+1]]['UTILIDAD_NETA']
                                : $financieras[$periodoser[$i]]['UTILIDAD_NETA'] )
                                , 2)
                        }} %</td>
                    @endfor
                </tr>

        </tbody>
    </table>
</div>


@endsection
@section('js')
@endsection