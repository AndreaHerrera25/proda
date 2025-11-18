@extends('layouts.main')

@section('titulo', $titulo)
@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar Proveedor</h1>
  </div>
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Agregar Nuevo Proveedor</h5>
            <form action="{{ route('proveedores.store') }}" method="POST">
                @csrf
                <label for="nombre">Nombre de proveedor</label>
                <input type="text" class="form-control" required name="nombre" id="nombre">
                <label for="telefono">Telefono</label>
                <input type="text" class="form-control" required name="telefono" id="telefono">
                <label for="email">Email</label>
                <input type="email" class="form-control" required name="email" id="email">
                <label for="cp">CP</label>
                <input type="text" class="form-control" required name="cp" id="cp">
                <label for="sitio_web">Sitio web</label>
                <input type="text" class="form-control" required name="sitio_web" id="sitio_web">
                <label for="notas">Notas</label>
                <textarea class="form-control"  name="notas" id="notas" cols="30" rows="10"></textarea>
                <button class="btn btn-primary mt-3">Guardar</button>
                <a href="{{ route('proveedores') }}" class="btn btn-info mt-3">Cancelar</a>
            </form>
            </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection