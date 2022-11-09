<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partida;
use App\Models\Empresa;
use App\Models\Cuenta;
use DB;
use Log;

class CuentasController extends Controller
{
    public function ledger($periodo, $cuentasMayor){ // hecho el 11/11/2021 no se si le entendere despues

        DB::enableQueryLog();
        $items = Partida::Select('ID_PARTIDA','DESCRIPCION_PARTIDA','FECHA_PARTIDA')
        ->where('ID_EMPRESA', session('empresaID'))
        ->where('ID_PERIODO', $periodo)
        ->orderby('FECHA_PARTIDA')
        ->with(['libros:ID_LIBRO_DIARIO,ID_CATALOGO,DEBE,HABER,ID_PARTIDA', 
        'libros.cuenta:ID_CATALOGO,NOMBRE_CATALOGO_CUENTAS,CODIGO_CATALOGO,CORRIENTE,SALDO,TIPO_CUENTA'])
        ->get();

        $ledger = [];

        if (count($items)) {
            $accounts = $cuentasMayor;
        
            $table = ['id' => '', 'title' => '','debits' => [],'credits' => [],'totaldebits' => 0,'totalcredits' => 0,'total' => 0,'cd' => 0, 'cc' => 0];
            $debit = ['mount' => 0,'item_num' => 0];
            $credit = ['mount' => 0,'item_num' => 0];
            $cont = 1;
        
            foreach ($accounts as $account) {
                $table['title'] = $account->NOMBRE_CATALOGO_CUENTAS;
                $table['id'] = $account->CODIGO_CATALOGO;
                $table['saldo'] = $account->SALDO;
                $table['tipo'] = $account->TIPO_CUENTA;
                $table['corriente'] = $account->CORRIENTE;
                foreach ($items as $item) {
                    foreach ($item->libros as $part) {
                        if (str_starts_with($part->cuenta->CODIGO_CATALOGO, $account->CODIGO_CATALOGO)) {
                            if ($part->DEBE > 0) {
                                $debit['mount'] = $part->DEBE;
                                $debit['item_num'] = $cont;
                                $table['totaldebits'] += $debit['mount'];
                                array_push($table['debits'], $debit);
                                $debit = ['mount' => 0,'item_num' => 0];
                            }
                            if ($part->HABER > 0) {
                                $credit['mount'] = $part->HABER;
                                $credit['item_num'] = $cont;
                                $table['totalcredits'] += $credit['mount'];
                                array_push($table['credits'], $credit);
                                $credit = ['mount' => 0,'item_num' => 0];
                            }
                        }
                    }
                    $cont++;
                }
                $cont = 1;
            
                if ($table['totaldebits']>$table['totalcredits']) {
                    $table['total'] = $table['totaldebits'] - $table['totalcredits'];
                } elseif ($table['totalcredits']>$table['totaldebits']) {
                    $table['total'] = $table['totalcredits'] - $table['totaldebits'];
                } else {
                    $table['total'] = 0;
                }
            
                if (!(empty($table['debits']) && empty($table['credits']))) {
                    $table['cd'] = count($table['debits']);
                    $table['cc'] = count($table['credits']);
                    array_push($ledger, $table);
                }
                $table = ['id' => '', 'title' => '','debits' => [],'credits' => [],'totaldebits' => 0,'totalcredits' => 0,'total' => 0,'cd' => 0, 'cc' => 0];
            }
        }
        
        return $ledger;
    }

    public function getLedgerAccounts(){

        $confCuentas = Empresa::where('ID_EMPRESA',session('empresaID'))->pluck('CONFIG_CUENTA')[0];
        $nivelCuentasMayor = json_decode($confCuentas, true)['nivelCuentasMayor'];
        
        $accounts = Cuenta::all()
        ->where('NIVEL', $nivelCuentasMayor)
        ->where('ID_EMPRESA',session('empresaID'));

        return $accounts;
    }
}
