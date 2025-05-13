@extends('web.layout.grids.1-2')
@section('seo_title', 'Home')
@section('seo_description', 'Das SIPT setzt sich für Anliegen von Traumaopfern ein und bietet Fortbildungen für verschiedene Berufsgruppen an, die in ihrer Arbeit mit traumatisierten Menschen konfrontiert sind. Im Fortbildungsangebot des SIPT stehen psychodynamische Konzepte im Vordergrund.')
@section('section')
<section class="theme-light order-1">
  <x-header title="Aktuell" />

  @foreach ($news as $category)
    @if ($category->id == config('sipt.news_courses_id'))
      <article>
        <h2>{{ $category->title }}</h2>
      </article>
      @foreach ($category->publishedArticles as $article)
        <article>
          <h2>{{ $article->title }}</h2>
          @if ($article->tutor)
            <p>
              Dozent/in: {{ $article->tutor->fullName }}
              @if ($article->date)
                <br>
                Termin: {{ $article->date }}
              @endif
            </p>
            <div class="news-article-text">
              @if ($article->text)
                {!! $article->text !!}
              @endif
              @if ($article->link)
                <a href="{{ $article->link }}" class="icon-arrow-right">mehr erfahren</a>
              @endif
            </div>
          @endif
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