<!DOCTYPE html>
<html lang="es">
    <head>
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/public/assets/css/stylesheet.css">
        <link rel="shortcut icon" href="https://www.sedecatastro.gob.es/favicon.ico" type="image/x-icon">
    </head>
    <body>

        <header>
            @yield('header')
        </header>
        <div class="main-section">
            @yield('content')
        </div>

    </body>
</html>
