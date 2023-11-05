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

        $data['records'] = $service->getListPrestasiView(3, $request->p, [], $filters);

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
    public function show($id)
    {
        //
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
