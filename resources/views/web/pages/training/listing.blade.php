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
            >
              {{ $t->title }}
            </a>
          </div>
        @endforeach
      </div>
    </article>
  @endif
</section>
<x-quote size="is-sm" quote="Die Weiterbildung zur Fachberaterin und Fachpädagogin Psychotraumatologie am SIPT war für mich zentral. Die Theorien der Übertragungsphänomene, das Wissen um die Bedeutung der frühkindlichen Bindung, das Verstehen von hirnorganischer Abläufe gerade auch unter Stress sind wichtige Inhalte in meinen Weiterbildungen." author="Marianne Herzog, Fachberaterin / Fachpädagogin Psychotraumatologie" />
@endsection