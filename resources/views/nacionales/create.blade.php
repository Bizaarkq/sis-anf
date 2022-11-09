@extends('layouts.main')
@section('content')

<section class="section">
    <h1>Gestión de ratios nacionales: @auth {{Auth::user()->username}} @endauth </h1>
</section>
<!-- component -->
<section class="antialiased bg-gray-100 text-gray-600 h-screen px-4" x-data="app">
  <div class="flex items-center justify-center p-12">
    <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
      <header class="px-5 py-4 border-b border-gray-100">
          <div class="font-semibold text-gray-800">
              <h4>Crear ratio nacional</h4>
          </div>
      </header>
      <div class="mx-auto w-full max-w-[550px]">
        <form action="{{route('nacionales.store')}}" method="POST">
          @csrf
          <div class="row mb-3">
              <label for="efectivoEq"
                  class="col-sm-9 col-form-label activos activos-corrientes">Nombre del
                  ratio</label>
          </div>
          <select name="catalogo">
            @foreach ($catalogo as $ratios)
            <option value="{{$ratios->ID_RATIO_CATALOGO}}" id="{{$ratios->ID_RATIO_CATALOGO}}">
              {{$ratios->NOMBRE_RATIO_CATALOGO}}
            </option>
            @endforeach
          </select>
          <div class="row mb-3">
          </div>
          <div class="row mb-3">
          </div>
          <div class="row mb-3">
              <label for="efectivoEq"
                  class="col-sm-9 col-form-label activos activos-corrientes">Sector del
                  ratio</label>
          </div>
          <select name="sectores">
              @foreach ($sectores as $rubros)
              <option value="{{$rubros->ID_TIPO_SECTOR}}" id="{{$rubros->ID_TIPO_SECTOR}}">
                {{$rubros->NOMBRE_TIPO_SECTOR}}
              </option>
              @endforeach
          </select>
          <div class="row mb-3">
          </div>
          <div class="row mb-3">
          </div>
          <div class="row mb-3">
            <label for="efectivoEq"
              class="col-sm-9 col-form-label activos activos-corrientes">Valor
              del ratio</label>
          </div>
          <input required type="number" step="0.01" id="VALOR_RATIO_POR_TIPO"
              name="VALOR_RATIO_POR_TIPO"> 
          <div class="row mb-3">
          </div>
          <div class="row mb-3">
          </div>  
          <div>
            <button class="btn btn-primary"type="submit">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
  @endsection
