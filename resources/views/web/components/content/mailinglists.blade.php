@if ($subscriptions)
  @foreach($mailinglists as $mailinglist)
    <div class="form-group-checkbox @if ($errors->has('mailinglists')) has-error @endif">
      <div>
      <input type="checkbox" name="mailinglists[]" value="{{ $mailinglist->id }}" id="{{ $mailinglist->id }}" @if (in_array($mailinglist->id, $subscriptions)) checked="checked" @endif>
        <div class="checkbox"><span></span></div>
      </div>
      <label for="{{ $mailinglist->id }}">{{ $mailinglist->description }}</label>
    </div>
  @endforeach
@else
  @foreach($mailinglists as $mailinglist)
    <div class="form-group-checkbox @if ($errors->has('mailinglists')) has-error @endif">
      <div>
      <input type="checkbox" name="mailinglists[]" value="{{ $mailinglist->id }}" id="{{ $mailinglist->id }}" @if ($loop->first) checked="checked" @endif>
        <div class="checkbox"><span></span></div>
      </div>
      <label for="{{ $mailinglist->id }}">{{ $mailinglist->description }}</label>
    </div>
  @endforeach
@endif
