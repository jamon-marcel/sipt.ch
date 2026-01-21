<div class="form-group-checkbox @if ($errors->has($name)) has-error @endif">
  <div>
  <input type="checkbox" name="{{ $name }}" value="1" id="{{ $id }}" @if (old($name, $checked ?? false)) checked="checked" @endif {{ ($required ?? false) ? 'required' : '' }}>
    <div class="checkbox"><span></span></div>
  </div>
  <label class="{{ (($required ?? false) || ($showRequired ?? false)) ? 'is-required' : '' }}" for="{{ $id }}">
    {!! str_replace('%toc%', '<a href="/agb" target="_blank">AGB</a>', $label) !!}
  </label>
</div>