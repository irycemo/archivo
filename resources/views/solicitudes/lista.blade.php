<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo</title>
</head>

<style>

    @page{
        size:58mm 110mm;
        margin: 5;
    }

    #wrapper{
        color: #000;
        font-family: Arial,Helvetica;
    }

    .receipt-header{
        margin-bottom: 20px;
    }

    .receipt-header h1{
        font-family: Arial,Helvetica;
        font-size: 12px;
        text-align: center;
    }

    .content{
        font-size: 10px;
    }

    .content p{
        margin: 0;
        margin-bottom: 5px;
    }

    .title{
        text-align: center;
    }

    .total{
        font-size: 14px;
    }

    .footer p{
        margin:0;
        font-size: 12px;
    }

</style>

<body>
    <div id="wrapper">

        <div class="content">

            <p class="title">Solicitud</p>
            <p>Número: {{ $solicitud->numero }}</p>
            <p>Solicitante: {{ $solicitud->creadoPor->name }}</p>

        </div>

        <div class="footer">

            @foreach ($solicitud->archivosCatastroSolicitados as $archivo)

                <p>{{ $archivo->archivo->localidad }}-{{ $archivo->archivo->oficina }}-{{ $archivo->archivo->tipo }}-{{ $archivo->archivo->registro }}</p>

            @endforeach

        </div>

    </div>

</body>
</html>
