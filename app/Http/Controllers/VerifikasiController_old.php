<?php

namespace App\Http\Controllers;

use App\Service\VerifikasiService;
use Exception;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    const RESOURCE = 'verifikasi';

    public function index(Request $request, VerifikasiService $service)
    {
        $data['title'] = 'Verifikasi Capaian Unggulan';
        $data['columns'] = [
            [
                'column' => 'nim',
                'name' => 'NIM'
            ],
            [
                'column' => 'name',
                'name' => 'Nama'
            ],
            [
                'column' => 'event',
                'name' => 'Perihal'
            ],
            [
                'column' => 'type',
                'name' => 'Tipe Pengajuan'
            ],
            [
                'column' => 'created_at',
                'name' => 'Diajukan'
            ],
        ];
        $data['resource'] = self::RESOURCE;
        $conditions = [];
        $conditionIn = [];

        if ($request->type == 'prestasi') {
            $conditionIn = ['type' => ['kompetisi', 'penghargaan']];
        }
        if ($request->type == 'portofolio') {
            $conditionIn = ['type' => ['organisasi', 'aplikom', 'artikel', 'buku', 'desain_produk', 'film']];
        }
        $data['records'] = $service->getListVerifikasiIndex(10, $request->p, [], $conditionIn);

        return view('pages.verifikasi.index-list', $data);
    }

    // Kompetisi
    public function kompetisiCreate()
    {
        return view('pages.form-list');
    }

    public function show(Request $request, $id, VerifikasiService $service)
    {
        $data['records'] = $service->showDetailPrestasi($id, $)
        return view('pages.form-list');
    }

    public function kompetisiStore()
    {
    }

    public function kompetisiEdit()
    {
    }

    public function kompetisiApprove()
    {
    }

    // __
    public function __Create()
    {
    }

    public function __Show()
    {
    }

    public function __Store()
    {
    }

    public function __Edit()
    {
    }

    public function __Approve()
    {
    }

    // +++++ Kolom ++++++ //

    private function kolomIndex()
    {
    }

    private function kolomKompetisi()
    {
    }
}
