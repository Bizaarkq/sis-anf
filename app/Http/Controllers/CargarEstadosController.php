<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Contracts\Session\Session;
use Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;
use Illuminate\Support\Facades\Auth;

class CargarEstadosController extends Controller
{
    
    public function show(){
        $periodos = DB::table('PERIODO')->pluck('ID_PERIODO');
        return view('cargar-estados.index', compact('periodos'));
    }
    
    public function load(Request $request){
        $cuerpo = $request->post();

        $cuentasFinancierasBase = DB::table('CUENTA_FINANCIERA')->pluck('ID_CUENTA_FINANCIERA','NOMBRE_CUENTA_FINANCIERA')->toArray();
        $empresaID = $request->session()->get('empresaID');
        $registrosExistentes = DB::table('REGISTRO')
        ->Select('ID_REGISTRO','ID_CUENTA_FINANCIERA', 'MONTO_REGISTRO')
        ->Where('ID_EMPRESA', $empresaID)
        ->Where('ID_PERIODO', $cuerpo['periodoEstado'])
        ->get();

        $registro = json_decode(json_encode($registrosExistentes),true);
        $nuevoEstado = empty($registro);
        
        if($request->hasFile('formFile')){
            $data = Excel::toArray(new stdClass, $request->file('formFile'));
            foreach($data as $estadoFinanciero){
                foreach($estadoFinanciero as $cuenta){
                    if(array_key_exists($cuenta[0], $cuentasFinancierasBase)){
                        if($nuevoEstado){
                            $registro[] = [
                                'ID_EMPRESA' => $empresaID,
                                'ID_PERIODO' => $cuerpo['periodoEstado'],
                                'ID_CUENTA_FINANCIERA' => $cuentasFinancierasBase[$cuenta[0]],
                                'MONTO_REGISTRO' => $cuenta[1],
                                'CREATED_USER' => Auth::user()->username,
                                'UPDATED_USER' => Auth::user()->username,
                            ];
                        }else{
                            $key = array_search($cuentasFinancierasBase[$cuenta[0]], array_column($registro, 'ID_CUENTA_FINANCIERA'));
                            if($key !== false){
                                $registro[$key]['MONTO_REGISTRO'] = $cuenta[1];
                            }
                        }
                    }
                }
            }

            if($nuevoEstado){
                DB::table('REGISTRO')->insert($registro);
            }else{
                foreach($registro as $reg){
                    DB::table('REGISTRO')
                    ->Where('ID_REGISTRO', $reg['ID_REGISTRO'])
                    ->update(['MONTO_REGISTRO' => $reg['MONTO_REGISTRO']], ['UPDATED_USER' => Auth::user()->username]);
                }
            }
        }else{
            if($nuevoEstado){
                foreach($cuerpo as $cuenta => $monto){
                    if(!(array_search($cuenta, $cuentasFinancierasBase) === false)){
                        $registro[] = [
                            'ID_EMPRESA' => $empresaID,
                            'ID_PERIODO' => $cuerpo['periodoEstado'],
                            'ID_CUENTA_FINANCIERA' => $cuenta,
                            'MONTO_REGISTRO' => $monto,
                            'CREATED_USER' => Auth::user()->username,
                            'UPDATED_USER' => Auth::user()->username,
                        ];
                    }
                }
                DB::table('REGISTRO')->insert($registro);
            }else{
                foreach($cuerpo as $cuenta => $monto){
                    if(!(array_search($cuenta, $cuentasFinancierasBase) === false)){
                        $key = array_search($cuenta, array_column($registro, 'ID_CUENTA_FINANCIERA'));
                        if($key !== false){
                            $registro[$key]['MONTO_REGISTRO'] = $monto;
                        }
                    }
                }
                foreach($registro as $reg){
                    DB::table('REGISTRO')
                    ->Where('ID_REGISTRO', $reg['ID_REGISTRO'])
                    ->update(['MONTO_REGISTRO' => $reg['MONTO_REGISTRO']], ['UPDATED_USER' => Auth::user()->username]);
                }
            }
        }
        
        return redirect(route('cargar-estados.show'));
    }

    public function exportExcel(){
        return response()->file(storage_path('app/public/plantilla/Estados Financieros.xlsx'), [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="Estados Financieros.xlsx"'
        ]);
    }

    public function getEstados($periodo){
        $empresaID = session()->get('empresaID');
        $estados = DB::table('REGISTRO')
        ->Where('ID_EMPRESA', $empresaID)
        ->Where('ID_PERIODO', $periodo)
        ->pluck('MONTO_REGISTRO','ID_CUENTA_FINANCIERA');
        return response()->json($estados);
    }
    

}
