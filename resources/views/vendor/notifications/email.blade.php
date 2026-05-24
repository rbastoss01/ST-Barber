<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? config('app.name') }}</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; color: #111111; }
        .wrapper { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background-color: #111111; padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 28px; letter-spacing: 4px; text-transform: uppercase; text-align: center; }
        .header p { color: #aaaaaa; margin: 6px 0 0; font-size: 13px; letter-spacing: 2px; text-transform: uppercase; text-align: center; }
        .body { padding: 40px 60px; }
        .greeting { font-size: 18px; font-weight: bold; margin-bottom: 20px; }
        .line { color: #555555; line-height: 1.6; margin-bottom: 16px; font-size: 15px; }
        .btn-wrap { text-align: center; margin: 32px 0; }
        .btn { display: inline-block; background-color: #111111; color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 4px; font-size: 14px; letter-spacing: 2px; text-transform: uppercase; font-weight: bold; }
        .outro { color: #555555; line-height: 1.6; font-size: 14px; margin-top: 8px; }
        .salutation { margin-top: 32px; font-size: 14px; color: #555555; }
        .footer { background-color: #f9f9f9; border-top: 1px solid #eeeeee; padding: 20px 40px; text-align: center; }
        .footer p { font-size: 12px; color: #aaaaaa; margin: 0; line-height: 1.6; }
        .subcopy { font-size: 12px; color: #aaaaaa; word-break: break-all; margin-top: 4px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>ST BARBER</h1>
            <p>Peluquería</p>
        </div>
        <div class="body">
            @foreach ($introLines as $line)
                <p class="line">{{ $line }}</p>
            @endforeach

            @isset($actionText)
                <div class="btn-wrap">
                    <a href="{{ $actionUrl }}" class="btn">{{ $actionText }}</a>
                </div>
            @endisset

            @foreach ($outroLines as $line)
                <p class="outro">{{ $line }}</p>
            @endforeach

            <p class="salutation">
                @if (! empty($salutation))
                    {{ $salutation }}
                @else
                    Un saludo, <strong>{{ config('app.name') }}</strong>
                @endif
            </p>
        </div>
    </div>
</body>
</html>
