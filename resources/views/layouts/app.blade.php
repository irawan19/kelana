<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{URL::asset('template/vendors/sweetalert2/dist/sweetalert2.min.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('template/css/lib/getmdl-select.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('template/css/lib/nv.d3.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('template/css/application.min.css') }}">
	<link type="text/css" media="screen" rel="stylesheet" href="{{{ URL::asset('template/vendors/select2/dist/css/select2.min.css')}}}" />
    <link rel="stylesheet" href="{{ URL::asset('template/css/custom.css') }}">
    <script src="{{ URL::asset('template/js/jquery-3.7.1.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            //Select2
                $('.select2').select2({
                    width: '100%',
                });
        });
    </script>
</head>
<body>

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header is-small-screen">
    
    @include('layouts.header')
    
    @include('layouts.sidebar')

    <main class="mdl-layout__content">
        @yield('content')
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
<script src="{{URL::asset('template/vendors/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script src="{{URL::asset('template/vendors/sweetalert2/sweet-alert.init.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('template/vendors/select2/dist/js/select2.full.min.js') }}"></script>
<script>
    jQuery(document).ready(function () {
        //Sweet Alert
        $('.showModalHapus').click(function () {
            var that = this;
            var myLabel = $(that).data('nama');
            var myLink = $(that).data('link');
            swal({
                title: "Anda yakin ingin mehapus " + myLabel + "?",
                text: "Data akan dihapus dan Anda tidak dapat mengembalikan",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.value) {
                    swal({
                        title: "Delete",
                        text: "Data anda berhasil di hapus",
                        type: "info"
                    }).then(function () {
                        $.ajax({
                            type: 'delete',
                            url: myLink,
                            headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()},
                            success: function (data) {
                                location.reload();
                            }
                        });
                    });
                }
                else if (result.dismiss === swal.DismissReason.cancel) {
                    swal(
                        'Batal',
                        'Tidak ada perubahan yang dilakukan.',
                        'error'
                    )
                }
            });
        });
    });
</script>
</body>
</html>
