@php
    $name = isset($name) ? $name : null;
@endphp
@props([
    'name' => $name,
    'id' => isset($id) ? $id : $name,
    'label' => isset($text) ? $text : 'input text',
    'value' => isset($value) ? $value : null,
    'required' => false,
    'placeholders' => null,
])
<div class="form-group">
    <label for="{{ $id }}" class="form-control-label">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input placeholder="{{ $placeholders }}" @if ($required) required @endif class="form-control"
        type="email" value="{{ $value }}" name="{{ $name }}" id="{{ $id }}">
    @error($name)
        <p class="text-danger text-xs pt-1"> {{ $message }} </p>
    @enderror
</div>