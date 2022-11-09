<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;
use DB;

class AnalisisHorizontalController extends Controller
{
    
    public function index(){
        $periodos = DB::table('PERIODO')->pluck('ID_PERIODO');

        $cuentasMayor = app('App\Http\Controllers\CuentasController')->getLedgerAccounts();
        $cuentas = [];
        $variaciones = [];
        $periodoscc = [];

        foreach ($periodos as $periodo) {
            $prueba = app('App\Http\Controllers\CuentasController')->ledger($periodo, $cuentasMayor);
            
            if(!empty($prueba)){
                foreach($prueba as $prub){
                    if(!in_array($periodo, $periodoscc)){
                        $periodoscc[] = $periodo; 
                    }
                    $total = $prub['saldo'] == 'DEUDOR' ? 
                    $prub['totaldebits'] - $prub['totalcredits'] : 
                    $prub['totalcredits'] - $prub['totaldebits'];
                    $variaciones[$prub['id']][$periodo] = $total;
                    if($prub['corriente'] === null){
                        $cuentas[$prub["tipo"]][$prub['id']] = $prub["title"];
                    }else{
                        $cuentas[$prub["tipo"]][$prub['corriente']][$prub['id']] = $prub["title"];
                    }
                }
            }            
        }
        //dd($cuentas, $periodosConCuentas, $cuentasMayor, $variaciones);
        return view('analisis.horizontal', compact('cuentas', 'variaciones', 'periodoscc'));
        
    }

}
