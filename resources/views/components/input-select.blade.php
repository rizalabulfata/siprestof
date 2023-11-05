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
    'options' => [],
])
<div class="form-group">
    <label for="{{ $id }}" class="form-control-label">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select @if ($required) required @endif class="form-control" name="{{ $name }}"
        id="{{ $id }}">
        @foreach ($options as $v => $l)
            <option @if ($v == $value) selected @endif value="{{ $v }}">{{ $l }}
            </option>
        @endforeach
    </select>
    @error($name)
        <p class="text-danger text-xs pt-1"> {{ $message }} </p>
    @enderror
</div>
