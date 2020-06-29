@extends('web.layout.grids.1-1')
@section('seo_title', 'Passwort zurücksetzen')
@section('seo_description', '')
@section('section')
<section class="theme-light">
  <x-header title="SIPT - Passwort zurücksetzen" />
  <article>
    <h2>Passwort zurücksetzen</h2>
    <div>
      <p>{{__('messages.password_reset')}}</p>
      @if ($errors->any())
        <x-alert type="danger" message="{{__('messages.general_error')}}" />
      @endif
      @if (session('status'))
        <x-alert type="success" message="{{ session('status') }}" />
      @endif
      <form method="POST" class="auth auth--reset" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <x-text-field label="E-Mail" type="email" name="email" />
        <x-text-field label="Passwort" type="password" name="password" />
        <x-text-field label="Passwort bestätigen" type="password" name="password_confirmation" required autocomplete="new-password" />
        <x-button label="Passwort zurücksetzen" name="reset_password" class="btn-primary js-btn-loader" type="submit" />
      </form>
    </div>
  </article>
</section>
@endsection

