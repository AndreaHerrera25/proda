@extends('layouts.main')

@section('titulo', $titulo)
@section('contenido')
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Agregar Usuario</h1>
  </div>
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Agregar Nuevo Usuario</h5>
            
            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <label for="name">Nombre de usuario</label>
                <input type="text" class="form-control"  required name="name" id="name">
                <label for="email">Email</label>
                <input type="email" class="form-control" required name="email" id="email">
                <label for="password">Password</label>
                <input type="password" class="form-control" required name="password" id="password">
                <label for="rol">Rol</label>
                <select name="rol" id="rol" class="form-select" required>
                    <option value="">Seleccione un rol</option>
                    <option value="admin">Administrador</option>
                    <option value="cajero">Cajero</option>
                </select>
                <button class="btn btn-primary mt-3">Guardar</button>
                <a href="{{ route('usuarios') }}" class="btn btn-info mt-3">Cancelar</a>
            </form>
            </div>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection