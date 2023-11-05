@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => $title ?? 'Daftar'])
    <div class="row mt-4 mx-4">
        @yield('alter-content')
    </div>
    {{-- @include('layouts.footers.auth.footer') --}}
@endsection
