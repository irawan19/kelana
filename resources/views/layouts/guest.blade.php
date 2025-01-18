<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{URL::asset('template/images/logo.png')}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">
    <meta name="msapplication-TileImage" content="{{URL::asset('template/images/logo.png')}}">
    <meta name="msapplication-TileColor" content="#3372DF">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,300,100,700,900' rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('template/css/lib/getmdl-select.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('template/css/lib/nv.d3.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('template/css/application.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('template/css/custom.css') }}">
</head>
<body>

<div class="mdl-layout mdl-js-layout color--gray is-small-screen login">
    <main class="mdl-layout__content">
        {{ $slot }}
    </main>
</div>

<script src="{{ URL::asset('template/js/d3.min.js') }}"></script>
<script src="{{ URL::asset('template/js/getmdl-select.min.js') }}"></script>
<script src="{{ URL::asset('template/js/material.min.js') }}"></script>
<script src="{{ URL::asset('template/js/nv.d3.min.js') }}"></script>
<script src="{{ URL::asset('template/js/layout/layout.min.js') }}"></script>
<script src="{{ URL::asset('template/js/scroll/scroll.min.js') }}"></script>
<script src="{{ URL::asset('template/js/widgets/charts/discreteBarChart.min.js') }}"></script>
<script src="{{ URL::asset('template/js/widgets/charts/linePlusBarChart.min.js') }}"></script>
<script src="{{ URL::asset('template/js/widgets/charts/stackedBarChart.min.js') }}"></script>
<script src="{{ URL::asset('template/js/widgets/employer-form/employer-form.min.js') }}"></script>
<script src="{{ URL::asset('template/js/widgets/line-chart/line-charts-nvd3.min.js') }}"></script>
<script src="{{ URL::asset('template/js/widgets/map/maps.min.js') }}"></script>
<script src="{{ URL::asset('template/js/widgets/pie-chart/pie-charts-nvd3.min.js') }}"></script>
<script src="{{ URL::asset('template/js/widgets/table/table.min.js') }}"></script>
<script src="{{ URL::asset('template/js/widgets/todo/todo.min.js') }}"></script>

</body>
</html>