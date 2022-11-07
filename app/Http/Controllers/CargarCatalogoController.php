<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CargarCatalogoController extends Controller
{
    public function show(){
        
        return view('cargar-catalogo.index');
    }
}
