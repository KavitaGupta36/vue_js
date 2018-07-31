<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>  Laravel with Vue </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{asset('/css/app.css')}}" rel="stylesheet" type="text/css" />    
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>

    <body>
        <div id="app">
            <example-component></example-component>
        </div>
        <script src="{{asset('/js/app.js')}}" type="text/javascript"></script>
    </body>
</html>
