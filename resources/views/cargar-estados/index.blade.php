@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Estados de resultados <span> | <button id="downloadExcel" type="button"
                                class="btn btn-link">Descargar Excel</button></span></h5>
                    <form action="{{route('cargar-estados.load')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-2 col-md-4 col-sm-4">
                                <label for="periodo" class="form-label">Periodo</label>
                                <select name="periodoEstado" id="periodo" class="form-select">
                                    @foreach ($periodos as $periodo)
                                        <option value="{{ $periodo }}">{{ $periodo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <br>
                        <!-- Default Tabs -->
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
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h3>Activos</h3>

                                        <h4>Activos corrientes</h4>

                                        <div class="row mb-3">
                                            <label for="efectivoEq"
                                                class="col-sm-9 col-form-label activos activos-corrientes">Efectivo y
                                                equivalente</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="efectivoEq" name="1"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="accxc"
                                                class="col-sm-9 col-form-label activos activos-corrientes">Cuentas por
                                                cobrar</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="accxc" name="2" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="prestamos"
                                                class="col-sm-9 col-form-label activos activos-corrientes">Prestamos y
                                                anticipos a empleados</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="prestamos" name="3" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="deudores"
                                                class="col-sm-9 col-form-label activos activos-corrientes">Deudores
                                                varios</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="deudores" name="4" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="pagosAnt"
                                                class="col-sm-9 col-form-label activos activos-corrientes">Pagos
                                                anticipados</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="pagosAnt" name="5" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="pagosCuenta"
                                                class="col-sm-9 col-form-label activos activos-corrientes">Pagos a
                                                cuenta</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="pagosCuenta" name="6"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="credito"
                                                class="col-sm-9 col-form-label activos activos-corrientes">Crédito Fiscal
                                                IVA</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="credito" name="7"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inventario"
                                                class="col-sm-9 col-form-label activos activos-corrientes">Inventarios</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="inventario" name="8"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="totalActivosCorrientes" class="col-sm-9 col-form-label">
                                                <h5>Total de activos corrientes</h5>
                                            </label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="totalActivosCorrientes"
                                                    name="9" class="form-control">
                                            </div>
                                        </div>

                                        <h4>Activos no corrientes</h4>

                                        <div class="row mb-3">
                                            <label for="propiedad"
                                                class="col-sm-9 col-form-label activos activos-no-corrientes">Propiedad,
                                                planta y equipo</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="propiedad" name="10"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="deprec"
                                                class="col-sm-9 col-form-label activos activos-no-corrientes">Depreciación
                                                acumulada</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="deprec" name="11"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="seguros"
                                                class="col-sm-9 col-form-label activos activos-no-corrientes">Seguros
                                                pagados anticipados y diferidos</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="seguros" name="12"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="intangibles"
                                                class="col-sm-9 col-form-label activos activos-no-corrientes">Intangibles</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="intangibles" name="13"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="depositos"
                                                class="col-sm-9 col-form-label activos activos-no-corrientes">Depositos en
                                                garantía</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="depositos" name="14"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="totalActivosNoCorrientes" class="col-sm-9 col-form-label">
                                                <h5>Total de activos no corrientes</h5>
                                            </label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="totalActivosNoCorrientes"
                                                    name="15" class="form-control">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="totalActivos" class="col-sm-9 col-form-label">
                                                <h4>Total de activos</h4>
                                            </label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="totalActivos" name="16"
                                                    class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3>Pasivos</h3>

                                                <h4>Pasivos corrientes</h4>

                                                <div class="row mb-3">
                                                    <label for="proveedores"
                                                        class="col-sm-9 col-form-label pasivos-corrientes pasivos">Proveedores</label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="proveedores" name="17"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="acreedores"
                                                        class="col-sm-9 col-form-label pasivos-corrientes pasivos">Acreedores</label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="acreedores" name="18"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="retenciones"
                                                        class="col-sm-9 col-form-label pasivos-corrientes pasivos">Retenciones</label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="retenciones" name="19"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="impuestosxpagar"
                                                        class="col-sm-9 col-form-label pasivos-corrientes pasivos">Impuesto
                                                        por pagar</label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="impuestosxpagar" name="20"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="provision"
                                                        class="col-sm-9 col-form-label pasivos-corrientes pasivos">Provisión
                                                        laboral</label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="provision" name="21"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="prestamoscortoplazo"
                                                        class="col-sm-9 col-form-label pasivos-corrientes pasivos">Prestamos
                                                        a corto plazo</label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="prestamoscortoplazo"
                                                            name="22" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="totalPasivosCorrientes" class="col-sm-9 col-form-label">
                                                        <h5>Total de pasivos corrientes</h5>
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="totalPasivosCorrientes"
                                                            name="23" class="form-control">
                                                    </div>
                                                </div>

                                                <h4>Pasivos no corrientes</h4>
                                                <div class="row mb-3">
                                                    <label for="prestamoslargoplazo"
                                                        class="col-sm-9 col-form-label pasivos-no-corrientes pasivos">Prestamos
                                                        a largo plazo</label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="prestamoslargoplazo"
                                                            name="24" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="totalPasivosNoCorrientes" class="col-sm-9 col-form-label">
                                                        <h5>Total de pasivos no corrientes</h5>
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="totalPasivosNoCorrientes"
                                                            name="25" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="totalPasivos" class="col-sm-9 col-form-label">
                                                        <h4>Total de pasivos</h4>
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="totalPasivos" name="26"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3>Patrimonio</h3>

                                                <div class="row mb-3">
                                                    <label for="capitalsocial" class="col-sm-9 col-form-label">Capital
                                                        social</label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="capitalsocial" name="27"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="reservas" class="col-sm-9 col-form-label">Reservas</label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="reservas" name="28"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="utilidades" class="col-sm-9 col-form-label">Utilidades no
                                                        distribuidas</label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="utilidades" name="29"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="utilidadejercicio"
                                                        class="col-sm-9 col-form-label">Utilidad del ejercicio</label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="utilidadejercicio"
                                                            name="30" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="totalPatrimonio" class="col-sm-9 col-form-label">
                                                        <h4>Total de Patrimonio</h4>
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="totalPatrimonio" name="31"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="totalPasivoPatrimonio" class="col-sm-9 col-form-label">
                                                        <h4>Total de pasivo mas patrimonio</h4>
                                                    </label>
                                                    <div class="col-sm-3">
                                                        <input required type="number" step="0.01" id="totalPasivoPatrimonio"
                                                            name="32" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="estadoRe" role="tabpanel" aria-labelledby="estadoReTab">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row mb-3">
                                            <label for="ingresos"
                                                class="col-sm-9 col-form-label estado-resultado">Ingresos</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="ingresos" name="33"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="costoventas" class="col-sm-9 col-form-label estado-resultado">(-)
                                                Costo de ventas</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="costoventas" name="34"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="utilidadbruta"
                                                class="col-sm-9 col-form-label estado-resultado">(=) Utilidad bruta</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="utilidadbruta" name="35"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="gastosoperacion"
                                                class="col-sm-9 col-form-label estado-resultado">(-) Gastos de
                                                operación</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="gastosoperacion" name="36"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="gastosadmin"
                                                class="col-sm-9 col-form-label estado-resultado">Gastos de
                                                administración</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="gastosadmin" name="37"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="gastosmercadeo"
                                                class="col-sm-9 col-form-label estado-resultado">Gastos de ventas y
                                                mercadeo</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="gastosmercadeo" name="38"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="gastosfinan"
                                                class="col-sm-9 col-form-label estado-resultado">Gastos financieros</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="gastosfinan" name="39"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="utilidadoperacion"
                                                class="col-sm-9 col-form-label estado-resultado">(=) Utilidad de
                                                operación</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="utilidadoperacion" name="40"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="otrosingresos"
                                                class="col-sm-9 col-form-label estado-resultado">(+) Otros ingresos</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="otrosingresos" name="41"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="utilidadimpuesto"
                                                class="col-sm-9 col-form-label estado-resultado">(=) Utilidad antes de
                                                impuestos y reserva legal</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="utilidadimpuesto" name="42"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="reservalegal" class="col-sm-9 col-form-label estado-resultado">(-)
                                                Reserva legal</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="reservalegal" name="43"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="impuestorenta"
                                                class="col-sm-9 col-form-label estado-resultado">(-) Impuesto sobre la
                                                renta</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="impuestorenta" name="44"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="utilidadneta" class="col-sm-9 col-form-label estado-resultado">(=)
                                                Utilidad neta</label>
                                            <div class="col-sm-3">
                                                <input required type="number" step="0.01" id="utilidadneta" name="45"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div><!-- End Default Tabs -->


                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-md-12">
                                <div class="row">
                                    <label for="formFile" class="col-sm-3 col-form-label">Subir Excel</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="file" id="formFile" name="formFile">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <br>
                    
                        <button class="btn btn-primary"type="submit">Guardar</button>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function cargarEstadoPeriodo() {
                var periodo = $('#periodo').val();
                if (periodo) {
                    $.ajax({
                        url: "{{ url('/cargar-estados/obtener') }}/" + periodo,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            if(!Object.entries(data).length){
                                for(var i = 1; i <= 45; i++){
                                    $("input[name="+i +"]").val(0);
                                }
                            }else{
                                Object.entries(data).forEach(([key, value]) => {
                                    $("input[name=" + key + "]").val(value);
                                });
                            }                            
                        }
                    });
                } else {
                    alert('Seleccione un periodo');
                }
        }

        $(document).ready(function() {
            $('#downloadExcel').on('click', function() {
                window.location.href = "{{ route('cargar-estados.export-excel') }}";
            });
            $('#periodo').on('change', cargarEstadoPeriodo);
        });

        $(window).on('load', cargarEstadoPeriodo);

    </script>
@endsection
