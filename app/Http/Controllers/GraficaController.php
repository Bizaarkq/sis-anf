<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cuenta;
use Log;
use App\Models\Partida;
class GraficaController extends Controller
{
    //
    public function home(Request $request){
        $empresaID = $request->session()->get('empresaID');
        $cuentas = DB::table('CATALOGO')
        ->where('ID_EMPRESA', $empresaID)
        ->select("NOMBRE_CATALOGO_CUENTAS","CODIGO_CATALOGO", "ID_CATALOGO")
        ->get();
        $periodos = DB::table('PERIODO')->pluck("ID_PERIODO");

        return view('grafica.home', compact('cuentas', 'periodos'));
    }

    public function grafica($id, $inicio, $fin){
        DB::enableQueryLog();
        $empresaID = session('empresaID');
        $mayorizacion = [];

        for($i = $inicio; $i <= $fin; $i++){
            $partidas = Partida::where('ID_EMPRESA', $empresaID)
            ->where('ID_PERIODO', '=', $i)
            ->with(['libros:ID_LIBRO_DIARIO,ID_CATALOGO,DEBE,HABER,ID_PARTIDA', 
            'libros.cuenta:ID_CATALOGO,NOMBRE_CATALOGO_CUENTAS,CODIGO_CATALOGO,CORRIENTE,SALDO,TIPO_CUENTA'])
            ->get();

            if (count($partidas)) {
                foreach($partidas as $partida){
                    foreach($partida->libros as $libro){
                        if((str_starts_with($libro->cuenta->CODIGO_CATALOGO, $id))){
                            $mayorizacion[$i] = ($mayorizacion[$i] ?? 0) + ($libro->cuenta->SALDO == "DEUDOR" ? 
                            $libro->DEBE - $libro->HABER 
                            : $libro->HABER - $libro->DEBE);
                        }
                    }
                }
            }

        }

        return response()->json($mayorizacion);
    }

}
