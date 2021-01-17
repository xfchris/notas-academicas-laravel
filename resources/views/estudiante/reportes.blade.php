@extends('layout.app')

@section('contenido')
<div class="container-md">

    <div class="row">
        <div class="col-md-3 col-sm-12">
            
            <div class="card">
              <div class="card-header bg-info">
                <b>Filtros</b>
              </div>
                <div class="card-body">
                  <p class="card-text">Filtrar por rango de porcentaje de logro total obtenido entre:</p>

                  <div class="row">
                    <div class="col-6 pr-2">
                      <input id="filtrarReporteMin" type="number" min="0" max="100" value="0" class="form-control" placeholder="Nínima"
                      data-toggle="tooltip" data-placement="top" title="Porcentaje mínimo" />
                    </div>
                    <div class="col-6 pl-2">
                      <input id="filtrarReporteMax" type="number" min="0" max="100" value="100" class="form-control" placeholder="Máxima" 
                      data-toggle="tooltip" data-placement="top" title="Porcentaje máximo" />
                    </div>
                  </div>

                  <br/>
                  <input id="buscarReporte" type="text" class="form-control" placeholder="Buscar en la tabla..." />
                 
                </div>
            </div>

            <div class="card mt-4 mb-5">
                <div class="card-body">
                  <h5 class="card-title">{{$porcentajeTotal}}% de porcentaje de logro</h5>
                  <p class="card-text">Obtenido de los {{$estudiantes->count()}} estudiantes.</p>
                </div>
            </div>

        </div>
        <div class="col-md-9 col-sm-12 scrollReporte">
            
          <h3 class="mb-4 text-right">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart" viewBox="0 0 16 16">
              <path d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5v12h-2V2h2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z"/>
            </svg>   
            Reporte de estudiantes
          </h3>
          
            <table id="tablaReporte" class="table table-hover table-bordered table-sm d-none-ni fadeIn">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Fecha de nacimiento</th>

                    @foreach ($evaluaciones as $evaluacion)
                        <th scope="col" data-toggle="tooltip" data-placement="top" title="{{$evaluacion->titulo}}">{{$evaluacion->getTituloResumido()}}</th>
                    @endforeach
                    <th scope="col" data-toggle="tooltip" data-placement="top" title="Porcentaje de logro obtenido total">P. total</th>

                  </tr>
                </thead>
                <tbody>
                
                @foreach ($estudiantes as $estudiante)
                 <tr>
                    <th scope="row">{{$estudiante->id}}</th>
                    <td>{{$estudiante->nombres}}</td>
                    <td>{{$estudiante->apellidos}}</td>
                    <td>{{$estudiante->getFechaNacimiento()}}</td>

                    @foreach ($estudiante->calificaciones as $calificacion)
                        <td scope="col"
                        data-toggle="tooltip" data-placement="left" title="Calificación: {{$calificacion['calificacion']}}"
                        >{{$calificacion['porcentaje']}}%</td>
                    @endforeach

                    <td class="table-primary">{{$estudiante->porcentajeTotal}}%</td>
                  </tr>
                @endforeach
                 
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection