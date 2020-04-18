<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{-- STYLES --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>Todo list</title>
</head>
<body>
    <div class="c-app-container d-flex justify-content-center align-items-center bg-dark" id="app">
            <todo></todo>
    </div>
 <!-- Scripts -->
 <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
