@php
    $name = isset($name) ? $name : null;
@endphp
@props([
    'name' => $name,
    'id' => isset($id) ? $id : $name,
    'value' => isset($value) ? $value : null,
])
<div class="form-group">
    <input class="form-control" type="hidden" value="{{ $value }}" name="{{ $name }}"
        id="{{ $id }}">
</div>
