@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Tables'])
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Tambah Mahasiswa</h6>
                </div>
                <form class="p-3">               
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">NIM</label>
                        <input class="form-control" type="text" value="Masukkan NIM" id="example-text-input">
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Nama</label>
                        <input class="form-control" type="text" value="Masukkan Nama" id="example-text-input">
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Angkatan</label>
                        <input class="form-control" type="text" value="Masukkan Angkatan" id="example-text-input">
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-success btn-sm">Simpan</button>
                        <button type="button" class="btn btn-danger btn-sm">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>

@endsection