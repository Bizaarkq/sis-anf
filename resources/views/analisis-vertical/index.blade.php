@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="estadosFinan" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="bgTab" data-bs-toggle="tab" data-bs-target="#bg"
                                type="button" role="tab" aria-controls="bg" aria-selected="true">Balance
                                General</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="estadoReTab" data-bs-toggle="tab" data-bs-target="#estadoRe"
                                type="button" role="tab" aria-controls="contact" aria-selected="false">Estado de
                                Resultados</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2" id="myTabContent">
                        <div class="tab-pane fade show active" id="bg" role="tabpanel" aria-labelledby="bgTab">
        
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre de la cuenta</th>
                                        <th>Valor</th>
                                        <th>Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Nombre del ratio</td>
                                        <td>Valor</td>
                                        <td>Valor nacional</td>
                                    </tr>
                                </tbody> 
                            </table>
                        </div>
                        <div class="tab-pane fade" id="estadoRe" role="tabpanel" aria-labelledby="estadoReTab">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nombre de la cuenta</th>
                                        <th>Valor</th>
                                        <th>Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cuentas as $cuenta)
                                    <tr>
                                        <td>{{$cuenta['title']}}</td>
                                        <td>{{$cuenta['total']}}</td>
                                        @if($cuentas.length )
                                        <td>Porcentaje</td>
                                    </tr><p></p>
                                    @endforeach
                                        
                                </tbody> 
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
