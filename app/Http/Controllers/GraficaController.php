<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraficaController extends Controller
{
    //
    public function home(Request $request){
        $empresaID = $request->session()->get('empresaID');
        $cuentas = DB::table('CUENTA_FINANCIERA')
        //->where('PARTIDA.ID_EMPRESA', '=', $empresaID)
        //->where('PERIODO.ACTIVO_PERIODO', '=', 1)
        ->orderby('ID_CUENTA_FINANCIERA')
        ->get();

        return view('grafica.home', compact('cuentas'));
    }
}
