<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RatioCatalogo extends Model
{
    use HasFactory, SoftDeletes;
    protected $table="RATIO_CATALOGO";
    protected $primaryKey="ID_RATIO_CATALOGO";

    public function ratios(){
        return $this->hasMany(RatioTipo::class, 'ACCESO_USUARIO', 'ID_RATIO_POR_TIPO', 'ID_RATIO_CATALOGO');
    }
}