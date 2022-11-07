@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ratios</h5>
                    
                    <table class="table table-hover">
                        <tr>
                            <th>Nombre del ratio</th>
                            <th>Valor</th>
                            <th>Valor nacional</th>
                            <th>Resultado</th>
                        </tr>
                    @foreach($ratios as $ratio)
                        <tr>
                            <td>{{$ratio->NOMBRE_RATIO_CATALOGO}}</td>
                            <td>{{$ratio->VALOR_RATIO}}</td>
                            <td>{{$ratio->VALOR_RATIO + 1}}</td>
                        @if ($ratio->VALOR_RATIO)
                            <td class="table-primary">Ratio es aceptable</td>
                        @else
                            <td class="table-danger">Ratio no se acepta</td>
                        @endif
                            
                        </tr>
                    @endforeach
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection