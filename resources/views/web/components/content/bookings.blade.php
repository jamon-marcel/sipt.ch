<aside class="booking js-booking-wrapper" data-simplebar>
  <a href="javascript:;" class="icon-cross js-btn-bookings" title="Buchungen schliessen"></a>
  <section class="booking__courses">
    <div class="js-bookings">
      @if (!empty($bookings))
        @foreach($bookings as $booking)
          <div class="list list--booking">
            <div class="list__item">{{$booking['title']}}</div>
            <div class="list__item">Datum: {{$booking['date']}}</div>
            <div class="list__item">Kosten: CHF {{$booking['cost']}}.–</div>
            <div class="list__item list__item--button">
              <a href="javascript:;" class="js-btn-delete-booking" data-id="{{$booking['id']}}">löschen</a>
            </div>
          </div>
        @endforeach
      @endif
    </div>
    <div class="js-no-bookings" style="display: {{ count($bookings) == 0 ? 'block' : 'none' }}">
      <p class="highlight">Es sind keine Module vorhanden...</p>
    </div>
    <div class="booking__forms js-booking-form" style="display: {{ count($bookings) == 0 ? 'none' : 'block' }}">
      @guest
        <form method="POST" class="form-sidebar js-register-form">
          <div class="sa-md">
            <a href="javascript:;" class="anchor js-btn-show-auth sa-md">Schon einmal ausgefüllt?</a>
          </div>
          @csrf
          <x-text-field label="Vorname" name="firstname" />
          <x-text-field label="Name" name="name" />
          <x-text-field label="Titel" name="title" placeholder="optional" />
          <x-text-field label="Strasse" name="street" />
          <x-text-field label="Nr." name="street_no" placeholder="optional" />
          <x-text-field label="PLZ" name="zip" />
          <x-text-field label="Ort" name="city" />
          <x-text-field label="Land" name="country" />
          <x-text-field label="Telefon P" name="phone" />
          <x-text-field label="Telefon G" name="phone_business" placeholder="optional" />
          <x-text-field label="Mobile" name="mobile" placeholder="optional" />
          <x-text-field label="E-Mail" type="email" name="email" />
          <x-text-field label="Berufsabschluss" name="qualifications" />
          <div class="sb-md">
            <x-radio label="Ich bin mit den AGBs einverstanden" id="toc" name="toc" />
          </div>
          <div class="form-buttons align-end">
            <x-button label="anmelden" name="register" btnClass="btn-primary" type="submit" />
          </div>
        </form>

        <form method="POST" class="form-sidebar js-auth-form" action="{{ route('student_login') }}" style="display:none">
          <div class="sa-md">
            <a href="javascript:;" class="anchor js-btn-show-register" style="display:none">Noch nicht registriert?</a>
          </div>
          @csrf
          <x-text-field label="E-Mail" type="email" name="email" />
          <x-text-field label="Passwort" type="password" name="password" />
          <div class="form-buttons align-justify">
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="form-helper">Passwort vergessen?</a>
            @endif
            <x-button label="login" name="register" btnClass="btn-primary" type="submit" />
          </div>
        </form>    
      @endguest

      @auth
        @if ($student)
          <p>
            {{$student->fullName}}<br>
            @if ($student->title) {{$student->title}}<br> @endif
            {{$student->street}} {{$student->street_no}}<br>
            {{$student->zip}} {{$student->city}}<br><br>
            @if ($student->phone) Telefon P {{$student->phone}}<br> @endif
            @if ($student->phone_business) Telefon G {{$student->phone_business}}<br> @endif
            @if ($student->mobile) Mobile {{$student->mobile}}<br> @endif
            @if ($student->user->email) E-Mail {{$student->user->email}} @endif
          </p>
          <p class="small sb-md">Sind Ihre Daten nicht mehr aktuell? <a href="{{ route('dashboard_student' )}}" class="anchor">Hier</a> können Sie ihre persönlichen Daten bearbeiten.</p>
          <div class="form-buttons align-end">
            <button type="button" class="btn-booking js-btn-store-bookings">anmelden</button>
          </div>
        @endif
      @endauth

    </div>
  </section>
</aside>

