@php
    $name = isset($name) ? $name : null;
@endphp
@props([
    'name' => $name,
    'id' => isset($id) ? $id : $name,
    'label' => isset($text) ? $text : 'input text',
    'value' => isset($value) ? $value : null,
    'required' => false,
    'readonly' => false,
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
        id="{{ $id }}" @if ($readonly) readonly @endif>
        @if (!$readonly)
            <option value="">-- Pilih {{ $label }} --</option>
        @endif
        @foreach ($options as $v => $l)
            @if (!$readonly)
                <option @if ($v == $value) selected @endif value="{{ $v }}">{{ $l }}
                </option>
            @elseif($readonly && $v == $value)
                <option @if ($v == $value) selected @endif value="{{ $v }}">{{ $l }}
                </option>
            @endif
        @endforeach
    </select>
    @error($name)
        <p class="text-danger text-xs pt-1"> {{ $message }} </p>
    @enderror
</div>
