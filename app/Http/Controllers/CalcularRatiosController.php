<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalcularRatiosController extends Controller
{
    //
    public function show(Request $request) {
        //$empresaID = $request->session()->get('empresaID');
        
        //$empresa = DB::select('select * from `EMPRESA` where id = ? limit 1', [$empresaID]);
        
        //DB::table('TIPO_SECTOR')
        //return $request->session()->all();
        return view('calcular-ratios')->with('session', $request->session()->all());
    }
}
