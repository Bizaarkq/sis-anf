<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalisisVerticalController extends Controller
{
    //
    public function index(Request $request){
        $cuentasMayor = app('App\Http\Controllers\CuentasController')->getLedgerAccounts();
        $cuentas = app('App\Http\Controllers\CuentasController')->ledger(2022, $cuentasMayor);
        return view('analisis-vertical.index', compact('cuentas'));
    }
}
