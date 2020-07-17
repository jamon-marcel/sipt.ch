<section class="theme">
  <article>
    <h2>Anmeldung</h2>
    <p>Ja, ich nehme an der Fachtagung teil</p>
  </article>
  @if ($errors->any())
    <x-alert type="danger" message="{{__('messages.general_error')}}" />
  @endif
  <form method="POST" class="registration" action="{{ route('symposium_register') }}" class="sb-lg">
    @csrf
    <input type="hidden" name="symposium_id" value="644b0723-5c3a-45d3-800a-592876d90257">
    <x-text-field label="Vorname" name="firstname" />
    <x-text-field label="Name" name="name" />
    <x-text-field label="Titel" name="title" placeholder="optional" />
    <x-text-field label="Strasse" name="street" />
    <x-text-field label="Nr." name="street_no" />
    <x-text-field label="PLZ" name="zip" />
    <x-text-field label="Ort" name="city" />
    <x-text-field label="Land" name="country" />
    <x-text-field label="Telefon P" name="phone" />
    <x-text-field label="Telefon G" name="phone_business" placeholder="optional" />
    <x-text-field label="Mobile" name="mobile" placeholder="optional" />
    <x-text-field label="E-Mail" type="email" name="email" />
    <x-text-field label="Berufsabschluss" name="qualifications" />
    <div class="sb-md">
      <x-radio label="Ich bin mit den %toc% einverstanden" id="toc" name="toc" />
    </div>
    <div class="form-buttons align-end">
      <x-button label="Anmelden" name="register" btnClass="btn-primary js-btn-loader" type="submit" />
    </div>
  </form>
</section>