<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Imagen;
use App\Models\Proveedor;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class Productos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = "Productos";
        $items = Producto::select(
            'productos.*',
            'categorias.nombre as nombre_categoria',
            'proveedores.nombre as nombre_proveedor',
            'imagenes.ruta as imagen_producto',
            'imagenes.id as imagen_id'
        )
        ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
        ->join('proveedores', 'productos.proveedor_id', '=', 'proveedores.id')
        ->leftJoin('imagenes', 'productos.id', '=', 'imagenes.producto_id')
        ->get();
        return view('modules.productos.index', compact('titulo', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = "Crear producto";
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('modules.productos.create', compact('titulo', 'categorias', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // En app/Http/Controllers/Productos.php

    public function store(Request $request)
    {
        try {
            $item = new Producto(); // Corregido: usa mayúscula inicial Producto() si tu modelo es así
            $item->user_id = Auth::user()->id;
            $item->categoria_id = $request->categoria_id;
            $item->proveedor_id = $request->proveedor_id;
            $item->codigo = $request->codigo;
            $item->nombre = $request->nombre;
            $item->descripcion = $request->descripcion;
            $item->save();
            $id_producto = $item->id;

            if ($id_producto > 0) {
                
                // 🛑 CORRECCIÓN CLAVE: Verificar si existe el archivo antes de llamar a subir_imagen
                if ($request->hasFile('imagen')) { 
                    if ($this->subir_imagen($request, $id_producto)) {
                        return to_route('productos')->with('success', 'Producto creado y imagen subida exitosamente.');
                    } else {
                        // Si falla el save() del modelo Imagen, no la subida
                        return to_route('productos')->with('error', 'Producto creado, pero falló al guardar la referencia de la imagen.');
                    }
                } else {
                    // Si no hay archivo, simplemente continúa y retorna éxito de producto
                    return to_route('productos')->with('success', 'Producto creado exitosamente (sin imagen).');
                }
            }
        } catch (\Throwable $th) {
            return to_route('productos')->with('error', 'Fallo al crear producto.' . $th->getMessage());
        }
    }

    public function subir_imagen($request, $id_producto){
        // Verificar si el archivo 'imagen' existe. Si no, retornamos falso.
        if (!$request->hasFile('imagen')) {
            return false; 
        }
        
        // Si existe, procede la subida.
        $rutaImagen = $request->file('imagen')->store('imagenes', 'public');
        $nombreImagen = basename($rutaImagen);

        $item = new Imagen();
        $item->producto_id = $id_producto;
        $item->nombre = $nombreImagen;
        $item->ruta = $rutaImagen;
        
        return $item->save();
    } 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $titulo = 'Eliminar producto';
        $items = Producto::select(
            'productos.*',
            'categorias.nombre as nombre_categoria',
            'proveedores.nombre as nombre_proveedor'
        )
        ->join('categorias', 'productos.categoria_id', '=', 'categorias.id')
        ->join('proveedores', 'productos.proveedor_id', '=', 'proveedores.id')
        ->where('productos.id', $id)
        ->first();
        return view('modules.productos.show', compact('titulo', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = 'Editar producto';
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        $item = Producto::find($id);
        return view('modules.productos.edit', compact('titulo', 'item', 'categorias', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Producto::find($id);
            $item->categoria_id = $request->categoria_id;
            $item->proveedor_id = $request->proveedor_id;
            $item->codigo = $request->codigo;
            $item->nombre = $request->nombre;
            $item->descripcion = $request->descripcion;
            $item->precio_venta = $request->precio_venta;
            $item->save();
            return to_route('productos')->with('success', 'Producto actualizado exitosamente.');
        } catch (\Throwable $th) {
            return to_route('productos')->with('error', 'Fallo al actualizar producto.' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Producto::find($id);
            $item->delete();
            return to_route('productos')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Throwable $th) {
            return to_route('productos')->with('error', 'Fallo al eliminar producto.' . $th->getMessage());
        }
    }

    public function estado($id, $estado){
        $item = Producto::find($id);
        $item->activo = $estado;
        return $item->save();
    }
}
