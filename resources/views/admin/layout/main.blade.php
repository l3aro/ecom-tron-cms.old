<!DOCTYPE html>
<html>
<head>
    <title>STAL CMS - @yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{--  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  --}}
    <link rel="stylesheet" type="text/css" href= {{ URL::asset('admins/css/material-icons.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ URL::asset('admins/css/bootstrap.min.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ URL::asset('admins/css/lux.min.css') }}>
    <link type="text/css" rel="stylesheet" media="screen" href= {{ URL::asset('admins/css/jquery-ui.min.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ URL::asset('admins/css/admin.css') }}>
    
    <script src= {{ URL::asset('admins/js/jquery-3.2.1.min.js')}}></script>
    
    <script src= {{ URL::asset('admins/js/jquery-ui.min.js')}}></script>
    <script src= {{ URL::asset('admins/js/popper.min.js')}}></script>
    <script src= {{ URL::asset('admins/js/bootstrap.min.js')}}></script>
</head>
<body> 

<div class="wrap-admin-panel">
	@include('admin.layout.menu')
	@include('admin.layout.sidebar')
	<div class="main-content">
		<div class="container-fluid" style="height: 100%;">
			@yield('content')
		</div>
	</div>
</div>
    <script src= {{ URL::asset('admins/js/admin.js')}}></script>
</body>
</html>