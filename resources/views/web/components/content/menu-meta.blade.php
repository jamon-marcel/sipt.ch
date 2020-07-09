<nav class="meta-menu">
  <ul>
    <li>
      <a href="javascript:;" class="js-btn-bookings">
        Meine Module @if ($count > 0) <em class="js-booking-counter">[{{$count}}]</em> @endif
      </a>
    </li>
    {{-- <li>
      <a href="javascript:;" class="js-btn-newsletter">
        Newsletter
      </a>
    </li>
    <li>
      <a href="javascript:;" class="js-btn-contact">
        Kontakt
      </a>
    </li> --}}
  </ul>
  <ul>
    @guest
      <li>
        <a href="{{ route('login') }}" class="icon-login">Login</a>
      </li>
    @endguest
    @auth
      <li>
        @if (auth()->user()->isStudent())
          <a href="{{ route('dashboard_student') }}">Mein Profil</a>
        @endif
        @if (auth()->user()->isTutor())
          <a href="{{ route('dashboard_tutor') }}">Mein Profil</a>
        @endif
        @if (auth()->user()->isAdmin())
          <a href="{{ route('dashboard_admin') }}">Administration</a>
        @endif
      </li>
      <li>
        <a href="{{ route('logout') }}">Logout</a>
      </li>
    @endauth
  </ul>
</nav>