<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatiosController extends Controller
{
    //
    public function index(Request $request){
        $empresaID = $request->session()->get('empresaID');
        
        //Ratios segun la empresa seleccionada y segun periodo activo 
        $ratios = DB::table('RATIO')
        ->join('PERIODO', 'PERIODO.ID_PERIODO', '=', 'RATIO.ID_PERIODO')
        ->join('RATIO_CATALOGO', 'RATIO_CATALOGO.ID_RATIO_CATALOGO', '=', 'RATIO.ID_RATIO_CATALOGO')
        ->join('TIPO_SECTOR', 'TIPO_SECTOR.ID_TIPO_SECTOR', '=', 'RATIO.ID_TIPO_SECTOR')
        ->join('EMPRESA', 'EMPRESA.ID_EMPRESA', '=', 'RATIO.ID_EMPRESA')
        ->join('RATIO_POR_TIPO', 'RATIO_POR_TIPO.ID_TIPO_SECTOR', 'RATIO.ID_TIPO_SECTOR')
        ->select('VALOR_RATIO_POR_TIPO', 'PERIODO.ID_PERIODO', 'RATIO_CATALOGO.NOMBRE_RATIO_CATALOGO', 
                'TIPO_SECTOR.ID_TIPO_SECTOR','TIPO_SECTOR.NOMBRE_TIPO_SECTOR', 'RATIO.VALOR_RATIO','EMPRESA.NOMBRE_EMPRESA')
        ->where('EMPRESA.ID_EMPRESA', '=', $empresaID)
        ->where('PERIODO.ACTIVO_PERIODO', '=', 1)
        ->get();


        return view('ratios.index', compact('ratios'));
    }
}
