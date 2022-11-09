<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Empresa;
use Log;
use Session;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    
    public function index(){
        $empresas = User::find(Auth::user()->id)->empresas()->select('EMPRESA.ID_EMPRESA', 'EMPRESA.NOMBRE_EMPRESA')
        ->distinct()
        ->get();
        return view('empresa.index', compact('empresas'));
    }

    public function setRolEmpresa(Request $request){
        
        $request->validate([
            'empresaId' => ['required',]
        ]);

        $permisosEmpresa = DB::table('ACCESO_USUARIO')
        ->where('ID_USUARIO', Auth::user()->id)
        ->where('ID_EMPRESA', $request->empresaId)
        ->pluck('ID_OPCION');

        $permisos = DB::table('OPCION_FORM')->whereIn('ID_OPCION', $permisosEmpresa)->get();
        $coleccion = array();
        $tipo_sector = DB::table('EMPRESA')
        ->where('ID_EMPRESA', $request->empresaId)
        ->pluck('ID_TIPO_SECTOR');
        
        foreach($permisos as $permiso){
            $coleccion[$permiso->FORM][] = $permiso->DESC_OPCION;
        }
        Session::put('empresaID', $request->empresaId);
        Session::put('permisos', $coleccion);
        Session::put('idTipoSector', $tipo_sector[0]);
        
        return redirect(route('home'));
    }

}
