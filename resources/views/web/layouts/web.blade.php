<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('web.profile.script')
    @include('web.profile.style')
    @yield('styles')
</head>
<body id="page-top" class="index">
      
    <!-- Navigation -->
    @include('web.profile.header')
   
    <div class="wrapper container-fluid">
         @yield('content')
    </div>

     @include('web.profile.footer')

   
</body>
    @yield('scripts')
</html>
