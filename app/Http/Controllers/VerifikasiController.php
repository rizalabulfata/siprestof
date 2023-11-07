<?php

namespace App\Http\Controllers;

use App\Service\VerifikasiService;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    const RESOURCE = 'verifikasi';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, VerifikasiService $service)
    {
        $param = explode('__', $id);
        $data['title'] = 'Verifikasi CU ' . ucfirst($param[0]) . ' : Detail';
        $data['resource'] = self::RESOURCE;
        $data['records'] = $service->showDetailVerifikasi($param[1], $param[0]);
        $data['forms'] = $this->kolomShow($param[0]);
        $data['type'] = $param[0];
        return view('pages.form-verifikasi', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Render table
     * @return array
     */
    public function kolomShow($type, $options = []): array
    {
        $default = [
            [
                'column' => 'mhs_nim',
                'name' => 'NIM',
                'type' => 'text',
                'required' => true,
                'visibility' => [self::RESOURCE . '.show'],
                'readonly' => true,
            ],
            [
                'column' => 'mhs_name',
                'name' => 'Nama',
                'type' => 'text',
                'required' => true,
                'visibility' => [self::RESOURCE . '.show'],
                'readonly' => true,
            ],
            [
                'column' => 'kod_code',
                'name' => 'Kode',
                'type' => 'text',
                'visibility' => [self::RESOURCE . '.create',],
                'readonly' => true,
            ],
        ];

        $add = [];
        if ($type == 'kompetisi') {
            $add = [
                [
                    'column' => 'event',
                    'name' => 'Nama Kompetisi',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create',],
                    'readonly' => true,
                ],
                [
                    'column' => 'type',
                    'name' => 'Individu/Tim',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'organizer',
                    'name' => 'Penyelenggara',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'year',
                    'name' => 'Tahun',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'kod_kategori',
                    'name' => 'Kategori',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'desc',
                    'name' => 'Deskripsi',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
            ];
        } elseif ($type == 'penghargaan') {
            $add = [
                [
                    'column' => 'event',
                    'name' => 'Penghargaan',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'kod_kategori',
                    'name' => 'Tingkat',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'date',
                    'name' => 'Tanggal',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'institution',
                    'name' => 'Institusi',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'desc',
                    'name' => 'Deskripsi',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
            ];
        } elseif ($type == 'aplikom') {
            $add = [
                [
                    'column' => 'event',
                    'name' => 'Bentuk Aplikom',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'year',
                    'name' => 'Tahun',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'url',
                    'name' => 'Tautan',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'desc',
                    'name' => 'Deskripsi',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
            ];
        } elseif ($type == 'artikel') {
            $add = [
                [
                    'column' => 'event',
                    'name' => 'Judul',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'publisher',
                    'name' => 'Penerbit',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'issue_at',
                    'name' => 'Tanggal Terbit',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'url',
                    'name' => 'Link Artikel',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
            ];
        } elseif ($type == 'buku') {
            $add = [
                [
                    'column' => 'event',
                    'name' => 'Judul Bukut',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'type',
                    'name' => 'Jenis Buku',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'publisher',
                    'name' => 'Penerbit',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'isbn',
                    'name' => 'Nomor ISBN',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'page_total',
                    'name' => 'Jumlah Halaman',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'year',
                    'name' => 'Tahun',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
            ];
        } elseif ($type == 'desain_produk') {
            $add = [
                [
                    'column' => 'event',
                    'name' => 'Bentuk Desain',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'year',
                    'name' => 'Tahun',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
            ];
        } elseif ($type == 'film') {
            $add = [
                [
                    'column' => 'event',
                    'name' => 'Judul',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'genre',
                    'name' => 'Genre',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'desc',
                    'name' => 'Deskripsi',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'date',
                    'name' => 'Tanggal',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'url',
                    'name' => 'Tautan',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
            ];
        } elseif ($type == 'organisasi') {
            $add = [
                [
                    'column' => 'event',
                    'name' => 'Nama Organisasi',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'kod_second_name',
                    'name' => 'Jabatan',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'year_start',
                    'name' => 'Masa Jabatan',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
                [
                    'column' => 'sk_number',
                    'name' => 'SK Jabatan',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                    'readonly' => true,
                ],
            ];
        }

        return array_merge($default, $add);
    }
}
