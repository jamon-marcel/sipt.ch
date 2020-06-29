<div class="form-group-checkbox @if ($errors->has($name)) has-error @endif">
  <div>
  <input type="checkbox" name="{{ $name }}" value="1" id="{{ $id }}" @if ($checked) checked="checked" @endif>
    <div class="checkbox"><span></span></div>
  </div>
  <label for="{{ $id }}">
    {{ $label }}
  </label>
</div>