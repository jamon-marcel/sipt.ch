@extends('web.layout.grids.1-1')
@section('seo_title', 'Suche')
@section('seo_description', 'Suche in unseren Angeboten')
@section('section')
<section class="theme-light">
  <x-header title="Suche " />
  <h2>Suche</h2>
  <form method="POST" class="search" action="{{ route('search_index') }}">
    @csrf
    @honeypot
    <div>
      <input class="" type="text" name="keyword" placeholder="" value="">
      <button class="btn-primary" type="submit" name="register">Suchen</button>
    </div>
  </form>
  @if ($results)
  <div class="search-results">
    <h3>Resultate ({{$results->count()}})</h3>
    <div class="list">
      @foreach($results as $course)
        <div class="list__item">
          <a href="{{ route('course_show', ['slug' => AppHelper::slug($course->title), 'course' => $course->id]) }}" class="icon-arrow">
            <strong>{{$course->title}}</strong><br>{!! AppHelper::snippet($course->description) !!}
          </a>
        </div>
      @endforeach
    </div>
  </div>
  @endif
  
</section>
@endsection