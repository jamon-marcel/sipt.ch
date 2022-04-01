@extends('web.layout.grids.1-1')
@section('seo_title', 'Bildungsangebot')
@section('seo_description', '')
@section('section')
<section class="theme-light">
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
          @if ($category->id == 'f8397281-acc4-47a4-985e-b6515b433419')

          @endif
        @endforeach
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
</section>
<x-quote size="is-sm" quote="{{$quote['quote']}}" author="{{$quote['author']}}" />
@endsection