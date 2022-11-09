<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model
{
    use HasFactory, SoftDeletes;
    protected $table="TIPO_SECTOR";
    protected $primaryKey="ID_TIPO_SECTOR";

    public function ratios(){
        return $this->hasMany(RatioTipo::class, 'ACCESO_USUARIO', 'ID_RATIO_POR_TIPO', 'ID_TIPO_SECTOR');
    }
}