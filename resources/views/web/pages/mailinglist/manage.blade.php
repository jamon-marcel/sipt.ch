@extends('web.layout.grids.1-1')
@section('seo_title', 'Newsletter')
@section('seo_description', '')
@section('section')
<section class="theme-light">
  <x-header title="Newsletter verwalten" />
  <article>
    <h2>Verwalten Sie ihre Abonnements</h2>
    <div>
      @if ($errors->any())
        <x-alert type="danger" message="{{__('messages.general_error')}}" />
      @endif
      <form method="POST" class="auth auth--register" action="{{ route('mailinglist_update') }}">
        @csrf
        @honeypot
        <input type="hidden" name="email" value="{{ $subscriber }}" />
        <p class="sb-lg">Sie können Sie sich für unsere verschiedenen Newsletter-Listen anmelden oder Ihre bereits bestehenden Abonnements verwalten.</p>
        <x-mailinglists :subscriptions="$subscriptions" />
        <div class="form-buttons align-start">
          <x-button label="Angaben speichern" name="register" btnClass="btn-primary js-btn-loader" type="submit" />
        </div>
      </form>
    </div>
  </article>
</section>
@endsection
