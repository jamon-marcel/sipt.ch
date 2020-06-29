@if ($leaders)
<article>
  <h2>Leitung</h2>
  <div class="list">
    @foreach($leaders as $l)
      <div class="list__item">
        <a 
          href="{{ route('about_tutor', ['slug' => AppHelper::slug($l->fullName), 'tutor' => $l]) }}" 
          title="{{ $l->fullName }}"
          class="{{isset($tutor) && $tutor->id == $l->id ? 'is-active' : ''}}"
        >
          {{ $l->fullName }}
        </a>
      </div>
    @endforeach
  </div>
</article>
@endif
@if ($tutors)
<article>
  <h2>Dozierende</h2>
  <div class="list">
    @foreach($tutors as $t)
      <div class="list__item">
        <a 
          href="{{ route('about_tutor', ['slug' => AppHelper::slug($t->fullName), 'tutor' => $t]) }}" 
          title="{{ $t->fullName }}"
          class="{{isset($tutor) && $tutor->id == $t->id ? 'is-active' : ''}}"
        >
          {{ $t->fullName }}
        </a>
      </div>
    @endforeach
  </div>
</article>
@endif