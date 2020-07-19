<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ config('app.name') }}</title>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="user" content="{{ Auth::user() }}">

  <!-- Iconos de font-awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.css') }}">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div  id="app">
        @include('partials.nav')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
