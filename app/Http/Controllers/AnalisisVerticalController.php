<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalisisVerticalController extends Controller
{
    //
    public function index(Request $request){
        $cuentasMayor = app('App\Http\Controllers\CuentasController')->getLedgerAccounts();
        $cuentas = [];
        $total = [];
        $sumaActivo = 0;
        $sumaPasivo = 0;
        $sumaCapital = 0;
        $prueba = app('App\Http\Controllers\CuentasController')->ledger(2022, $cuentasMayor);
        
        //CONSULTA PARA EL ESTADO DE RESULTADO
        $bandera = true;
        $estados = DB::table('REGISTRO')
            ->join('PERIODO', 'PERIODO.ID_PERIODO', '=', 'REGISTRO.ID_PERIODO')
            ->join('CUENTA_FINANCIERA', 'CUENTA_FINANCIERA.ID_CUENTA_FINANCIERA', '=', 'REGISTRO.ID_CUENTA_FINANCIERA')
            ->select("REGISTRO.MONTO_REGISTRO", "REGISTRO.ID_CUENTA_FINANCIERA", 'CUENTA_FINANCIERA.NOMBRE_CUENTA_FINANCIERA')
            ->where('REGISTRO.ID_EMPRESA', session('empresaID'))
            ->where('PERIODO.ACTIVO_PERIODO', '=', 1)
            ->where('REGISTRO.ID_CUENTA_FINANCIERA', '>=', 33)
            ->get();
        //dd($estados);
        $ingresos = 0;
        $ingresosER = DB::table('REGISTRO')
        ->join('PERIODO', 'PERIODO.ID_PERIODO', '=', 'REGISTRO.ID_PERIODO')
        ->join('CUENTA_FINANCIERA', 'CUENTA_FINANCIERA.ID_CUENTA_FINANCIERA', '=', 'REGISTRO.ID_CUENTA_FINANCIERA')
        ->where('REGISTRO.ID_EMPRESA', session('empresaID'))
        ->where('PERIODO.ACTIVO_PERIODO', '=', '1')
        ->where('REGISTRO.ID_CUENTA_FINANCIERA', '=', 33)
        ->pluck('REGISTRO.MONTO_REGISTRO');   
        $ingresos = $ingresosER[0];
        //CODIGO PARA EL BALANCE GENERAL
        if(!empty($prueba)){
            foreach($prueba as $prub){
                $total[$prub['id']] = $prub['saldo'] == 'DEUDOR' ? 
                $prub['totaldebits'] - $prub['totalcredits'] : 
                $prub['totalcredits'] - $prub['totaldebits'];
                
                if($prub['tipo']=='ACTIVO') $sumaActivo += $total[$prub['id']];
                if($prub['tipo']=='PASIVO') $sumaPasivo += $total[$prub['id']];
                if($prub['tipo']=='CAPITAL') $sumaCapital += $total[$prub['id']];

                if($prub['corriente'] === null){
                    $cuentas[$prub["tipo"]][$prub['id']] = $prub["title"];
                }else{
                    $cuentas[$prub["tipo"]][$prub['corriente']][$prub['id']] = $prub["title"];
                }
            }
        }

        //CODIGO PARA EL ESTADO DE RESULTADO
        $cuentasER = DB::table('CUENTA_FINANCIERA')
        ->where('CUENTA_FINANCIERA.ID_ESTADO_FINANCIERO', '=', 2)
        ->get();
        //dd($cuentasER);
        return view('analisis-vertical.index', compact('cuentas', 'total', 'sumaActivo', 'sumaPasivo', 'sumaCapital', 'cuentasER', 'estados', 'ingresos'));
    }
}
