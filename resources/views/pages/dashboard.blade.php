@extends('layouts.alter')

@php
    $maxShow = 5;
    $maxShowInformasi = 20;
@endphp

@section('alter-content')
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
    </div>
    {{-- <div class="row mt-4">
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
                                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
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
    </div> --}}
    <div class="row pt-3">
        <div class="col card">
            <x-alert :type="true" />
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
                                            <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
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
                    @php
                        function getMessage($status, $id = null, $jenis = null): string
                        {
                            $jenis = $jenis ? ucfirst($jenis) : '<jenis>';
                            $id = $id ?? '<ID>';
                            $data = [
                                \App\Models\Model::PENDING => 'Portofolio ' . $jenis . ' dengan ID : ' . $id . ' sedang diajukan dan menunggu approval admin.',
                                \App\Models\Model::REJECT => 'Mohon maaf portofolio ' . $jenis . ' dengan ID : ' . $id . ' tidak diterima, lihat detail berikut.',
                                \App\Models\Model::APPROVE => 'Selamat, portofolio ' . $jenis . ' telah diterima.',
                            ];

                            return $data[$status];
                        }
                    @endphp
                    @foreach ($porto as $p)
                        @if ($loop->index < $maxShowInformasi)
                            <div class="border-bottom">
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                            <i class="fas fa-info-circle text-white opacity-10"></i>
                                        </div>
                                        <div class="d-flex flex-column bd-highlight">
                                            <div class="bd-highlight">
                                                <h3 class="text-sm font-weight-bold mb-0">
                                                    {{ getMessage($p->approval_status, $p->id, $p->type) }}
                                                </h3>
                                            </div>
                                            <div class=" bd-highlight">
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ ucfirst($p->type) . ' : ' . $p->event }}
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="d-flex flex-column text-end">

                                    </div>
                                </li>
                            </div>
                        @endif
                    @endforeach
                @endcan
            </div>
        </div>
    </div>

@endsection
