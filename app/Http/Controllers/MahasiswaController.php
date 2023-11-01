<?php

namespace App\Http\Controllers;

use App\Http\Requests\MahasiswaRequest;
use App\Service\MahasiswaService;
use Exception;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    const RESOURCE = 'mahasiswa';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function index(Request $request, MahasiswaService $service)
    {
        $data['title'] = 'Mahasiswa';
        $columns = ['id', 'name', 'nim', 'active_kelas', 'unit_id', 'unit_name', 'valid_date'];
        $data['tables'] = $this->table();
        $data['resource'] = self::RESOURCE;

        // filter
        $filters = [];
        if ($request->search_box) {
            $filters = [
                'nim' => $request->search_box,
                'name' => $request->search_box,
                'valid_date' => $request->search_box,
            ];
        }
        $data['records'] = $service->getListMahasiswaView(3, $request->p, ['unit', 'kelas'], [], $filters, $columns);

        return view('pages.index-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.tambah', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MahasiswaRequest $request, MahasiswaService $service)
    {
        try {
            $data = $service->saveMahasiswa($request->all());
        } catch (Exception $e) {
            $data = $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, MahasiswaService $service)
    {
        try {
            $data = $service->showMahasiswa($id);
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
    public function edit($id, MahasiswaService $service)
    {
        try {
            $data = $service->showMahasiswa($id);
        } catch (Exception $e) {
            $data = $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MahasiswaRequest $request, $id, MahasiswaService $service)
    {
        try {
            $data = $service->saveMahasiswa($request->all(), $id);
        } catch (Exception $e) {
            $data = $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, MahasiswaService $service)
    {
        try {
            $data = $service->deleteMahasiswa($id);
        } catch (Exception $e) {
            $data = $e->getMessage();
        }
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
            ],
            [
                'column' => 'name',
                'name' => 'Nama',
            ],
            [
                'column' => 'valid_date',
                'name' => 'Angkatan',
            ],
        ];
    }
}
