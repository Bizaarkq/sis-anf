<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Empresa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'EMPRESA';
    protected $primaryKey = 'ID_EMPRESA';

    public function users(){
        return $this->belongsToMany(User::class, 'ACCESO_USUARIO', 'ID_EMPRESA', 'ID_USUARIO');
    }

}
