@extends('web.layout.app')
@section('content')
<main role="main" class="site">
<div class="grid-2-1">
  <div>@include('web.layout.partials.menu.site')</div>
  @yield('section')
</main>
@endsection