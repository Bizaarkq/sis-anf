@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Crear Catalogo </h5>
                    <form action="{{route('cargar-estados.load')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div id="catalogo">

                            <div class="row rounded border pb-3 px-2 mx-2 my-2 cuenta1">
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                                    <label for="codigoCatalogo1" class="col-form-label">Codigo de cuenta</label>
                                    <input type="text" name="codigoCatalogo1" class="form-control">
                                </div>
    
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                                    <label for="nombreCuenta1" class="col-form-label">Nombre de cuenta</label>
                                    <input type="text" name="nombreCuenta1" class="form-control">
                                </div>
    
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                                    <label for="codigoPadre1" class="col-form-label">Codigo cuenta padre</label>
                                    <input type="text" name="codigoPadre1" class="form-control">
                                </div>
    
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                                    <label for="nivelCuenta1" class="col-form-label">Nivel de cuenta</label>
                                    <input type="number" min="1" name="nivelCuenta1" class="form-control">
                                </div>
    
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                                    <label for="tipoCuenta1" class="col-form-label">Tipo</label>
                                    <select name="tipoCuenta1" class="form-select">
                                        <option value="activo">Activo</option>
                                        <option value="pasivo">Pasivo</option>
                                        <option value="capital">Patrimonio</option>
                                        <option value="crd">Resultado deudoras</option>
                                        <option value="cra">Resultado acreedoras</option>
                                        <option value="cl">Liquidadoras</option>
                                      </select>
                                </div>
    
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                                    <label for="saldo1" class="col-form-label">Saldo</label>
                                    <select name="saldo1" class="form-select">
                                        <option value="deudor">Deudor</option>
                                        <option value="acreedor">Acreedor</option>
                                      </select>
                                </div>
                            </div>

                        </div>

                        <div class="my-3 mx-auto d-flex justify-content-center  align-items-center">
                            <button class="btn btn-primary m-1" id="agregarCuenta" type="button">Agregar cuenta</button>
                            <button class="btn btn-primary m-1" id="quitarCuenta" type="button">Quitar cuenta</button>
                        </div>

                        <br>
                    
                        <button class="btn btn-primary" type="submit">Guardar</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function (){
            let cont = 1;

            $("#agregarCuenta").click(function(){
                cont +=1;
                $("#catalogo").append(`
                    <div class="row rounded border pb-3 px-2 mx-2 my-2 cuenta${cont}">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                            <label for="codigoCatalogo${cont}" class="col-form-label">Codigo de cuenta</label>
                            <input type="text" name="codigoCatalogo${cont}" class="form-control">
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                            <label for="nombreCuenta${cont}" class="col-form-label">Nombre de cuenta</label>
                            <input type="text" name="nombreCuenta${cont}" class="form-control">
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                            <label for="codigoPadre${cont}" class="col-form-label">Codigo cuenta padre</label>
                            <input type="text" name="codigoPadre${cont}" class="form-control">
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                            <label for="nivelCuenta${cont}" class="col-form-label">Nivel de cuenta</label>
                            <input type="number" min="1" name="nivelCuenta${cont}" class="form-control">
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                            <label for="tipoCuenta${cont}" class="col-form-label">Tipo</label>
                            <select name="tipoCuenta${cont}" class="form-select">
                                <option value="activo">Activo</option>
                                <option value="pasivo">Pasivo</option>
                                <option value="capital">Patrimonio</option>
                                <option value="crd">Resultado deudoras</option>
                                <option value="cra">Resultado acreedoras</option>
                                <option value="cl">Liquidadoras</option>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-2">
                            <label for="saldo${cont}" class="col-form-label">Saldo</label>
                            <select name="saldo${cont}" class="form-select">
                                <option value="deudor">Deudor</option>
                                <option value="acreedor">Acreedor</option>
                            </select>
                        </div>
                    </div>
                `);
            });

            $("#quitarCuenta").click(function(){
                
                if(cont>1){
                    $("#catalogo").find(`.cuenta${cont}`).remove();
                    cont -=1;
                }
            });

        });
    </script>
@endsection
