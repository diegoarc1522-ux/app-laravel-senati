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
        $categorias = Categoria::orderBy('created_at','desc')->get();
        //$categorias = Categoria::first();
        //$categorias = Categoria::find(211);
        //$categorias = Categoria::all();

        return response()->json([
                'success'=> true,
                'nombre'=> 'Diego Sanchez',
                'data'=> $categorias,
            ]);
    }

    public function guardarCategoria(Request $request){
        $validate = $request->validate([
            'descripcion' => 'required|string',
            'nombre_categoria' => 'required',
        ]);        
        
        $categoria = Categoria::create($request->all());

        return response()->json([
                'success'=> true,
                'nombre'=> 'Diego Sanchez',
                'data'=> $categoria,
            ]);

    }

    public function editarCategoria(){

    }

    public function eliminarCategoria($id_categoria){
        $categoria = Categoria::findOrFail($id_categoria);
        $categoria->delete();

        return response()->json([
                'success'=> true,
                'nombre'=> 'Diego Sanchez',
                'data'=> $categoria,
            ]);
    }
}

