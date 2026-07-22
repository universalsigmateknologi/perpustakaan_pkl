<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login - PerpusApp')</title>

    <link rel="stylesheet" href="{{ asset('css/output.css') }}">
    
</head>
<body class="h-full flex items-center justify-center bg-gradient-to-r from-indigo-500 to-purple-600">
    
    <div class="w-full max-w-md">
        @yield('content')
    </div>

</body>
</html>