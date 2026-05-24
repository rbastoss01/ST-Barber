<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cita confirmada - ST BARBER</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #ffffff; margin: 0; padding: 0; color: #111111; }
        .wrapper { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background-color: #111111; padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 28px; letter-spacing: 4px; text-transform: uppercase; }
        .header p { color: #aaaaaa; margin: 6px 0 0; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; }
        .body { padding: 40px; }
        .greeting { font-size: 18px; font-weight: bold; margin-bottom: 12px; }
        .intro { color: #555555; line-height: 1.6; margin-bottom: 32px; }
        .card { background-color: #f9f9f9; border-left: 4px solid #111111; border-radius: 4px; padding: 24px 28px; margin-bottom: 32px; }
        .card-title { font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: #888888; margin: 0 0 20px; }
        .detail-item { padding: 12px 0; border-bottom: 1px solid #eeeeee; }
        .detail-item:last-child { border-bottom: none; }
        .detail-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888888; margin-bottom: 4px; }
        .detail-value { font-size: 16px; font-weight: bold; color: #111111; }
        .closing { color: #555555; line-height: 1.6; font-size: 14px; }
    </style>
</head>
<body>
    <div class="wrapper">

        <div class="header">
            <h1>ST BARBER</h1>
            <p>Peluquería</p>
        </div>

        <div class="body">
            <p class="greeting">Hola, {{ $cita->usuario->nombre }} {{ $cita->usuario->apellidos }}</p>

            <p class="intro">
                Tu cita ha quedado <strong>confirmada</strong>. Aquí tienes todos los detalles:
            </p>

            <div class="card">
                <p class="card-title">Detalles de tu cita</p>

                <div class="detail-item">
                    <div class="detail-label">Fecha</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Hora</div>
                    <div class="detail-value">{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Peluquero</div>
                    <div class="detail-value">{{ $cita->peluquero->nombre }} {{ $cita->peluquero->apellidos }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Servicio</div>
                    <div class="detail-value">{{ $cita->servicio->nombre }}</div>
                </div>

                <div class="detail-item">
                    <div class="detail-label">Precio</div>
                    <div class="detail-value">{{ number_format($cita->servicio->precio, 2, ',', '.') }} €</div>
                </div>
            </div>

            <p class="closing">
                Puedes cancelar o modificar tu cita desde la web.<br><br>
                ¡Hasta pronto!<br>
                <strong>ST BARBER</strong>
            </p>
        </div>

    </div>
</body>
</html>
