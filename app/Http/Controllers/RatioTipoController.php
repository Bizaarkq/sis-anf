<?php

namespace App\Http\Controllers;

use App\Models\RatioCatalogo;
use App\Models\RatioTipo;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class RatioTipoController extends Controller
{
    public function show(){
        $ratiosNacionales=RatioTipo::
            join('TIPO_SECTOR','TIPO_SECTOR.ID_TIPO_SECTOR','RATIO_POR_TIPO.ID_TIPO_SECTOR')
            ->join('RATIO_CATALOGO','RATIO_CATALOGO.ID_RATIO_CATALOGO','RATIO_POR_TIPO.ID_RATIO_CATALOGO')
            ->where('RATIO_POR_TIPO.VALOR_RATIO_POR_TIPO','!=', null)
            ->select(
                'RATIO_POR_TIPO.ID_RATIO_POR_TIPO',
                'TIPO_SECTOR.NOMBRE_TIPO_SECTOR',
                'RATIO_CATALOGO.NOMBRE_RATIO_CATALOGO',
                'RATIO_POR_TIPO.VALOR_RATIO_POR_TIPO'
            )->get();
        return view('nacionales.index', compact('ratiosNacionales'));
    }

    public function create(){
        $catalogo=RatioTipo::
        join('RATIO_CATALOGO','RATIO_CATALOGO.ID_RATIO_CATALOGO','=','RATIO_POR_TIPO.ID_RATIO_CATALOGO')
        ->where('RATIO_POR_TIPO.VALOR_RATIO_POR_TIPO','=',NULL)
        ->select(
            'RATIO_CATALOGO.ID_RATIO_CATALOGO',
            'RATIO_CATALOGO.NOMBRE_RATIO_CATALOGO'
        )
        ->distinct()->get();
        $sectores=RatioTipo::
        join('TIPO_SECTOR','TIPO_SECTOR.ID_TIPO_SECTOR','=','RATIO_POR_TIPO.ID_TIPO_SECTOR')
        ->select('TIPO_SECTOR.ID_TIPO_SECTOR',
            'TIPO_SECTOR.NOMBRE_TIPO_SECTOR'
        )
        ->distinct()->get();

        return view('nacionales.create', compact('catalogo','sectores'));
    
    }
    public function store(Request $request){
        //DB::enableQueryLog();
        DB::table('RATIO_POR_TIPO')->upsert(["ID_TIPO_SECTOR"=>$request->sectores,  
            "ID_RATIO_CATALOGO" =>$request->catalogo, "VALOR_RATIO_POR_TIPO"=>$request->VALOR_RATIO_POR_TIPO],
            ['UPDATED_USER' => Auth::user()->username,]);
        //log::warning(db::getquerylog());
        //log::warning($request);
        return redirect()->route('nacionales.show');
    }
    
    public function edit(Request $request){
        DB::enableQueryLog();
        $ratioaux=RatioTipo::
            find($request->ID_RATIO_POR_TIPO);
        log::warning($ratioaux);
        $ratio=RatioTipo::
            join('TIPO_SECTOR','TIPO_SECTOR.ID_TIPO_SECTOR','RATIO_POR_TIPO.ID_TIPO_SECTOR')
            ->join('RATIO_CATALOGO','RATIO_CATALOGO.ID_RATIO_CATALOGO','RATIO_POR_TIPO.ID_RATIO_CATALOGO')
            ->where('RATIO_POR_TIPO.ID_RATIO_POR_TIPO','=',$request->ID_RATIO_POR_TIPO)
            ->select(
                'RATIO_POR_TIPO.ID_RATIO_POR_TIPO',
                'TIPO_SECTOR.NOMBRE_TIPO_SECTOR',
                'RATIO_CATALOGO.NOMBRE_RATIO_CATALOGO',
                'RATIO_POR_TIPO.VALOR_RATIO_POR_TIPO'
            )->get();
        
        return view('nacionales.edit',compact('ratio'));
    }
    public function update(Request $request){
        DB::table('RATIO_POR_TIPO')->upsert(["ID_TIPO_SECTOR"=>$request->sectores,  
            "ID_RATIO_CATALOGO" =>$request->catalogo, "VALOR_RATIO_POR_TIPO"=>$request->VALOR_RATIO_POR_TIPO],
            ['UPDATED_USER' => Auth::user()->username,]);
        return redirect()->route('nacionales.show');
        
    }
}