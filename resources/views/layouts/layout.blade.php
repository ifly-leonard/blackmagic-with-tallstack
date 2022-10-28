<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Black Magic with TALL Stack</title>
    <style>[x-cloak] { display: none !important; }</style>

    @livewireStyles

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />


    <script src="{{ asset('alpine.js') }}" defer></script>

</head>
<body class="antialiased">

    <div>
        @auth
        <livewire:home-screen />
        @endauth

        @guest
            <livewire:auth-screen />
        @endguest
    </div>




    @livewireScripts
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
</body>
</html>
