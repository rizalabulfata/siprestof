<?php

namespace App\Http\Controllers;

use App\Models\Model;
use App\Service\PortofolioService;
use App\Service\VerifikasiService;
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

        // filter
        $filters = [];
        if ($request->search_box) {
            $filters = ['name', $request->search_box];
        }

        $conditions = ['approval_status' => Model::APPROVE];
        $data['records'] = $service->getListPortofolioView(5, $request->p, true, $conditions, $filters);

        $data['buttons'] = [
            [
                'url' => route('portofolio.create', ['type' => 'kompetisi']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Kompetisi',
                'role' => 'isMahasiswa'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'penghargaan']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Penghargaan',
                'role' => 'isMahasiswa'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'organisasi']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Organisasi',
                'role' => 'isMahasiswa'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'buku']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Buku',
                'role' => 'isMahasiswa'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'aplikom']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Aplikom',
                'role' => 'isMahasiswa'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'artikel']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Artikel',
                'role' => 'isMahasiswa'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'desain_produk']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Desain Produk',
                'role' => 'isMahasiswa'
            ],
            [
                'url' => route('portofolio.create', ['type' => 'film']),
                'class' => 'btn btn-outline-success',
                'icon' => 'fas fa-plus',
                'text' => 'Tambah Film',
                'role' => 'isMahasiswa'
            ],

        ];

        return view('pages.index-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, PortofolioService $service)
    {
        $this->authorize('isMahasiswa');
        $data['resource'] =  self::RESOURCE;
        $data['title'] =  'Tambah Data ' . ucfirst($request->type);
        $type = $request->type;
        $optionsYears = [];

        // select tahun
        $optionsYears[now()->format('Y')] = now()->format('Y');
        for ($i = 1; $i <= 8; $i++) {
            $optionsYears[now()->subYears($i)->format('Y')] = now()->subYears($i)->format('Y');
        }
        // select buku
        $bookType = ['fiksi' => 'Fiksi', 'ilmiah' => 'Ilmiah', 'sci-fi' => 'Sci-Fi', 'horror' => 'Horror', 'science' => 'Science', 'pendidikan' => 'Keilmuan/Pendidikan', 'informatika' => 'Teknologi Informatika'];

        // genre film
        $filmGenre = ['fiksi' => 'Fiksi', 'comedy' => 'Komedi/Lawak', 'sci-fi' => 'Fantasi', 'horror' => 'Horor', 'science' => 'Pengetahuan', 'biography' => 'Biografi Tokoh', 'history' => 'Sejarah'];

        $kodifikasi = $service->getKodifikasi($type);
        if ($type == 'organisasi') {
            $kodifikasi = $kodifikasi->pluck('second_name', 'bidang')->toArray();
            $forms = $this->kolomForm($request->type, [
                'year' => $optionsYears,
                'jabatan' => $kodifikasi,
                'kategori' => []
            ]);
        } else {
            $kategori = $kodifikasi->each(function ($item) {
                $item->kategori = ucfirst($item->kategori);
            })->pluck('kategori', 'id');
            $forms = $this->kolomForm($request->type, [
                'year' => $optionsYears,
                'kategori' => $kategori,
                'booktypes' => $bookType,
                'filmGenre' => $filmGenre
            ]);
        }
        $forms[] = [
            'column' => 'type',
            'type' => 'hidden',
            'value' => $request->type,
            'visibility' => [self::RESOURCE . '.create']
        ];
        $data['forms'] = $forms;

        return view('pages.form-list', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PortofolioService $service)
    {
        $this->authorize('isMahasiswa');
        try {
            $data = $request->except('type');
            $data['mahasiswa_id'] = $this->getAuthActionId();
            $service->savePortofolio($data, $request->type);

            $code = self::SUCCESS;
            $msg = 'Berhasil tambah portofolio (' . $request->type . '), Menunggu approval dari Admin';
            $url = route(self::RESOURCE . '.index');
        } catch (Exception $e) {
            $code = self::ERROR;
            $msg = 'Gagal tambah portofolio (' . $request->type . ') : ' . $e->getMessage();
            $url = route(self::RESOURCE . '.create', ['type' => $request->type]);
        }
        return redirect($url)->withInput($request->all())->with($code, $msg);
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
            $data['resource'] = self::RESOURCE;

            // select tahun
            $optionsYears[now()->format('Y')] = now()->format('Y');
            for ($i = 1; $i <= 8; $i++) {
                $optionsYears[now()->subYears($i)->format('Y')] = now()->subYears($i)->format('Y');
            }

            if (Gate::allows('isAdmin')) {
                $data['records'] = $service->showPortoflio($id);
                return view('pages.portofolio.detail-pres', $data);
            } else {
                $param = explode('__', $id);
                $verifService = new VerifikasiService();
                $data['records'] = $verifService->showDetailVerifikasi($param[0], $param[1]);
                $forms = $this->kolomForm($param[1], [
                    'year' => $optionsYears
                ]);
                $newForms = [];

                // penyesuaian form
                foreach ($forms as $key => $form) {
                    $form['value'] = $data['records']->{$form['column']};
                    $form['readonly'] = true;
                    $newForms[] = $form;
                }

                $data['forms'] = $newForms;
                $data['type'] = $param[1];
                return view('pages.form-portofolio-detail', $data);
            }
        } catch (Exception $e) {
            $data = $e->getMessage();
            return redirect(route('portofolio.index'))->with('error', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id, PortofolioService $service)
    {
        try {
            $data['resource'] = self::RESOURCE;
            $param = explode('__', $id);
            $verifController = new VerifikasiController();

            // select tahun
            $optionsYears[now()->format('Y')] = now()->format('Y');
            for ($i = 1; $i <= 8; $i++) {
                $optionsYears[now()->subYears($i)->format('Y')] = now()->subYears($i)->format('Y');
            }
            // select buku
            $bookType = ['fiksi' => 'Fiksi', 'ilmiah' => 'Ilmiah', 'sci-fi' => 'Sci-Fi', 'horror' => 'Horror', 'science' => 'Science', 'pendidikan' => 'Keilmuan/Pendidikan', 'informatika' => 'Teknologi Informatika'];

            // genre film
            $filmGenre = ['fiksi' => 'Fiksi', 'comedy' => 'Komedi/Lawak', 'sci-fi' => 'Fantasi', 'horror' => 'Horor', 'science' => 'Pengetahuan', 'biography' => 'Biografi Tokoh', 'history' => 'Sejarah'];


            // kodifikasi
            $kodifikasi = $service->getKodifikasi($param[1]);
            if ($param[1] == 'organisasi') {
                $kodifikasi = $kodifikasi->pluck('second_name', 'bidang')->toArray();
                $forms = $this->kolomForm($param[1], [
                    'year' => $optionsYears,
                    'jabatan' => $kodifikasi,
                    'kategori' => []
                ]);
            } else {
                $kategori = $kodifikasi->each(function ($item) {
                    $item->kategori = ucfirst($item->kategori);
                })->pluck('kategori', 'id');
                $forms = $this->kolomForm($param[1], [
                    'year' => $optionsYears,
                    'kategori' => $kategori,
                    'booktypes' => $bookType,
                    'filmGenre' => $filmGenre
                ]);
            }

            $verifService = new VerifikasiService();
            $data['records'] = $verifService->showDetailVerifikasi($param[0], $param[1]);
            $newForms = [];

            // penyesuaian form
            foreach ($forms as $key => $form) {
                $form['value'] = $data['records']->{$form['column']};
                $visibility = $form['visibility'];
                $url  = self::RESOURCE . '.create';
                if (in_array($url, $visibility)) {
                    $visibility[] = $verifController::RESOURCE . '.edit';
                }
                $form['visibility'] = $visibility;

                $newForms[] = $form;
            }

            $data['forms'] = $newForms;
            $data['type'] = $param[1];
            return view('pages.form-portofolio-detail', $data);
        } catch (Exception $e) {
            $data = $e->getMessage();
            return redirect(route('portofolio.index'))->with('error', $data);
        }
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
    public function destroy($id, PortofolioService $service)
    {
        try {
            $param = explode('__', $id);
            $service->deletePortofolio($param[1], $param[0]);

            $code = self::SUCCESS;
            $msg = 'Berhasil hapus portofolio ' . ucfirst($param[0]) . ' ID : ' . $param[1];
        } catch (Exception $e) {
            $code = self::ERROR;
            $msg = 'Gagal hapus portofolio : ' . $e->getMessage();
        }
        $url = route(self::RESOURCE . '.index');
        return redirect($url)->with($code, $msg);
    }

    public function getKodifikasi(Request $request, PortofolioService $service)
    {
        $data = $service->getKodifikasi($request->type)->each(function ($item) {
            $item->kategori = ucfirst($item->kategori);
        })->pluck('kategori', 'id');
        return $data;
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

    // public function buttonAction()
    // {
    //     $buttons = [
    //         'Lihat' => [
    //             'url' => route(self::RESOURCE . '.show'),
    //             'icon' => '',
    //             'text' => '',
    //             'class' => '',
    //             'type' => ''
    //         ],
    //         'Edit' => [
    //             'url' => '',
    //             'icon' => '',
    //             'text' => '',
    //             'class' => '',
    //             'type' => ''
    //         ],
    //         'Delete' => [
    //             'url' => '',
    //             'icon' => '',
    //             'text' => '',
    //             'class' => '',
    //             'type' => ''
    //         ]
    //     ];
    // }

    /**
     * Kolom untuk form create
     */
    public function kolomForm($type, $options = [])
    {
        $add = [];
        if ($type == 'aplikom') {
            $add = [
                [
                    'column' => 'bentuk_aplikom',
                    'name' => 'Bentuk Aplikom',
                    'type' => 'text',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show', self::RESOURCE . '.edit'],
                ],
                [
                    'column' => 'desc',
                    'name' => 'Deskripsi',
                    'type' => 'textarea',
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'year',
                    'name' => 'Tahun',
                    'type' => 'select',
                    'required' => true,
                    'options' => $options['year'] ?? [],
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'url',
                    'name' => 'Tautan',
                    'type' => 'text',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'kodifikasi_id',
                    'name' => 'Kategori',
                    'type' => 'select',
                    'options' => $options['kategori'] ?? [],
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        } elseif ($type == 'artikel') {
            $add = [
                [
                    'column' => 'name',
                    'name' => 'Judul',
                    'type' => 'text',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'publisher',
                    'name' => 'Penerbit',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'issue_at',
                    'name' => 'Tanggal Terbit',
                    'type' => 'date',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'url',
                    'name' => 'Link Artikel',
                    'type' => 'text',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'kodifikasi_id',
                    'name' => 'Kategori',
                    'type' => 'select',
                    'options' => $options['kategori'] ?? [],
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        } elseif ($type == 'buku') {
            $add = [
                [
                    'column' => 'name',
                    'name' => 'Judul Buku',
                    'type' => 'text',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'category',
                    'name' => 'Jenis Buku',
                    'type' => 'select',
                    'required' => true,
                    'options' => $options['booktypes'] ?? [],
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'publisher',
                    'name' => 'Penerbit',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'isbn',
                    'name' => 'Nomor ISBN',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'page_total',
                    'name' => 'Jumlah Halaman',
                    'type' => 'number',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'year',
                    'name' => 'Tahun',
                    'type' => 'select',
                    'options' => $options['year'] ?? [],
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'kodifikasi_id',
                    'name' => 'Tingkat',
                    'type' => 'select',
                    'options' => $options['kategori'] ?? [],
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'documentation',
                    'name' => 'Bukti',
                    'type' => 'file',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        } elseif ($type == 'desain_produk') {
            $add = [
                [
                    'column' => 'bentuk_desain',
                    'name' => 'Bentuk Desain',
                    'type' => 'text',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'year',
                    'name' => 'Tahun',
                    'type' => 'select',
                    'options' => $options['year'] ?? [],
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'kodifikasi_id',
                    'name' => 'Tingkat',
                    'type' => 'select',
                    'options' => $options['kategori'] ?? [],
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'mockup',
                    'name' => 'Mockup Desain',
                    'type' => 'file',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        } elseif ($type == 'film') {
            $add = [
                [
                    'column' => 'name',
                    'name' => 'Judul',
                    'type' => 'text',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'genre',
                    'name' => 'Genre',
                    'type' => 'select',
                    'options' => $options['filmGenre'] ?? [],
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'desc',
                    'name' => 'Deskripsi',
                    'type' => 'textarea',
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'date',
                    'name' => 'Tanggal',
                    'type' => 'date',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'url',
                    'name' => 'Tautan',
                    'type' => 'text',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'kodifikasi_id',
                    'name' => 'Tingkat',
                    'type' => 'select',
                    'options' => $options['kategori'] ?? [],
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        } elseif ($type == 'organisasi') {
            $add = [
                [
                    'column' => 'name',
                    'name' => 'Nama Organisasi',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'kod_second_name',
                    'name' => 'Jabatan',
                    'type' => 'select',
                    'options' => $options['jabatan'] ?? [],
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'kod_second_name',
                    'name' => 'Jabatan',
                    'type' => 'text',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'kodifikasi_id',
                    'name' => 'Kategori',
                    'type' => 'select',
                    'options' => $options['kategori'] ?? [],
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'year_start',
                    'name' => 'Masa Jabatan : Awal',
                    'type' => 'text',
                    'options' => $options['year'] ?? [],
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'year_end',
                    'name' => 'Masa Jabatan : Akhir',
                    'type' => 'text',
                    'options' => $options['year'] ?? [],
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'sk_number',
                    'name' => 'SK Jabatan',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'certificate',
                    'name' => 'Sertifikat',
                    'type' => 'file',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        } elseif ($type == 'kompetisi') {
            $add = [
                [
                    'column' => 'name',
                    'name' => 'Nama Kompetisi',
                    'type' => 'text',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'kod_kategori',
                    'name' => 'Kategori',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'desc',
                    'name' => 'Deskripsi',
                    'type' => 'textarea',
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                // [
                //     'column' => 'type',
                //     'name' => 'Tim/Individu',
                //     'type' => 'select',
                //     'options' => ['tim' => 'Tim', 'individu' => 'Individu'],
                //     'required' => true,
                //     'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                // ],
                [
                    'column' => 'organizer',
                    'name' => 'Penyelenggara',
                    'type' => 'text',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'year',
                    'name' => 'Tahun',
                    'type' => 'select',
                    'options' => $options['year'] ?? [],
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'kodifikasi_id',
                    'name' => 'Kategori',
                    'type' => 'select',
                    'options' => $options['kategori'] ?? [],
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'documentation',
                    'name' => 'Dokumentasi Kompetisi',
                    'type' => 'file',
                    'required' => false,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'certificate',
                    'name' => 'Bukti Sertifikat',
                    'type' => 'file',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        } elseif ($type == 'penghargaan') {
            $add = [
                [
                    'column' => 'name',
                    'name' => 'Penghargaan',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'desc',
                    'name' => 'Deskripsi',
                    'type' => 'textarea',
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'institution',
                    'name' => 'Institusi',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'date',
                    'name' => 'Tanggal',
                    'type' => 'date',
                    'visibility' => [self::RESOURCE . '.create', self::RESOURCE . '.show'],
                ],
                [
                    'column' => 'kodifikasi_id',
                    'name' => 'Tingkat',
                    'type' => 'select',
                    'options' => $options['kategori'] ?? [],
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'certificate',
                    'name' => 'Bukti Sertifikat',
                    'type' => 'file',
                    'required' => true,
                    'visibility' => [self::RESOURCE . '.create'],
                ],
            ];
        }

        return $add;
    }
}
