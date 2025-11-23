@extends('layouts.main')

@section('titulo', $titulo)
@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Reportes de productos con cantidad 1 o 0</h1>
  </div>
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Reportes de productos con cantidad 1 o 0</h5>
            
            <hr>
            
            <table class="table datatable">
              <thead>
                <tr>
                  <th class="text-start">Categoria</th>
                  <th class="text-start">Proveedor</th>
                  <th class="text-start">Nombre</th>
                  <th class="text-start">Imagen</th>
                  <th class="text-start">Descripcion</th>
                  <th class="text-start">Cantidad</th>
                  <th class="text-start">Venta</th>
                  <th class="text-start">Compra</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $item)
                <tr>
                    <td> {{ $item->nombre_categoria }} </td>
                    <td> {{ $item->nombre_proveedor }} </td>
                    <td> {{ $item->nombre }} </td>
                    <td>  
                      @if ($item->imagen_producto)
                          <img src="{{ asset('storage/' . $item->imagen_producto)}}" alt="Imagen del Producto" width="50px" height="50px">
                      @else
                          <span>[Sin Imagen]</span> 
                      @endif
                    </td>
                    <td> {{ $item->descripcion }} </td>
                    <td class="text-center"> {{ $item->cantidad }} </td>
                    <td class="text-center"> ${{ $item->precio_compra }} </td>
                    <td class="text-center"> ${{ $item->precio_venta }} </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
            </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection