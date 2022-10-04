@props(['title'])
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{csrf_token() }}">

    <title>{{$title}}</title>

    <!-- Fontawesome -->
    <link rel="stylesheet" href="{{asset('/fontawesome/css/all.css')}}">
    <!-- Bootstrap Core Css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Dtatatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    <!-- Daterange Picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <!-- Bootstrap Pin Code Css -->
    <link rel="stylesheet" href="{{asset('/css/bootstrap-pincode-input.css')}}">
    <!-- Ckeditor -->
    <link rel="stylesheet" href="{{asset('/ckeditor/style.css')}}">
    <!-- Viewer Css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.5/viewer.min.css">
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
</head>

<body>