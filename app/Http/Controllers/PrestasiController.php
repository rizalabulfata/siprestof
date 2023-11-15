<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Model;
use App\Service\PortofolioService;
use App\Service\PrestasiService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class PrestasiController extends Controller
{
    const RESOURCE = 'prestasi';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PrestasiService $service)
    {
        $data['title'] = 'Prestasi Mahasiswa';
        $data['tables'] = $this->table();
        $data['resource'] = self::RESOURCE;

        // filter
        $filters = [];
        if ($request->search_box) {
            $filters = ['name', $request->search_box];
        }

        $data['records'] = $service->getListPrestasiView(10, $request->p, false, [], $filters, ['*'], ['total_skor', 'desc']);
        $view = 'pages.index-list';
        if (Gate::allows('isMahasiswa')) {
            $summary = [];
            $records = $service->getListPrestasiView(0, $request->p, true, [], $filters, ['*'], ['total_skor', 'desc']);
            foreach ($records as $v) {
                if (!isset($summary[$v['type']])) {
                    $summary[ucfirst($v['type'])] = $v['skor'];
                } else {
                    $summary[ucfirst($v['type'])] += $v['skor'];
                }
            }
            $data['records'] = collect($summary);
            $view = 'pages.index-prestasi-mhs';
        }

        return view($view, $data);
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
    public function show($id, PrestasiService $service)
    {
        if (Gate::allows('isAdmin')) {
            return redirect(route('portofolio.show', $id));
        }
    }

    public function detail(Request $request, PrestasiService $service)
    {
        $data = $service->showDetailPrestasi($request->id, $request->type);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $type, PrestasiService $service)
    {
        dd($id, $type);
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
                'column' => 'total_skor',
                'name' => 'Jumlah Skor',
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
        if ($type == 'kompetisi') {
            $add = [
                [
                    'column' => 'name',
                    'name' => 'Nama Kompetisi',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create',],
                ],
                [
                    'column' => 'desc',
                    'name' => 'Deskripsi',
                    'type' => 'textarea',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'type',
                    'name' => 'Individu/Tim',
                    'type' => 'select',
                    'options' => ['tim' => 'Tim/Kelompok', 'individu' => 'Individu'],
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'organizer',
                    'name' => 'Penyelenggara',
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
                    'column' => 'kod_kategori',
                    'name' => 'Kategori',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],

            ];
        } elseif ($type == 'penghargaan') {
            $add = [
                [
                    'column' => 'name',
                    'name' => 'Penghargaan',
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
                    'column' => 'institution',
                    'name' => 'Institusi',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'date',
                    'name' => 'Tanggal',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],
                [
                    'column' => 'kod_kategori',
                    'name' => 'Tingkat',
                    'type' => 'text',
                    'visibility' => [self::RESOURCE . '.create'],
                ],

            ];
        }

        return $add;
    }
}
