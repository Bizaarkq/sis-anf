<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;
    protected $table = 'CATALOGO';
    protected $primaryKey = 'ID_CATALOGO';

    public function subCuentas(){
        return $this->hasMany(Cuenta::class, 'CUENTA_PADRE', 'CODIGO_CATALOGO'); //posee varias subcuentas
    }

    public function todasSubCuentas(){
        return $this->subCuentas()->with('todasSubCuentas');
    }

    public function libros(){
        return $this->hasMany(Libro::class, 'ID_CATALOGO', 'ID_CATALOGO');
    }

}
