@extends('layouts.main')
@section('content')
    <button class="btn btn-primary" id="calcularRatios" type="button">Actualizar Ratios</button>
    <BR></BR>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ratios de la empresa | Sector {{$sectorEmpresa[0]}}</h5>                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre del ratio</th>
                                <th>Valor</th>
                                <th>Valor nacional</th>
                                <th>Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($ratios as $ratio)
                            @foreach($valorNacional as $vn)
                                @if($ratio->ID_RATIO_CATALOGO == $vn->ID_RATIO_CATALOGO)
                                <tr>
                                    <td>{{$ratio->NOMBRE_RATIO_CATALOGO}}</td>
                                    <td>{{$ratio->VALOR_RATIO}}</td>
                                    <td>{{$vn->VALOR_RATIO_POR_TIPO}}</td>
                                    @if ($ratio->VALOR_RATIO >= $vn->VALOR_RATIO_POR_TIPO )
                                        <td class="table-primary">Recomendado</td>
                                    @else
                                        <td class="table-danger">No recomendado</td>
                                    @endif    
                                </tr>
                                @endif
                            @endforeach 
                        @endforeach
                        </tbody> 
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ratios de la empresa | Promedio de los ratios de las empresas</h5>                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre del ratio</th>
                                <th>Valor</th>
                                <th>Promedio de empresas</th>
                                <th>Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($ratios as $ratio)
                            @foreach($prom as $promedio)
                                @if($ratio->ID_RATIO_CATALOGO == $promedio->ID_RATIO_CATALOGO)
                                <tr>
                                    <td>{{$ratio->NOMBRE_RATIO_CATALOGO}}</td>
                                    <td>{{$ratio->VALOR_RATIO}}</td>
                                    <td>{{$promedio->prom}}</td>
                                    @if ($ratio->VALOR_RATIO >= $promedio->prom )
                                        <td class="table-primary">Recomendado</td>
                                    @else
                                        <td class="table-danger">No recomendado</td>
                                    @endif    
                                </tr>
                                @endif
                            @endforeach 
                        @endforeach
                        </tbody> 
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $('#calcularRatios').click(function(){
                $.ajax({
                    url: "{{route('ratios.calculo')}}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response){
                        alert(response.message)
                        location.reload();
                    }
                });
            });
        });
    </script>


@endsection