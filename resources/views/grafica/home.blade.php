@extends('layouts.main')
@section('content')

<section class="section">
    <h4>Cuentas</h4>
    <select id="selectCuenta" class="selectpicker my-2 form-select" data-live-search="true" data-width="100%" name="cuenta">
        @foreach($cuentas as $account)
                <option value="{{$account->CODIGO_CATALOGO}}">{{$account->CODIGO_CATALOGO}} - {{$account->NOMBRE_CATALOGO_CUENTAS}}</option>  
        @endforeach
    </select>
    <label for="periodo_inicio">Periodo de inicio</label>
    <select name="periodoInicio" class="selectpicker my-2 form-select"  id="periodo_inicio">
        @foreach($periodos as $periodo)
            <option value="{{$periodo}}">{{$periodo}}</option>
        @endforeach
    </select>
    <label for="periodo_inicio">Periodo de fin</label>
    <select name="periodoInicio" class="selectpicker my-2 form-select"  id="periodo_fin">
        @foreach($periodos as $periodo)
            <option value="{{$periodo}}">{{$periodo}}</option>
        @endforeach
    </select>
    <canvas id="lineChart" style="max-height: 400px;"></canvas>
</section>
@endsection
@section('js')
<script>
    $(document).ready(function(){

        const chart = new Chart(document.querySelector('#lineChart'), {
                            type: 'line',
                            data: {
                              labels: [],
                              datasets: [{
                                label: 'Line Chart',
                                data: [],
                                fill: false,
                                borderColor: 'rgb(75, 192, 192)',
                                tension: 100
                              }]
                            },
                            options: {
                              scales: {
                                y: {
                                  beginAtZero: true
                                }
                              }
                            }
                        }); 

        $('#selectCuenta').on('change', function(){
            $periodo_inicio = $('#periodo_inicio').val();
            $periodo_fin = $('#periodo_fin').val();
            if( $periodo_inicio > $periodo_fin){
                alert('El periodo de inicio no puede ser mayor al periodo de fin');
            }else{
                var id = $('#selectCuenta').val();
                $.ajax({
                    url: "{{ url('/grafica') }}/" + id + "/" + $periodo_inicio + "/" + $periodo_fin,
                    type: "GET",
                    dataType: "json",
                    success: function(graphics) {
                        chart.data.labels = Object.keys(graphics);
                        chart.data.datasets[0].data = Object.values(graphics);
                        chart.update();                   
                    }
                });
            }
        });
    });
</script>
@endsection