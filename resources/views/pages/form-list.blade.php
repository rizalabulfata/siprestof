@php
    $allowedVisibility = [Route::currentRouteName()];
    $urlResourceName = 'store';
    if (isset($id)) {
        $urlResourceName = 'update';
    }
@endphp
@extends('layouts.alter')

@section('alter-content')
    <div class="col-12">
        <div class="card mb-4">
            <x-alert :type="'a'" />
            <div class="card-header pb-0">
                <h6>{{ $title ?? '' }}</h6>
            </div>
            <form class="p-3" method="POST"
                action="{{ isset($resource) ? route($resource . '.' . $urlResourceName, @$id) : '#' }}">
                @csrf
                @if (isset($id))
                    @method('PUT')
                @endif

                @isset($forms)
                    @foreach ($forms as $form)
                        @isset($form['visibility'])
                            @foreach ($form['visibility'] as $v)
                                @if (in_array($v, $allowedVisibility))
                                    @if ($form['type'] == 'text')
                                        <x-input-text :label="$form['name']" :name="$form['column']" :required="@$form['required']" :value="old($form['column']) ?? @$form['value']"
                                            :readonly="@$form['readonly']" :readonly="@$form['readonly']" />
                                    @elseif($form['type'] == 'select')
                                        <x-input-select :label="$form['name']" :name="$form['column']" :required="@$form['required']" :value="old($form['column']) ?? @$form['value']"
                                            :options="@$form['options']" />
                                    @elseif($form['type'] == 'email')
                                        <x-input-email :label="$form['name']" :name="$form['column']" :required="@$form['required']"
                                            :value="old($form['column']) ?? @$form['value']" />
                                    @elseif($form['type'] == 'number')
                                        <x-input-number :label="$form['name']" :name="$form['column']"
                                            :required="@$form['required']":value="old($form['column'])" />
                                    @elseif($form['type'] == 'textarea')
                                        <x-input-textarea :label="$form['name']" :name="$form['column']" :required="@$form['required']"
                                            :value="old($form['column'])" />
                                    @elseif($form['type'] == 'date')
                                        <x-input-date :label="$form['name']" :name="$form['column']" :required="@$form['required']" :value="old($form['column']) ?? @$form['value']" />
                                    @endif
                                @endif
                            @endforeach
                        @endisset
                    @endforeach
                @endisset
                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                    <a type="button" href="{{ isset($resource) ? route($resource . '.index') : '#' }}"
                        class="btn btn-danger btn-sm">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
