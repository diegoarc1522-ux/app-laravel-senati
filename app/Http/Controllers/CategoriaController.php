<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    //CRUD
    //LISTAR
    public function listarCategoria(){
        //$categorias = Categoria::all();
        //$categorias = Categoria::orderBy('created_at','asc')->get();
        //$categorias = Categoria::first();
        //$categorias = Categoria::find(211);

        $categorias = Categoria::all();

        return response()->json(
            [
                'success'=> true,
                'nombre'=> 'Diego Sanchez',
                'data'=> $categorias,
            ]
        );
    }

    public function agregarCategoria(){

    }

    public function editarCategoria(){

    }

    public function eliminarCategoria(){

    }
}

