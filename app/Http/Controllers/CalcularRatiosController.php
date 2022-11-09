<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CalcularRatiosController extends Controller
{

    public function show(Request $request) {
        // Nombre de la empresa.
        $empresa = DB::table('EMPRESA')
                       ->where('ID_EMPRESA',
                               $request->session()->get('empresaID'))
                   ->pluck('NOMBRE_EMPRESA')[0];
    
        $cuentas = array(
        'circulante'=>['1.1', '2.1'],
        'acida' => ['1.1', '1.1.07', '2.1'], //activo corriente, inventario, pasivo corriente
        'trabajo' => ['1.1', '1.1.07', '2.1'], // activo corriente, total activos, pasivo corriente
        'efectivo' => ['1.1.01.01', '2.1.15'] //cja y bancos, gatos pagados por anticipado, pasivo corriente
        );
        
        //Obtener los ratios
        $cuantas = DB::table('EMPRESA')
            ->join('RATIO', 'EMPRESA.ID_EMPRESA', '=', 'RATIO.ID_EMPRESA')
            ->join('PERIODO', 'PERIODO.ID_PERIODO', '=', 'RATIO.ID_PERIODO')
            ->pluck('ID_RATIO');
            
        
        
            
    
        // Cálculo de ratios.
        

        
        //DB::table('TIPO_SECTOR')
        //return $request->session()->all();
        return view('calcular-ratios')
        ->with('nombreEmpresa', $empresa)
        ->with('ratios', [1.0, 0.9, 6.0, 1.2, 0.78]);
    }
}
