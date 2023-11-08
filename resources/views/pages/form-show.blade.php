@php
    $allowedVisibility = [Route::currentRouteName()];
@endphp
@extends('layouts.alter')

@section('alter-content')
    <div class="col-12">
        <div class="card mb-4">
            <x-alert :type="'a'" />
            <div class="card-header pb-0">
                <h6>{{ $title ?? '' }}</h6>
            </div>
            <form class="p-3">
                @csrf

                @isset($forms)
                    @foreach ($forms as $form)
                        @isset($form['visibility'])
                            @foreach ($form['visibility'] as $v)
                                @if (in_array($v, $allowedVisibility))
                                    <x-input-text :label="$form['name']" :name="$form['column']" :required="@$form['required']" :value="old($form['column']) ?? @$form['value']"
                                        :readonly="true" />
                                @endif
                            @endforeach
                        @endisset
                    @endforeach
                @endisset
                <div class="text-end">
                    <a type="button" href="{{ isset($resource) ? route($resource . '.edit', $id) : '#_' }}"
                        class="btn btn-info btn-sm">Edit</a>
                    <a type="button" href="{{ isset($resource) ? route($resource . '.destroy', $id) : '#' }}"
                        class="btn btn-danger btn-sm">Delete</a>
                </div>
            </form>
        </div>
    </div>
@endsection
