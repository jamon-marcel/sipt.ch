@extends('web.layout.grids.1-1')
@section('seo_title', 'Registrieren')
@section('seo_description', '')
@section('section')
<section class="theme-light">
  <x-header title="Registration für Studenten" />
  <article>
    <h2>Registrieren</h2>
    <div>
      @if ($errors->any())
        <x-alert type="danger" message="{{__('messages.general_error')}}" />
      @endif
      <form method="POST" class="auth auth--register" action="{{ route('register_store') }}">
        @csrf
        @honeypot
        <x-text-field label="Vorname" type="text" name="firstname" />
        <x-text-field label="Name" type="text" name="name" />
        <x-text-field label="Titel" type="text" name="title" placeholder="optional" />
        <x-text-field label="Strasse" type="text" name="street" />
        <x-text-field label="Nr." type="text" name="street_no" placeholder="optional" />
        <x-text-field label="PLZ" type="text" name="zip" />
        <x-text-field label="Ort" type="text" name="city" />
        <x-text-field label="Land" type="text" name="country" />
        <x-text-field label="Telefon P" type="text" name="phone" />
        <x-text-field label="Telefon G" type="text" name="phone_business" placeholder="optional" />
        <x-text-field label="Mobile" type="text" name="mobile" placeholder="optional" />
        <x-text-field label="Berufsabschluss" type="text" name="qualifications" />
        <x-text-field label="E-Mail" type="email" name="email" autocomplete="false" />
        <div class="sb-md">
          <x-radio label="Ich bin mit den <a href='/agb'>AGBs</a> einverstanden" id="toc" name="toc" />
        </div>
        <p class="sb-lg">Ja, ich möchte den SIPT Newsletter und Aufbau-Tipps per Mail erhalten.</p>
        <x-mailinglists />
        <div class="form-buttons align-end">
          <x-button label="Registrieren" name="register" btnClass="btn-primary js-btn-loader" type="submit" />
        </div>
      </form>
    </div>
  </article>
</section>
@endsection
