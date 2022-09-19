@extends('web.layout.grids.1-1')
@section('seo_title', 'Bildungsangebot')
@section('seo_description', '')
@section('section')
<section class="theme-light visual">
  <x-header title="Bildungsangebot" />
  @if ($trainings)
    <article>
      <h2>{{$category->name}}</h2>
      <div class="list">
        @foreach($trainings as $t)
          <div class="list__item">
            <a 
              href="{{ route('training_show', ['slug' => AppHelper::slug($t->title), 'training' => $t->id]) }}"
              title="{{ $t->title }}"
              class="icon-arrow"
            >
              {{ $t->title }}
            </a>
          </div>
        @endforeach
        @if ($category->id == 'f8397281-acc4-47a4-985e-b6515b433419')
          <div class="list__item">
            <a href="/bildungsangebot/modul/online-seminar-einfuehrung-in-die-psychotraumatologie-und-traumapaedagogik/ef5f55f7-23c4-4a49-9f91-e8749793707c" class="icon-arrow">
              Online-Seminar: Einführung in die Psychotraumatologie und Traumapädagogik
            </a>
          </div>
        @endif
        <br><br>
        <div class="list__item">
          <a 
            href="{{ route('search_index') }}"
            title="Bildungsangebot durchsuchen"
            class="icon-arrow"
          >
            Bildungsangebot durchsuchen
          </a>
        </div>

      </div>
    </article>
    @if ($category->id != 'f8397281-acc4-47a4-985e-b6515b433419')
      <article>
        <a href="/storage/downloads/sipt-{{AppHelper::slug($category->name)}}.pdf" target="_blank" class="btn-download" title="Download PDF">
          <strong>{{$category->name}}</strong> [PDF, 70KB]
        </a>
      </article>
    @endif
  @endif
  {{-- <div class="visual__container">
    <img src="/assets/img/visual-2.png" width="3996" height="2896" alt="">
  </div> --}}
</section>
<x-quote size="is-sm" quote="{{$quote['quote']}}" author="{{$quote['author']}}" />
@endsection