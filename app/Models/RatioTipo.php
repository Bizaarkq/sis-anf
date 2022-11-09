<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 class RatioTipo extends Model
 {
    use HasFactory, SoftDeletes;
    protected $table="RATIO_POR_TIPO";
    protected $primaryKey="ID_RATIO_POR_TIPO";
    
 }