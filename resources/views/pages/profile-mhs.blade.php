@extends('layouts.alter')

@section('alter-content')
    <div class="row">
        <div class="col-xl-4 order-xl-2">
            <div class="card card-profile">
                <img src="{{ asset('img/utmmm.jpg') }}" class="card-img-top">
                <div class="row justify-content-center pt-8" style="position: absolute">
                    <div class="col-lg-3 order-lg-2" style="width: 35%">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="{{ asset('img/profile default.png') }}" class="rounded-circle img-fluid">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-5">
                    <div class="text-center">
                        <h5 class="h3">
                            {{ ucfirst($record['name']) }}
                        </h5>
                        <div class="h5 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>
                            {{ $unit->parent_name }} - {{ $unit->child_name }}
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>Universita Trunojoyo Madura
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <x-alert :type="true" />
                        <div class="col-8">
                            <h3 class="mb-0">Profil Mahasiswa </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NIM</label>
                                        <input type="text" class="form-control" value="{{ $record['nim'] }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NAMA</label>
                                        <input type="text" class="form-control" value="{{ $record['name'] }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Pendidikan Terakhir</label>
                                        <input type="text" class="form-control" value="{{ $record['last_edu'] }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Tanggal Lahir</label>
                                        <input type="text" class="form-control" value="{{ $record['birth_date'] }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">

                        <h6 class="heading-small text-muted mb-4">Contact information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">No HP</label>
                                        <input type="text" class="form-control" value="{{ $record['no_hp'] }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">E-Mail</label>
                                        <input type="text" class="form-control" value="{{ $record['email'] }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Angkatan</label>
                                        <input type="text" class="form-control"
                                            value="{{ substr($record['valid_date'], 0, strlen($record['valid_date']) - 1) }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="text-end">
                        <a type="button" href="{{ isset($resource) ? route($resource . '.edit', $id) : '#_' }}"
                            class="btn btn-info btn-sm">Edit</a>

                        @can('isAdmin')
                            <a type="button" href="{{ isset($resource) ? route($resource . '.destroy', $id) : '#' }}"
                                class="btn btn-danger btn-sm">Delete</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
