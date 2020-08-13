<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
           
        </style>
    </head>
    <body>
        <h1>{{ LaravelGmail::user() }}</h1>
        @if(LaravelGmail::check())
            <a href="{{ url('oauth/gmail/logout') }}">logout</a>
        @else
            <a href="{{ url('oauth/gmail') }}">login</a>
        @endif
    </body>
</html>
