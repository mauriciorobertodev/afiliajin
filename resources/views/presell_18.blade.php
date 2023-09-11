<!DOCTYPE html>
@props(['page'])

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $page->name }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @viteReactRefresh
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="flex h-screen w-screen flex-col items-center justify-center gap-4 bg-gray-900 px-4 font-sans text-white antialiased">
    <svg class="h-40 w-40 fill-red-500"viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1">
        <path d="M18,5h1V6a1,1,0,0,0,2,0V5h1a1,1,0,0,0,0-2H21V2a1,1,0,0,0-2,0V3H18a1,1,0,0,0,0,2ZM7,7V17a1,1,0,0,0,2,0V7A1,1,0,0,0,7,7ZM21.6,9a1,1,0,0,0-.78,1.18,9,9,0,1,1-7-7,1,1,0,1,0,.4-2A10.8,10.8,0,0,0,12,1,11,11,0,1,0,23,12a10.8,10.8,0,0,0-.22-2.2A1,1,0,0,0,21.6,9ZM11,9v1a3,3,0,0,0,.78,2A3,3,0,0,0,11,14v1a3,3,0,0,0,3,3h1a3,3,0,0,0,3-3V14a3,3,0,0,0-.78-2A3,3,0,0,0,18,10V9a3,3,0,0,0-3-3H14A3,3,0,0,0,11,9Zm5,6a1,1,0,0,1-1,1H14a1,1,0,0,1-1-1V14a1,1,0,0,1,1-1h1a1,1,0,0,1,1,1Zm0-6v1a1,1,0,0,1-1,1H14a1,1,0,0,1-1-1V9a1,1,0,0,1,1-1h1A1,1,0,0,1,16,9Z" />
    </svg>

    <p class="text-center text-xl font-bold">
        PRODUTO +18
    </p>
    <p class="text-center text-xl">
        Entrando em ambiente seguro. Clique no botão para continuar!
    </p>
    <a href="{{ route('page.show', ['slug' => $page->slug]) }}" class="flex h-12 w-full max-w-xs items-center justify-center rounded bg-red-500 font-semibold text-white shadow-red-500 hover:bg-red-600">CONTINUAR</a>
</body>

</html>
