<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0f766e">
    <link rel="manifest" href="/manifest.webmanifest">
    <title>{{ config('app.name') }}</title>
    <script>
        window.financeiroFrontend = @json([
            'stats' => $stats ?? [],
            'highlights' => $highlights ?? [],
        ]);
    </script>
    @vite(['resources/css/frontend.css', 'resources/js/frontend/app.jsx'])
</head>
<body>
    <div id="frontend-root"></div>
</body>
</html>
