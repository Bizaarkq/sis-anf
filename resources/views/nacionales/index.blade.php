@extends('layouts.main')
@section('content')

<section class="section">
    <h1>Gestión de ratios nacionales: @auth {{Auth::user()->username}} @endauth </h1>
</section>
<!-- component -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <header class="px-5 py-4 border-b border-gray-100">
                    <div class="font-semibold text-gray-800">
                        <h4>Ratios nacionales</h4>
                    </div>
                    <div class="font-semibold text-gray-800">
                        <a href="{{route('nacionales.create')}}">
                            <button class="btn btn-primary w-25" type="submit">Ingresar ratio</button>
                        </a>
                    </div>
                </header>

                <div class="overflow-x-auto p-3">
                    <table class="table table-hover">
                        <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                            <tr>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Nombre del ratio</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Valor</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Sector</div>
                                </th>
                                <th class="p-2">
                                    <div class="font-semibold text-left">Acciones</div>
                                </th>
                            </tr>
                        </thead>
                        @csrf
                        <tbody class="text-sm divide-y divide-gray-100">
                            @foreach ($ratiosNacionales as $ratios)
                            <tr>
                                <td class="p-2">
                                    <div class="font-medium text-gray-800">
                                        {{$ratios->NOMBRE_RATIO_CATALOGO}}
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-left">
                                        {{$ratios->VALOR_RATIO_POR_TIPO}}
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-left font-medium text-green-500">
                                        {{$ratios->NOMBRE_TIPO_SECTOR}}
                                    </div>
                                </td>
                                <td class="p-2">
                                    <div class="text-left font-medium text-green-500">
                                        <a class="btn btn-primary" href="{{route('nacionales.edit', ['id' => $ratios->ID_RATIO_POR_TIPO]) }}" 
                                            class="p-2 text-black text-xs font-thin">Editar</a>
                                        <a class="btn btn-danger" href="{{route('nacionales.delete', ['id' => $ratios->ID_RATIO_POR_TIPO]) }}" 
                                                class="p-2 text-black text-xs font-thin">Eliminar</a>
                                    </div>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@endsection
@section('js')

@endsection