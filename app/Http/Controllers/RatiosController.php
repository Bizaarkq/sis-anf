<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Financieras;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use App\Helpers\Ratios;
use PhpParser\Node\Stmt\Return_;
use Log;

class RatiosController extends Controller
{
    //
    public function index(Request $request){
        $empresaID = $request->session()->get('empresaID');
        $idTipoSector = $request->session()->get('idTipoSector');
        //Ratios segun la empresa seleccionada y segun periodo activo 
        $ratios = DB::table('RATIO')
        ->join('PERIODO', 'PERIODO.ID_PERIODO', '=', 'RATIO.ID_PERIODO')
        ->join('RATIO_CATALOGO', 'RATIO_CATALOGO.ID_RATIO_CATALOGO', '=', 'RATIO.ID_RATIO_CATALOGO')
        ->join('TIPO_SECTOR', 'TIPO_SECTOR.ID_TIPO_SECTOR', '=', 'RATIO.ID_TIPO_SECTOR')
        ->join('EMPRESA', 'EMPRESA.ID_EMPRESA', '=', 'RATIO.ID_EMPRESA')
        ->select('PERIODO.ID_PERIODO', 'RATIO_CATALOGO.NOMBRE_RATIO_CATALOGO', 'RATIO_CATALOGO.ID_RATIO_CATALOGO',
                'TIPO_SECTOR.ID_TIPO_SECTOR','TIPO_SECTOR.NOMBRE_TIPO_SECTOR', 'RATIO.VALOR_RATIO','EMPRESA.NOMBRE_EMPRESA')
        ->where('EMPRESA.ID_EMPRESA', '=', $empresaID)
        ->where('PERIODO.ACTIVO_PERIODO', '=', 1)
        ->where('EMPRESA.ID_TIPO_SECTOR', '=', $idTipoSector)
        ->get();

        //Valor nacional
        $valorNacional = DB::table('RATIO_POR_TIPO')
        ->join('RATIO_CATALOGO', 'RATIO_CATALOGO.ID_RATIO_CATALOGO', '=', 'RATIO_POR_TIPO.ID_RATIO_CATALOGO')
        ->join('TIPO_SECTOR', 'TIPO_SECTOR.ID_TIPO_SECTOR', '=', 'RATIO_POR_TIPO.ID_TIPO_SECTOR')
        ->select('RATIO_CATALOGO.ID_RATIO_CATALOGO','RATIO_POR_TIPO.ID_RATIO_POR_TIPO', 'RATIO_POR_TIPO.VALOR_RATIO_POR_TIPO')
        ->where('RATIO_POR_TIPO.ID_TIPO_SECTOR', '=', $idTipoSector)
        ->get();

        //Nombre del sector de la empresa
        $sectorEmpresa = DB::table('TIPO_SECTOR')
        ->where('TIPO_SECTOR.ID_TIPO_SECTOR', '=', $idTipoSector)
        ->pluck('TIPO_SECTOR.NOMBRE_TIPO_SECTOR');
        
        //Promedio de los ratios de las empresas
        $prom = DB::table('RATIO')
        ->join('EMPRESA', 'EMPRESA.ID_EMPRESA', '=','RATIO.ID_EMPRESA')
        ->join('PERIODO', 'PERIODO.ID_PERIODO', '=','RATIO.ID_PERIODO')
        ->select('RATIO.ID_RATIO_CATALOGO', DB::raw('round(AVG(RATIO.VALOR_RATIO),1) as prom'))
        ->where('PERIODO.ACTIVO_PERIODO', '=', 1)
        ->groupBy('RATIO.ID_RATIO_CATALOGO')
        ->get();
        return view('ratios.index', compact('ratios', 'valorNacional', 'sectorEmpresa', 'prom'));
    }

