<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Libro extends Model
{
    use SoftDeletes;
    protected $table = 'LIBRO_DIARIO';
    protected $primaryKey = 'ID_LIBRO_DIARIO';

    public function cuenta(){
        return $this->belongsTo(Cuenta::class, 'ID_CATALOGO', 'ID_CATALOGO');
    }

    public function partida(){
        return $this->belongsTo(Partida::class, 'ID_PARTIDA', 'ID_PARTIDA');
    }
}
