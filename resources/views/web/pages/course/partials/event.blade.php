<div class="list list--event">
  <div class="list__item">
    Datum: {{AppHelper::datesToString($event->dates)}}
  </div>
  <div class="list__item">
    Zeiten: {{AppHelper::timesToString($event->dates, TRUE)}} Uhr
  </div>
  <div class="list__item">
    Ort: {{AppHelper::locationName($event->location_id, TRUE)}}
  </div>
  <div class="list__item">
    DozentInnen: {{AppHelper::tutorsToString($event->dates)}}
  </div>
  <div class="list__item">
    Kosten: CHF {{$course->cost}}
  </div>
</div>
<form class="booking">
  <input type="hidden" name="event_id" value="{{$event->id}}">
  <button type="button" class="btn-booking js-btn-add-booking">buchen</button>
</form>