<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Carga de trabajo</title>
</head>
<style>
    main{
        font-size: 9px;
    }
</style>
<body>
    <main>

        <div class="">

            <div>

                <p class="parrafo">
                    Carga de trabajo. {{ $surtidor }}
                </p>

                <div>

                    <table class="table">

                        <thead>

                            <tr>
                                <th>
                                    Solicitud
                                </th>
                                <th>
                                    Tomo
                                </th>
                                <th>
                                    Registro
                                </th>
                                <th>
                                    Distrito
                                </th>
                                <th>
                                    Sección
                                </th>
                                <th>
                                    Asignado a
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($solicitudes as $solicitud)

                                @foreach ($solicitud->archivosRppSolicitados as $archivo)

                                    <tr>

                                        <td>{{ $solicitud->numero }}  {{ $solicitud->formacion ? ' / Formación' : '' }}</td>
                                        <td>{{ $archivo->archivo->tomo }}</td>
                                        <td>{{ $archivo->archivo->registro }}</td>
                                        <td>{{ App\Http\Constantes::DISTRITOS[$archivo->archivo->distrito] }}</td>
                                        <td>{{ $archivo->archivo->seccion }}</td>
                                        <td>{{ $solicitud->asignado_a }}</td>

                                    </tr>

                                @endforeach

                            @endforeach

                        </tbody>

                    </table>

                </div>


            </div>

        </div>

    </main>

</body>
</html>