    public function calculoRatios(){
        $periodoActivo = DB::table('PERIODO')->where('ACTIVO_PERIODO', '=', 1)->pluck('ID_PERIODO');
        $registro = DB::table('REGISTRO')
        ->where('ID_EMPRESA', session('empresaID'))
        ->where('ID_PERIODO', $periodoActivo)
        ->pluck("MONTO_REGISTRO", "ID_CUENTA_FINANCIERA");
        $sector = DB::table('EMPRESA')->where('ID_EMPRESA', session('empresaID'))->pluck('ID_TIPO_SECTOR');

        $financieras = [];
        foreach($registro as $key => $value){
            if(array_key_exists($key, Financieras::CUENTAS) ){
                $financieras[Financieras::CUENTAS[$key]] = $value;
            }else if(array_key_exists($key, Financieras::BALANCE)){
                $financieras[Financieras::BALANCE[$key]] = $value;
            }
        }
        $periodoActivo = $periodoActivo[0];
        $sector = $sector[0];

        $ratios_sector = DB::table('RATIO_POR_TIPO')->where('ID_TIPO_SECTOR', $sector)->pluck('ID_RATIO_CATALOGO')->toArray();

        if(in_array(Ratios::CATALOGO['LIQUIDEZ_CORRIENTE'], $ratios_sector)){
            $ratio = $financieras['PASIVO_CORRIENTE'] != 0 ? $financieras['ACTIVO_CORRIENTE'] / $financieras['PASIVO_CORRIENTE'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['LIQUIDEZ_CORRIENTE'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['LIQUIDEZ_ACIDA'], $ratios_sector)){
            
            $ratio = $financieras['PASIVO_CORRIENTE'] != 0 ?($financieras['ACTIVO_CORRIENTE'] - $financieras['INVENTARIOS'])/ $financieras['PASIVO_CORRIENTE'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['LIQUIDEZ_ACIDA'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['ACTIVO_NETO'], $ratios_sector)){
            
            $ratio = $financieras['ACTIVO_TOTAL']!= 0 ? ($financieras['ACTIVO_CORRIENTE'] - $financieras['PASIVO_CORRIENTE']) / $financieras['ACTIVO_TOTAL'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['ACTIVO_NETO'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['EFECTIVO'], $ratios_sector)){
            $ratio = $financieras['PASIVO_CORRIENTE'] != 0 ? ($financieras['INGRESOS'] + $financieras['CUENTAS_COBRO']) / $financieras['PASIVO_CORRIENTE'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['EFECTIVO'], $ratio, $periodoActivo, session('empresaID'), $sector);
        }
        if(in_array(Ratios::CATALOGO['ROTACION_INVENTARIOS'], $ratios_sector)){
            
            $ratio = $financieras['INVENTARIOS'] != 0 ? $financieras['COSTO_VENTAS'] / $financieras['INVENTARIOS'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['ROTACION_INVENTARIOS'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['DIAS_INVENTARIOS'], $ratios_sector)){
            
            $ratio = $financieras['COSTO_VENTAS']!= 0 ? ($financieras['INVENTARIOS'] / ( $financieras['COSTO_VENTAS'] / 365 )) : 0;
            $this->guardarRatio(Ratios::CATALOGO['DIAS_INVENTARIOS'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['ROTACION_CUENTAS_COBRO'], $ratios_sector)){
            
            $ratio = $financieras['CUENTAS_COBRO'] != 0 ? $financieras['INGRESOS'] / $financieras['CUENTAS_COBRO'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['ROTACION_CUENTAS_COBRO'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['MEDIO_COBRANZA'], $ratios_sector)){
            
            $ratio = $financieras['INGRESOS'] != 0 ? ($financieras['CUENTAS_COBRO'] * 365) / $financieras['INGRESOS'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['MEDIO_COBRANZA'], $ratio, $periodoActivo, session('empresaID'), $sector);
            
        }
        if(in_array(Ratios::CATALOGO['ROTACION_CUENTAS_POR_PAGAR'], $ratios_sector)){
            
            $ratio = $financieras['PROVEEDORES'] != 0 ? $financieras['INVENTARIOS'] / $financieras['PROVEEDORES'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['ROTACION_CUENTAS_POR_PAGAR'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['PERIODO_MEDIO_PAGO'], $ratios_sector)){
            
            $ratio = $financieras['INVENTARIOS'] != 0 ? ($financieras['PROVEEDORES'] * 365) / $financieras['INVENTARIOS'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['PERIODO_MEDIO_PAGO'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['ROTACION_ACTIVO_TOTAL'], $ratios_sector)){
            
            $ratio = $financieras['ACTIVO_NO_CORRIENTE'] != 0 ? ($financieras['INGRESOS'] / $financieras['ACTIVO_NO_CORRIENTE']): 0;
            $this->guardarRatio(Ratios::CATALOGO['ROTACION_ACTIVO_TOTAL'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['ROTACION_ACTIVO_FIJOS'], $ratios_sector)){
            
            $ratio = $financieras['ACTIVO_NO_CORRIENTE'] != 0 ? $financieras['INGRESOS'] / $financieras['ACTIVO_NO_CORRIENTE'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['ROTACION_ACTIVO_FIJOS'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['MARGEN_BRUTO'], $ratios_sector)){
        
            $ratio = $financieras['INGRESOS'] != 0 ? $financieras['UTILIDAD_BRUTA'] / $financieras['INGRESOS'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['MARGEN_BRUTO'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['MARGEN_OPERATIVO'], $ratios_sector)){
            
            $ratio = $financieras['INGRESOS'] != 0 ? $financieras['UTILIDAD_OPERACION'] / $financieras['INGRESOS'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['MARGEN_OPERATIVO'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['GRADO_ENDEUDAMIENTO'], $ratios_sector)){
            
            $ratio = $financieras['ACTIVO_TOTAL'] != 0 ? $financieras['PASIVO_TOTAL'] / $financieras['ACTIVO_TOTAL'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['GRADO_ENDEUDAMIENTO'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['GRADO_PROPIEDAD'], $ratios_sector)){
            
            $ratio = $financieras['ACTIVO_TOTAL'] != 0 ? $financieras['PATRIMONIO'] / $financieras['ACTIVO_TOTAL'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['GRADO_PROPIEDAD'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['ENDUDAMIENTO_PATRIOMONIO'], $ratios_sector)){
            
            $ratio = $financieras['PATRIMONIO'] != 0 ? $financieras['PASIVO_TOTAL'] / $financieras['PATRIMONIO'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['ENDUDAMIENTO_PATRIOMONIO'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['COBERTURA_GASTOS'], $ratios_sector)){
            
            $ratio = $financieras['IMPUESTO_RENTA'] != 0 ? $financieras['UTILIDAD_IMP'] / $financieras['IMPUESTO_RENTA'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['COBERTURA_GASTOS'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['RENTABILIDAD_NETA'], $ratios_sector)){
            
            $ratio = $financieras['PATRIMONIO'] != 0 ? $financieras['UTILIDAD_NETA'] / $financieras['PATRIMONIO'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['RENTABILIDAD_NETA'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['RENTABILIDAD_ACTIVO'], $ratios_sector)){
            
            $ratio = $financieras['ACTIVO_TOTAL'] != 0 ? $financieras['UTILIDAD_NETA'] / $financieras['ACTIVO_TOTAL'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['RENTABILIDAD_ACTIVO'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['RENTABILIDAD_VENTAS'], $ratios_sector)){
            
            $ratio = $financieras['INGRESOS'] != 0 ? $financieras['UTILIDAD_NETA'] / $financieras['INGRESOS'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['RENTABILIDAD_VENTAS'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }
        if(in_array(Ratios::CATALOGO['RENTABILIDAD_INVERSION'], $ratios_sector)){
            
            $ratio = $financieras['COSTO_VENTAS'] != 0 ? $financieras['UTILIDAD_NETA'] / $financieras['COSTO_VENTAS'] : 0;
            $this->guardarRatio(Ratios::CATALOGO['RENTABILIDAD_INVERSION'], $ratio, $periodoActivo, session('empresaID'), $sector);

        }

        return response()->json(['message' => 'Ratios calculados correctamente']);
    }

    public function guardarRatio($id, $valor, $idPeriodo, $idEmpresa, $idTipoSector){
        DB::beginTransaction();
        DB::table('RATIO')->UpdateOrInsert(
            ['ID_RATIO_CATALOGO' => $id, 'ID_PERIODO' => $idPeriodo, 'ID_EMPRESA' => $idEmpresa, 'ID_TIPO_SECTOR' => $idTipoSector],
            ['VALOR_RATIO' => $valor]
        );
        DB::commit();
    }

}
