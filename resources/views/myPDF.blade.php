<!DOCTYPE html>
<html>
<head>
    <title>Lista de Postulantes</title>
    <style>



            /** Define the header rules **/
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 3cm;
    }

    body {
                margin-top: 2cm;

            }

    #cabecera {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    font-size: x-small;
    }

    #customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    .center{
    text-align:center;
    }

    .right{
        text-align: right;
    }

    #customers td, #customers th {
    border: 1px solid #DDDDDD;
    font-size: x-small;
    padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #fff;}


    #customers tr:hover {
        background-color: #DDD;
        }

    #customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    font-size: x-small;
    background-color: #0e3d80;
    color: white;
    }
    </style>
</head>
<body>
        <script type="text/php">
            if (isset($pdf)) {
              $font = $fontMetrics->getFont("Arial", "bold");
              $today = date("d/m/Y h:i:s");
              $pdf->page_text(535, 760, "Pagina {PAGE_NUM}", $font, 10, array(0, 0, 0));
              $pdf->page_text(40, 760, "Fecha de Impresión: {$today}", $font, 10, array(0, 0, 0));
            }
          </script>
    <header>
        <img src="{{public_path('img/logofull.png')}}" class="imagencentro" width="690" >
    </header>


                  <p>
                    <strong>Proyecto:</strong> {{$project->name}}<br>
                    <div id="cabecera">
                    <strong>Código:</strong> {{$project->id}}<br>
                    <strong>Programa:</strong> FONAVIS<br>
                    <strong>SAT:</strong> {{ utf8_encode($project->sat_id?$project->getSat->NucNomSat:"") }}<br>
                    <strong>Departamento: </strong> {{$project->state_id?$project->getState->DptoNom:""}}<br>
                    <strong>Distrito:</strong> {{$project->city_id}}<br>
                    <strong>Modalidad:</strong> {{$project->modalidad_id?$project->getModality->name:""}}<br>
                    <strong>Tipo de Terreno:</strong> {{$project->land_id?$project->getLand->name:""}}<br>
                    <strong>Total Postulantes:</strong> {{ $postulantes->count() }}<br>
                  </p>

              <h2>Lista de Postulantes</h2>

    </div>

    <table class="table" id="customers">
        <tbody>
        <tr>
          <th class="center" style="width:3px;">#</th>
          <th style="width:400px;">Nombre</th>
          <th class="center" style="width:10px;">Cédula</th>
          <th class="center" style="width:10px;">Edad</th>
          <th class="center" style="width:10px;">Ingreso</th>
    <!--      <th class="center" style="width:10px;">Nivel</th> -->
          <th class="center">Celular</th>

        </tr>
        @foreach($postulantes as $key=>$post)
        <tr>
          <td style="width:3px;">{{$key+1}}</td>
          <td>{{ $post->postulante_id?$post->getPostulante->first_name:"" }} {{ $post->postulante_id?$post->getPostulante->last_name:"" }}</td>
            @if (is_numeric($post->postulante_id?$post->getPostulante->cedula:""))
            <td class="text-center">{{ number_format($post->postulante_id?$post->getPostulante->cedula:"",0,".",".")  }} </td>
            @else
            <td class="text-center">{{ $post->postulante_id?$post->getPostulante->cedula:""  }} </td>
            @endif
          <td class="center">{{ \Carbon\Carbon::parse($post->postulante_id?$post->getPostulante->birthdate:"")->age }} </td>
          <td class="right">{{ number_format(App\Models\ProjectHasPostulantes::getIngreso($post->postulante_id),0,".",".") }} </td>
        <!--  <td class="center">{{ App\Models\ProjectHasPostulantes::getNivel($post->postulante_id) }}</td> -->
          <td class="center">{{ $post->postulante_id?$post->getPostulante->mobile:"" }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
</body>

</html>
