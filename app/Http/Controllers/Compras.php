<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Compra;
use Illuminate\Support\Facades\Auth;

class Compras extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = 'compras';
        $items = Compra::select(
            'compras.*',
            'users.name as nombre_usuario',
            'productos.nombre as nombre_producto'
        )
        ->join('users', 'compras.user_id', '=', 'users.id')
        ->join('productos', 'compras.producto_id', '=', 'productos.id')
        ->get();
        return view('modules.compras.index', compact('titulo', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $titulo = 'Comprar productos';
        $item = Producto::find($id);
        return view('modules.compras.create', compact('titulo', 'item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Compra();
            $item->user_id = Auth::user()->id;
            $item->producto_id = $request->id;
            $item->cantidad = $request->cantidad;
            $item->precio_compra = $request->precio_compra;
        if ($item->save()) {
            $item = Producto::find($request->id);
            $item->cantidad = ($item->cantidad + $request->cantidad);
             $item->precio_compra = $request->precio_compra;
            $item->save();
        }
            return redirect()->route('productos')->with('success', 'Compra exitosa');
        } catch (\Throwable $th) {
            return redirect()->route('productos')->with('error', 'No pudo comprar' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = 'Editar compra';
        $item = Compra::select(
            'compras.*',
            'users.name as nombre_usuario',
            'productos.nombre as nombre_producto'
        )
        ->join('users', 'compras.user_id', '=', 'users.id')
        ->join('productos', 'compras.producto_id', '=', 'productos.id')
        ->where('compras.id', $id)
        ->first();
        return view('modules.compras.edit', compact('titulo', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /*
        Si ya hicimos una venta con este producto, no seria buena idea actualizarlo
        */
        try {
            $cantidad_anterior = 0;
            $item = Compra::find($id);
            $cantidad_anterior = $item->cantidad;
            $item->cantidad = $request->cantidad;
            $item->precio_compra = $request->precio_compra;

            if($item->save()){
                $item = Producto::find($request->producto_id);

                $cantidad_anterior = $item->cantidad - $cantidad_anterior;
                $item->cantidad = $cantidad_anterior + $request->cantidad;
                $item->save();
                return redirect()->route('compras')->with('success', 'Compra actualizada con exito');
            } 
        }catch (\Throwable $th) {
            return redirect()->route('compras')->with('error', 'No pudo actualizar la comprar' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
