@extends('web.layout.grids.2-1')
@section('seo_title', 'Newsletter & Aktuelles')
@section('seo_description', 'Das SIPT wünscht Ihnen in Ihrer Tätigkeit viele kleine positive Momente – Momente, die wir alle brauchen, um die Belastungen unserer Tätigkeit, aber auch das aktuelle Zeitgeschehen zu verarbeiten. Mit kurzen „Aufbau-Tipps” will das SIPT in unregelmässigen Abständen zu solchen Momenten beitragen.')
@section('section')
<section class="theme-dark">
  <x-header title="Newsletter & Aktuelles" />

  <article>
    <h2>Aufbau-Tipp</h2>
    <p>Das SIPT wünscht Ihnen in Ihrer Tätigkeit viele kleine positive Momente – Momente, die wir alle brauchen, um die Belastungen unserer Tätigkeit, aber auch das aktuelle Zeitgeschehen zu verarbeiten. Mit kurzen „Aufbau-Tipps” will das SIPT in unregelmässigen Abständen zu solchen Momenten beitragen.</p>
  </article>

  @foreach($resilienceTips as $tip)
    <article>
      @if($tip->file)
        <a href="/storage/{{ $tip->file_path }}" target="_blank" class="btn-download" title="Download {{ $tip->file_type }}">
          <strong>{{ $tip->title }}</strong>
        </a>
      @else
        <div class="btn-download-disabled">
          <strong>{{ $tip->title }}</strong>
        </div>
      @endif
      <div class="list">
        @if($tip->subtitle)
          <div class="list__item">{{ $tip->subtitle }}</div>
        @endif
        @if($tip->description)
          <div class="list__item">{{ $tip->description }}</div>
        @endif
      </div>
    </article>
  @endforeach
</section>
<section class="theme">
  @if (isset($message))
    @if ($message == 'pending_confirmation')
      <article>
        <h2>Anmeldung Newsletter</h2>
        <p>Vielen Dank für Ihre Anmeldung. Sie erhalten in den nächsten Minuten eine E-Mail mit einem Link zur Bestätigung Ihrer E-Mail-Adresse.</p>
      </article>
    @endif
    @if ($message == 'lists_updated')
      <article>
        <h2>Abonnements aktualisiert</h2>
        <p>Vielen Dank. Wir haben ihre Newsletter-Abonnements aktualisiert.</p>
      </article>
    @endif
    @if ($message == 'confirmed')
      <article>
        <h2>Anmeldung Newsletter</h2>
        <p>Vielen Dank – Ihre Adresse ist hiermit bestätigt.</p>
      </article>
    @endif
  @else
    <article>
      <h2>Anmeldung Newsletter</h2>
      <p>Ja, ich möchte den SIPT Newsletter und Aufbau-Tipps per Mail erhalten. Zusätzlich können fachbezogene Newsletter abonniert werden:</p>
    </article>
    @if ($errors->any())
      <x-alert type="danger" message="{{__('messages.general_error')}}" />
    @endif
    <form method="POST" class="registration" action="{{ route('mailinglist_register') }}">
      @csrf
      @honeypot
      <x-mailinglists />
      <div class="sb-lg">
        <x-text-field label="E-Mail" type="email" name="email" />
      </div>
      <div class="form-buttons align-end">
        <x-button label="Anmelden" name="register" btnClass="btn-primary js-btn-loader" type="submit" />
      </div>
    </form>
  @endif
</section>
@endsection