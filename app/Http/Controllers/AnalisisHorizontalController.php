<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;
use DB;
use App\Helpers\Financieras;

class AnalisisHorizontalController extends Controller
{
    
    public function index(){
        $periodos = DB::table('PERIODO')->pluck('ID_PERIODO');

        $cuentasMayor = app('App\Http\Controllers\CuentasController')->getLedgerAccounts();
        $cuentas = [];
        $variaciones = [];
        $financieras = [];
        $periodoscc = [];
        $periodoser = [];

        foreach ($periodos as $periodo) {
            $estados = DB::table('REGISTRO')
            ->where('ID_EMPRESA', session('empresaID'))
            ->where('ID_PERIODO', $periodo)
            ->where('ID_CUENTA_FINANCIERA', '>=', 33)
            ->pluck("MONTO_REGISTRO", "ID_CUENTA_FINANCIERA");

            if(count($estados)){
                foreach($estados as $key => $value){
                    if(array_key_exists($key, Financieras::CUENTAS)){
                        $financieras[$periodo][Financieras::CUENTAS[$key]] = $value;
                    }
                }
                if(!in_array($periodo, $periodoser)){
                    $periodoser[] = $periodo; 
                }                
            }
            
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

        return view('analisis.horizontal', compact('cuentas', 'variaciones', 'periodoscc', 'financieras', 'periodoser'));
        
    }

}
