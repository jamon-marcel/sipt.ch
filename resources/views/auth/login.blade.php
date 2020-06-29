@extends('web.layout.grids.1-1')
@section('seo_title', 'Login')
@section('seo_description', '')
@section('section')
<section class="theme-light">
  <x-header title="SIPT - Login" />
  <article>
    <h2>Login</h2>
    <div>
      <p>Lorem ipsum dolor samet es ind nano.</p>
      @if ($errors->any())
        <x-alert type="danger" message="{{__('messages.general_error')}}" />
      @endif
      <form method="POST" class="auth" action="{{ route('login') }}">
        @csrf
        <x-text-field label="E-Mail" type="email" name="email" />
        <x-text-field label="Passwort" type="password" name="password" />
        <x-button label="Anmelden" name="register" class="btn-primary js-btn-loader" type="submit" />
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="form-helper">Passwort vergessen?</a>
        @endif
      </form>
    </div>
  </article>
</section>
@endsection
