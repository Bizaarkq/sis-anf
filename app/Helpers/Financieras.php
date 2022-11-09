<?php

namespace App\Helpers;

class Financieras
{
    const CUENTAS = [
        33 => 'INGRESOS',
        34 => 'COSTO_VENTAS',
        35 => 'UTILIDAD_BRUTA',
        36 => 'GASTOS_OPERACION',
        40 => 'UTILIDAD_OPERACION',
        41 => 'OTROS_INGRESOS',
        42 => 'UTILIDAD_IMP_RES',
        43 => 'RESERVA',
        46 => 'UTILIDAD_IMP',
        44 => 'IMPUESTO_RENTA',
        45 => 'UTILIDAD_NETA'
    ];
    const BALANCE = [
        9 => 'ACTIVO_CORRIENTE',
        15 => 'ACTIVO_NO_CORRIENTE',
        16 => 'ACTIVO_TOTAL',
        23 => 'PASIVO_CORRIENTE',
        25 => 'PASIVO_NO_CORRIENTE',
        26 => 'PASIVO_TOTAL',
        31 => 'PATRIMONIO',
        32 => 'PASIVO_PATRIMONIO',
        1 => "EFECTIVO",
        2 => "CUENTAS_COBRO",
        8 => "INVENTARIOS",
        17 => "PROVEEDORES"
    ];
}
