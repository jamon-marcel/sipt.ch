<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@if(trim($__env->yieldContent('seo_title')))@yield('seo_title') - {{config('seo.title')}}@else{{config('seo.title')}}@endif</title>
<meta name="description" content="@if(trim($__env->yieldContent('seo_description')))@yield('seo_description')@else{{config('seo.description')}}@endif">
<meta property="og:title" content="@if(trim($__env->yieldContent('seo_title')))@yield('seo_title') - {{config('seo.title')}}@else{{config('seo.title')}}@endif">
<meta property="og:description" content="@if(trim($__env->yieldContent('seo_description')))@yield('seo_description')@else{{config('seo.description')}}@endif">
<meta property="og:url" content="{{url()->current()}}">
<meta property="og:image" content="@if(trim($__env->yieldContent('og_image')))@yield('og_image')@else{{ asset('assets/img/sipt-og.png') }}@endif">
<meta property="og:site_name" content="{{config('seo.title')}}">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#ffffff">
<meta name="msapplication-TileColor" content="#00aba9">
<meta name="theme-color" content="#ffffff">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="format-detection" content="telephone=no">
<link href="{{ asset('assets/css/app.css') }}" type="text/css" rel="stylesheet" />
<script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
</head>
<body>
<a href="javascript:;" class="btn-menu-show js-menu-btn-show"></a>
<header class="site-header">
  <div>
    <a href="/" class="logo-sm">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 226.6 74.4"><defs><style>.a{fill:none;}.b{fill:#ff7a00;}</style></defs><path class="a" d="M135,12.6H115.9V32.7H135c4.9,0,8.9-4.2,8.9-10S139.9,12.6,135,12.6Z"/><polygon class="b" points="83.4 0 69.7 0 69.7 74.4 83.4 74.4 83.4 0"/><path class="b" d="M226.6.1H163.7V12.7h24.6V74.4H202V12.7h24.6Z"/><path class="b" d="M135.9,0H102.3V74.4h13.6V45.3h20c12,0,21.3-10.6,21.3-22.6S147.9.1,135.9,0ZM135,32.7H115.9V12.6H135c4.9,0,8.9,5.2,8.9,10.1S139.9,32.7,135,32.7Z"/><path class="b" d="M21.4,43H32.9a9.4,9.4,0,0,1,0,18.8H2.8V74.4H33.6a21.7,21.7,0,0,0,21.6-22A21.4,21.4,0,0,0,33.6,30.8H22.2a9.2,9.2,0,0,1-8.9-9.2,9,9,0,0,1,8.9-9H51.3V0H21.4A21.3,21.3,0,0,0,0,21.6,21.2,21.2,0,0,0,21.4,43Z"/></svg>
    </a>
  </div>
</header>
<x-contact />
<x-loader />
@yield('content')
@include('web.layout.partials.footer')