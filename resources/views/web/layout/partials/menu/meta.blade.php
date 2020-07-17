<nav class="meta-menu">
  <ul>
    <li><a href="javascript:;" class="js-btn-calendar">Kalender</a></li>
    <li><a href="javascript:;" class="js-btn-newsletter">Newsletter</a></li>
    <li><a href="javascript:;" class="js-btn-contact">Kontakt</a></li>
  </ul>
  <ul>
    <li>
      @guest
        <a href="{{ route('login') }}" class="icon-login">Login</a>
      @endguest
      @auth
        @if (auth()->user()->isStudent())
          <a href="{{ route('dashboard_student') }}" target="_blank">Mein Profil</a>
        @endif
        @if (auth()->user()->isTutor())
          <a href="{{ route('dashboard_tutor') }}" target="_blank">Mein Profil</a>
        @endif
        @if (auth()->user()->isAdmin())
          <a href="{{ route('dashboard_admin') }}" target="_blank">Administration</a>
        @endif
      @endauth
    </li>
  </ul>
</nav>