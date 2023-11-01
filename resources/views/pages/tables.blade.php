@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Tables'])
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">International</p>
                                <h5 class="font-weight-bolder">
                                    $53,000
                                </h5>
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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Regional</p>
                                <h5 class="font-weight-bolder">
                                    2,300
                                </h5>
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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Nasional</p>
                                <h5 class="font-weight-bolder">
                                    +3,462
                                </h5>
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
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Provinsi</p>
                                <h5 class="font-weight-bolder">
                                    $103,430
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
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Prestasi Mahasiswa</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        NIM</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Jumlah Prestasi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">1</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">190631100048</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">mila</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">10</p>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">1</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">190631100048</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">mila</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">10</p>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">1</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">190631100048</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">mila</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">10</p>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">1</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">190631100048</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">mila</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">10</p>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">1</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">190631100048</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">mila</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">10</p>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection