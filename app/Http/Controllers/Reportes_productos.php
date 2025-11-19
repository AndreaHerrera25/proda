<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class Reportes_productos extends Controller
{
    public function index(){
        $titulo = "Reportes productos";
        $items = Producto::select(
            'productos.*',
            'categorias.nombre as nombre_categoria',
            'proveedores.nombre as nombre_proveedor'
        )
        ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
        ->join('proveedores', 'productos.proveedor_id', '=', 'proveedores.id')
        ->get();
        return view('modules.reportes_productos.index', compact('titulo', 'items'));
    }
}
