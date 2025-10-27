@extends('web.layout.grids.1-2')
@section('seo_title', 'Home')
@section('seo_description', 'Das SIPT setzt sich für Anliegen von Traumaopfern ein und bietet Fortbildungen für verschiedene Berufsgruppen an, die in ihrer Arbeit mit traumatisierten Menschen konfrontiert sind. Im Fortbildungsangebot des SIPT stehen psychodynamische Konzepte im Vordergrund.')
@section('section')
<section class="theme-light order-1">
  <x-header title="Aktuell" />

  <article>
    <h2>Veranstaltungshinweise</h2>
    <p>Das SIPT feiert nächstes Jahr sein 20-jähriges Bestehen! Aus diesem Anlass laden wir Sie herzlich zu unserer zweitägigen Fachtagung ein: «Rückblick und neue Perspektiven: Soziale Traumata und deren Auswirkungen in der Praxis». Die Tagung findet am Freitag, 21. und Samstag, 22. August 2026 in der Alten Kaserne in Winterthur statt. Gerne dürfen Sie sich diesen Termin bereits vormerken. Das detaillierte Programm lassen wir Ihnen in den kommenden Wochen zukommen.</p>
  </article>

  @foreach ($news as $category)
    @if ($category->id == config('sipt.news_courses_id'))
      <article>
        <h2>{{ $category->title }}</h2>
      </article>
      @foreach ($category->publishedArticles as $article)
        <article>
          <h2>{{ $article->title }}</h2>
          @if ($article->tutors)
          <p>
            Dozent/innen: {{ $article->tutors }}
            @if ($article->date)
              <br>
              Termin: {{ $article->date }}
            @endif
          </p>
          @elseif ($article->tutor)
            <p>
              Dozent/in: {{ $article->tutor->fullName }}
              @if ($article->date)
                <br>
                Termin: {{ $article->date }}
              @endif
            </p>
          @endif
          <div class="news-article-text">
            @if ($article->text)
              {!! $article->text !!}
            @endif
            @if ($article->link)
              <a href="{{ $article->link }}" class="icon-arrow-right">mehr erfahren</a>
            @endif
          </div>
        </article>
      @endforeach
    @else
      <article>
        <h2>{{ $category->title }}</h2>
      </article>
      <article>
        @foreach ($category->publishedArticles as $article)
        <div class="news-article-text">
          {!! $article->text !!}
          @if ($article->link)
            <a href="{{ $article->link }}" class="icon-arrow-right">mehr erfahren</a>
          @endif
        </div>
      @endforeach
      </article>
    @endif
  @endforeach

</section>
<section class="theme-medium order-2 splash visual">
  <div class="splash__title">Willkommen im Schweizer Institut für Psychotraumatologie</div>
</section>
@endsection