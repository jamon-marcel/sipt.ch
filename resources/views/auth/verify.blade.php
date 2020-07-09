@extends('web.layout.grids.1-1')
@section('seo_title', 'E-Mail verifizieren')
@section('seo_description', '')
@section('section')
<section class="theme-light">
  <x-header title="SIPT - E-Mail verifizieren" />
  <article>
    <h2>E-Mail verifizieren</h2>
    <div>
      @if (session('resent'))
        <x-alert type="success" message="Neuer Bestätigungslink gesendet. Bitte Posteingang prüfen." />
      @endif
      <p>Bevor Sie weiterfahren können, müssen Sie ihre E-Mail-Adresse bestätigen. Bitte prüfen Sie ihren Posteingang.</p>
      <p>Falls Sie keine E-Mail erhalten haben, können Sie einen neuen Link anfordern:</p>
        <form method="POST" action="{{ route('verification.resend') }}">
          @csrf
          <div class="form-buttons align-end">
            <x-button label="Anfordern" name="request-link" wrapperClass="align-start" btnClass="btn-primary js-btn-loader" type="submit" />
          </div>
        </form>
    </div>
  </article>
</section>
@endsection