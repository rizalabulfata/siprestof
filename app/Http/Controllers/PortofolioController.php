<?php

namespace App\Http\Controllers;

use App\Models\Model;
use App\Service\PortofolioService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PortofolioController extends Controller
{
    const RESOURCE = 'portofolio';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PortofolioService $service)
    {
        $data['title'] = 'Portofolio';
        $data['tables'] = $this->table();
        $data['resource'] = self::RESOURCE;

        $conditions = ['approval_status' => Model::APPROVE];
        $data['records'] = $service->getListPortofolioView(5, $request->p, true, [], $conditions);

        $data['buttons'] = [
            [
                'url' => route('prestasi.create', ['type' => 'kompetisi']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Kompetisi'
            ],
            [
                'url' => route('prestasi.create', ['type' => 'penghargaan']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Penghargaan'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'organisasi']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Organisasi'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'buku']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Buku'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'aplikom']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Aplikom'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'artikel']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Artikel'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'buku']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Buku'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'desain']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Desain Produk'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'film']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Film'
            ],
            
        ];

        return view('pages.index-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['resource'] =  self::RESOURCE;
        $data['title'] =  'Tambah Data ' . ucfirst($request->type);
        $optionsYears = [];

        // select tahun
        $optionsYears[now()->format('Y')] = now()->format('Y');
        for ($i = 1; $i <= 8; $i++) {
            $optionsYears[now()->subYears($i)->format('Y')] = now()->subYears($i)->format('Y');
        }

        $data['forms'] = $this->kolomCreate($request->type, [
            'year' => $optionsYears
        ]);
        return view('pages.form-list', $data);
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
    public function show($id, PortofolioService $service)
    {
        try {
            $data['records'] = $service->showPortoflio($id);
            $data['resource'] = self::RESOURCE;
            return view('pages.portofolio.detail-pres', $data);
        } catch (Exception $e) {
            $data = $e->getMessage();
        }
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
    public function table(): array
    {
        $table = [
            [
                'column' => 'nim',
                'name' => 'NIM',
                'visibility' => [self::RESOURCE . '.index']
            ],
            [
                'column' => 'name',
                'name' => 'Nama',
                'visibility' => [self::RESOURCE . '.index']
            ],
            [
                'column' => 'total',
                'name' => 'Jumlah Portofolio',
                'visibility' => [self::RESOURCE . '.index']
            ],
        ];

        if (Gate::allows('isMahasiswa')) {
            $table = [
                [
                    'column' => 'event_name',
                    'name' => 'Nama Prestasi',
                    'visibility' => [self::RESOURCE . '.index']
                ],
                [
                    'column' => 'type',
                    'name' => 'Jenis',
                    'visibility' => [self::RESOURCE . '.index']
                ],
            ];
        }

        return $table;
    }

    /**
     * Kolom untuk form create
     */
    public function kolomCreate($type, $options = [])
    {
        $add = [];
        if ($type == 'aplikom') {
            $add = [
                [
                    'column' => 'bentuk_aplikom',
                    'name' => 'Bentuk Aplikom',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'year',
                    'name' => 'Tahun',
                    'type' => 'select',
                    'options' => $options['year'] ?? [],
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'url',
                    'name' => 'Tautan',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'desc',
                    'name' => 'Deskripsi',
                    'type' => 'textarea',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        } elseif ($type == 'artikel') {
            $add = [
                [
                    'column' => 'name',
                    'name' => 'Judul',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'publisher',
                    'name' => 'Penerbit',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'issue_at',
                    'name' => 'Tanggal Terbit',
                    'type' => 'date',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'url',
                    'name' => 'Link Artikel',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        } elseif ($type == 'buku') {
            $add = [
                [
                    'column' => 'name',
                    'name' => 'Judul Bukut',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'type',
                    'name' => 'Jenis Buku',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'publisher',
                    'name' => 'Penerbit',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'isbn',
                    'name' => 'Nomor ISBN',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'page_total',
                    'name' => 'Jumlah Halaman',
                    'type' => 'number',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'year',
                    'name' => 'Tahun',
                    'type' => 'select',
                    'options' => $options['year'] ?? [],
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        } elseif ($type == 'desain') {
            $add = [
                [
                    'column' => 'bentuk_desain',
                    'name' => 'Bentuk Desain',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'year',
                    'name' => 'Tahun',
                    'type' => 'select',
                    'options' => $options['year'] ?? [],
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        } elseif ($type == 'film') {
            $add = [
                [
                    'column' => 'name',
                    'name' => 'Judul',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'genre',
                    'name' => 'Genre',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'desc',
                    'name' => 'Deskripsi',
                    'type' => 'textarea',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'date',
                    'name' => 'Tanggal',
                    'type' => 'date',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'url',
                    'name' => 'Tautan',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        } elseif ($type == 'organisasi') {
            $add = [
                [
                    'column' => 'name',
                    'name' => 'Nama Organisasi',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'kod_second_name',
                    'name' => 'Jabatan',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'year_start',
                    'name' => 'Masa Jabatan',
                    'type' => 'text',
                    'options' => $options['year'] ?? [],
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'sk_number',
                    'name' => 'SK Jabatan',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        }

        return $add;
    }
}
