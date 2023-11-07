<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Model;
use App\Service\PrestasiService;
use Illuminate\Http\Request;

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
            $filters = [
                (new Mahasiswa())->getTable() . '.nim' => $request->search_box,
                (new Mahasiswa())->getTable() . '.name' => $request->search_box,
                // 'valid_date' => $request->search_box,
            ];
        }

        $data['records'] = $service->getListPrestasiView(5, $request->p, true, [], $filters);

        return view('pages.index-list', $data);
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
    public function show($id, PrestasiService $service)
    {
        $data['records'] = $service->showPrestasi($id);
        $data['details_column'] = [
            ['column' => 'name', 'label' => 'Nama Prestasi'],
            ['column' => 'kategori', 'label' => 'Tingkat'],
            ['column' => 'organizer', 'label' => 'Instansi/Penyelenggara'],
            ['column' => 'year', 'label' => 'Tahun'],
            ['column' => 'desc', 'label' => 'Deskripsi'],
        ];
        $data['resource'] = self::RESOURCE;

        return view('pages.detail-pres', $data);
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
        return [
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
                'name' => 'Jumlah Prestasi',
                'visibility' => [self::RESOURCE . '.index']
            ],
        ];
    }
}
