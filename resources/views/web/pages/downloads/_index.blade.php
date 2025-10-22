@extends('web.layout.grids.1-1')
@section('seo_title', 'Downloads')
@section('seo_description', 'Nützliche Dokumente und Unterlagen zum Download')
@section('section')
<section class="theme-light">
  <x-header title="Downloads" />

  @if($downloads->count() > 0)
    @foreach($downloads as $download)
      <article>
        <a href="/storage/{{ $download->file_path }}" target="_blank" class="btn-download" title="{{ $download->title }}">
          <strong>{{ $download->title }}</strong>
          @if($download->file_type || $download->formatted_file_size)
            [{{ strtoupper($download->file_type) }}{{ $download->file_type && $download->formatted_file_size ? ', ' : '' }}{{ $download->formatted_file_size }}]
          @endif
        </a>
        @if($download->description)
          <p style="margin-top: 8px; color: #666;">{{ $download->description }}</p>
        @endif
      </article>
    @endforeach
  @else
    <p class="no-records">Keine Downloads verfügbar.</p>
  @endif
</section>
@endsection