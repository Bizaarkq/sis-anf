<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        //dd($sumaActivo, $sumaPasivo, $sumaCapital);
        //dd($total, $cuentas);
        //dd($cuentas);
        return view('analisis-vertical.index', compact('cuentas', 'total', 'sumaActivo', 'sumaPasivo', 'sumaCapital'));
    }
}
