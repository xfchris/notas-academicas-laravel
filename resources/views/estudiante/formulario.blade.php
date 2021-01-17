@extends('layout.app')

@section('contenido')
    <div class="container-sm">

        <div class="col-md-8 offset-md-2">

            @if (count($errors) > 0)
                <div class="alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>

                    <ul class="mb-0 pb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success') or session('error') or session('warning'))
                <div class="alert alert-dismissible alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>

                    {{ session('error') }} {{ session('success') }} {{ session('warning') }}
                </div>
            @endif


        <form class="formulario-e mt-4 fadeIn" method="POST" action="{{route('registrarEstudiante')}}">
            {{ csrf_field() }}
            <fieldset>
                <legend class="d-flex align-items-baseline">
                  <svg class="" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                  </svg>
                  <b class="ml-1 mb-0">Nuevo estudiante</b>
                </legend>
              
              <p>Registra los datos del nuevo estudiante y añade el resultado que obtuvo en cada una de las pruebas.</p>
              
              <div class="row">

                  <div class="form-group col-6">
                    <label for="nombres">Nombres</label>
                    <input type="text" class="form-control" id="nombres" name="estudiante[nombres]" maxlength="120" required>
                  </div>
    
                  <div class="form-group col-6">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="estudiante[apellidos]" maxlength="120" required>
                  </div>

              </div>
              

              <div class="form-group">
                <label for="fechaNacimiento">Fecha de nacimiento</label>
                <input type="date" class="form-control" id="fechaNacimiento" name="estudiante[fechaNacimiento]" required>
              </div>

              <hr  class="mt-4"/>
              <fieldset>
                <b>Registra los puntajes obtenidos</b>
                <p>Siendo 1 la nota más baja y {{config('constants.notaMaxima')}} la más alta</p>

                
                <div class="row mt-1">

                    @foreach ($evaluaciones as $evaluacion)
                        <div class="col-4 d-grid">
                            <div class="form-group form-group d-flex flex-column justify-content-between">
                            <label for="e_{{$evaluacion->id}}">{{$evaluacion->titulo}}</label>
                            <input type="number" max="{{config('constants.notaMaxima')}}" min="1" class="form-control" 
                             id="e_{{$evaluacion->id}}" step=".1"
                            name="evaluacion[{{$evaluacion->id}}]" required>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
              </fieldset>
              

              <button type="submit" class="btn btn-primary btn-espere-submit">Registrar estudiante 
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-vector-pen" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10.646.646a.5.5 0 0 1 .708 0l4 4a.5.5 0 0 1 0 .708l-1.902 1.902-.829 3.313a1.5 1.5 0 0 1-1.024 1.073L1.254 14.746 4.358 4.4A1.5 1.5 0 0 1 5.43 3.377l3.313-.828L10.646.646zm-1.8 2.908l-3.173.793a.5.5 0 0 0-.358.342l-2.57 8.565 8.567-2.57a.5.5 0 0 0 .34-.357l.794-3.174-3.6-3.6z"/>
                    <path fill-rule="evenodd" d="M2.832 13.228L8 9a1 1 0 1 0-1-1l-4.228 5.168-.026.086.086-.026z"/>
                  </svg>
              </button>
            </fieldset>
          </form>

    </div>
    </div>
@endsection