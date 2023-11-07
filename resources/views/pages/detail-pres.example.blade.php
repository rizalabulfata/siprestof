@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Tables'])
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card p-3 mb-4">
                <div class="card-header pb-0">
                    <h6>Detail Prestasi</h6>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Kode</th>
                            <th colspan="3">Deskripsi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="7">KOMP-001</td>
                            <td>Nama Prestasi</td>
                            <td>:</td>
                            <td>Lomba LKTI</td>
                            <td rowspan="7"><a href="#" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a></td>
                        </tr>
                        <tr>
                            <td>Juara</td>
                            <td>:</td>
                            <td>1</td>                            
                        </tr>
                        <tr>
                            <td>Tingkat</td>
                            <td>:</td>
                            <td>Nasional</td>
                        </tr>
                        <tr>
                            <td>Instansi</td>
                            <td>:</td>
                            <td>UIN Malang</td>
                        </tr>
                        <tr>
                            <td>Tahun</td>
                            <td>:</td>
                            <td>2023</td>
                        </tr>
                        <tr>
                            <td>Deskripsi</td>
                            <td>:</td>
                            <td>Merupakan Lomba Karya Tulis ilmiah yang diadakan oleh HMP MTK UIN Malang</td>
                        </tr>
                        <tr>
                            <td>Bukti</td>
                            <td>:</td>
                            <td><a href="#" class="btn btn-success btn-sm">Lihat</a></td>
                        </tr>
                        <tr>
                            <td rowspan="7">PENG-001</td>
                            <td>Nama Prestasi</td>
                            <td>:</td>
                            <td>1st Runner Up Duta Budaya Jawa Timur</td>
                            <td rowspan="7"><a href="#" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a></td>
                        </tr>
                        <tr>
                            <td>Juara</td>
                            <td>:</td>
                            <td>1</td>                            
                        </tr>
                        <tr>
                            <td>Tingkat</td>
                            <td>:</td>
                            <td>Provinsi</td>
                        </tr>
                        <tr>
                            <td>Instansi</td>
                            <td>:</td>
                            <td>DInas Kebudayaan</td>
                        </tr>
                        <tr>
                            <td>Tahun</td>
                            <td>:</td>
                            <td>2022</td>
                        </tr>
                        <tr>
                            <td>Deskripsi</td>
                            <td>:</td>
                            <td>Merupakan ajang penghargaan yang di berikan kepada putra putri 
                                <br> terbaik jawatimur sebagai duta budaya</td>
                        </tr>
                        <tr>
                            <td>Bukti</td>
                            <td>:</td>
                            <td><a href="#" class="btn btn-success btn-sm">Lihat</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>

@endsection