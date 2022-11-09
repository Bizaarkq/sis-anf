<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Libro;

class Partida extends Model
{
    use HasFactory;
    use Timestamp, SoftDeletes;

    protected $table = 'PARTIDA';
    protected $primaryKey = 'ID_PARTIDA';

    public function libros(){
        return $this->hasMany(Libro::class, 'ID_PARTIDA', 'ID_PARTIDA');
    }
}
