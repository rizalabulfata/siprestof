@extends('layouts.alter')

@php
    $maxShow = 5;
@endphp

@section('alter-content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    @can('isAdmin')
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Mahasiswa</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $summary['mhs'] }}
                                        </h5>
                                    @else
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Prestasi</p>
                                        <h5 class="font-weight-bolder">
                                            {{ (int) $summary['pendingCount'] + (int) $summary['approveCount'] }}
                                        </h5>
                                    @endcan
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="fas fa-user text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    @can('isAdmin')
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Users</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $summary['user'] }}
                                        </h5>
                                    @else
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Daftar Pengajuan</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $summary['pendingCount'] }}
                                        </h5>
                                    @endcan
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="fas fa-list text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    @can('isAdmin')
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Prestasi</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $summary['prestasi'] }}
                                        </h5>
                                    @else
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Tervalidasi</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $summary['approveCount'] }}
                                        </h5>
                                    @endcan
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="fas fa-trophy text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @can('isAdmin')
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Portofolio</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $summary['portofolio'] }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                        <i class="fas fa-check opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
        <div class="row mt-4">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-1 bg-transparent">
                        <h6 class="text-capitalize">Permohonan Verifikasi Capaian Unggulan</h6>
                    </div>
                </div>
            </div>
            <!-- <div class="col-lg-5">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="card card-carousel overflow-hidden h-100 p-0">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="carousel-inner border-radius-lg h-100">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="carousel-item h-100 active" style="background-image: url('./img/carousel-1.jpg'); background-size: cover;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="ni ni-camera-compact text-dark opacity-10"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <h5 class="text-white mb-1">Get started with Argon</h5>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <p>There’s nothing I really wanted to do in life that I wasn’t able to get good at.</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="carousel-item h-100" style="background-image: url('./img/carousel-2.jpg'); background-size: cover;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="ni ni-bulb-61 text-dark opacity-10"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <h5 class="text-white mb-1">Faster way to create web pages</h5>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <p>That’s my skill. I’m not really specifically talented at anything except for the
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ability to learn.</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="carousel-item h-100" style="background-image: url('./img/carousel-3.jpg'); background-size: cover;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="ni ni-trophy text-dark opacity-10"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <h5 class="text-white mb-1">Share with us your design tips!</h5>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <p>Don’t be afraid to be wrong because you can’t learn anything from a compliment.</p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button class="carousel-control-prev w-5 me-3" type="button"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="visually-hidden">Previous</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button class="carousel-control-next w-5 me-3" type="button"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="visually-hidden">Next</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->
        </div>
        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Prestasi</h6>
                    </div>
                    <div class="card-body p-3">
                        @can('isAdmin')
                            <ul class="list-group">
                                @foreach ($prestasi as $record)
                                    @if ($loop->index < $maxShow)
                                        <div class="border-bottom">
                                            <li
                                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                        <i class="ni ni-mobile-button text-white opacity-10"></i>
                                                    </div>
                                                    <div class="d-flex flex-column bd-highlight">
                                                        <div class="bd-highlight">
                                                            <h3 class="text-sm font-weight-bold mb-0">{{ $record->event }}</h3>
                                                        </div>
                                                        <div class=" bd-highlight">
                                                            <p class="text-xs font-weight-bold mb-0">{{ $record->name }}</p>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="d-flex flex-column text-end">
                                                    {{-- @php
                                                    if ($record->type == 'kompetisi') {
                                                        $url = route('verifikasi.kompetisi.show', $record->event_id);
                                                    } else {
                                                        $url = route('verifikasi.index');
                                                    }
                                                @endphp --}}
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        <a href="{{ route('verifikasi.show', $record->type . '__' . $record->event_id) }}"
                                                            class="btn btn-primary btn-xs">Lihat</a>
                                                    </p>
                                                    <p class="text-xs font-weight-bold mb-0 fst-italic">
                                                        {{ $record->created_at }}
                                                    </p>
                                                </div>
                                            </li>
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                            <div class="text-end fst-italic">
                                <a href="{{ route('verifikasi.index', ['type' => 'prestasi']) }}" class="text-xs">Tampilkan
                                    sisa
                                    {{ $prestasi_total - $maxShow }}</a>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        @can('isAdmin')
                            <h6 class="mb-0">Portofolio</h6>
                        @else
                            <h6 class="mb-0">Pengumuman</h6>
                        @endcan
                    </div>
                    <div class="card-body p-3">
                        @can('isAdmin')
                            <ul class="list-group">
                                @foreach ($porto as $record)
                                    @if ($loop->index < $maxShow)
                                        <div class="border-bottom">
                                            <li
                                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                        <i class="ni ni-mobile-button text-white opacity-10"></i>
                                                    </div>
                                                    <div class="d-flex flex-column bd-highlight">
                                                        <div class="bd-highlight">
                                                            <h3 class="text-sm font-weight-bold mb-0">{{ $record->event }}
                                                            </h3>
                                                        </div>
                                                        <div class=" bd-highlight">
                                                            <p class="text-xs font-weight-bold mb-0">{{ $record->mhs_name }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="d-flex flex-column text-end">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        <a href="{{ route('verifikasi.show', $record->type . '__' . $record->event_id) }}"
                                                            class="btn btn-primary btn-xs">Lihat</a>
                                                    </p>
                                                    <p class="text-xs font-weight-bold mb-0 fst-italic">
                                                        {{ $record->created_at }}
                                                    </p>
                                                </div>
                                            </li>
                                        </div>
                                    @endif
                                @endforeach
                            </ul>
                            <div class="text-end fst-italic">
                                <a href="{{ route('verifikasi.index', ['type' => 'portofolio']) }}" class="text-xs">Tampilkan
                                    sisa {{ $porto_total - $maxShow }}</a>
                            </div>
                        @else
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
