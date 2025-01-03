<html>
    <head>
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/public/assets/css/stylesheet.css">
    </head>
    <body>
        <div class="page">
            <h1>Guess Hidden Number!</h1>
            <div class="main-section">
                @yield('content')
            </div>
        </div>
    </body>
</html>

