<?php

namespace App\Http\Controllers;

use App\Http\Requests\MahasiswaRequest;
use App\Service\MahasiswaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data['resource'] = self::RESOURCE;
        $options = [];

        // buat select tahun
        $year = now()->format('Y');
        $options[$year . '1'] = $year . ' - Ganjil';
        $options[$year . '2'] = $year . ' - Genap';
        for ($i = 1; $i <= 7; $i++) {
            $options[now()->subYears($i)->format('Y') . '1'] = now()->subYears($i)->format('Y') . ' - Ganjil';
            $options[now()->subYears($i)->format('Y') . '2'] = now()->subYears($i)->format('Y') . ' - Genap';
        }

        // select pendidikan terakhir 
        $last_edu = [
            'sd' => 'SD/MI',
            'smp' => 'SMP/MTS',
            'sma' => 'SMA/SMK/MA'
        ];

        $data['forms'] = $this->table([
            'valid_date' => $options,
            'last_edu' => $last_edu
        ]);
        $data['title'] = 'Tambah Mahasiswa';
        return view('pages.form-list', $data);
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
            DB::beginTransaction();
            // simpan data user login
            $user = $service->saveUser([
                'role_id' => 2, //mahasiswa
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->nim,
                'is_active' => true
            ]);

            // jika berhasil simpan data siswa
            if ($user) {
                $records = $request->all();
                $records['user_id'] = $user->id;
                $service->saveMahasiswa($records);;
            }

            $code = self::SUCCESS;
            $msg = 'Berhasil tambah data Mahasiswa : ' . $request->name;
            $url = route(self::RESOURCE . '.index');
            DB::commit();
        } catch (Exception $e) {
            $code = self::ERROR;
            $msg = $e->getMessage();
            $url = route(self::RESOURCE . '.create');
            DB::rollBack();
        }

        return redirect($url)->withInput($request->all())->with($code, $msg);
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
    public function table($options = []): array
    {
        return [
            [
                'column' => 'nim',
                'name' => 'NIM',
                'type' => 'text',
                'required' => true,
                'visibility' => [self::RESOURCE . '.index', self::RESOURCE . '.create'],
            ],
            [
                'column' => 'name',
                'name' => 'Nama',
                'type' => 'text',
                'required' => true,
                'visibility' => [self::RESOURCE . '.index', self::RESOURCE . '.create'],
            ],
            [
                'column' => 'address',
                'name' => 'Alamat Lengkap',
                'type' => 'text',
                'visibility' => [self::RESOURCE . '.create',],
            ],
            [
                'column' => 'email',
                'name' => 'E-Mail',
                'type' => 'email',
                'required' => true,
                'visibility' => [self::RESOURCE . '.create'],
            ],
            [

                'column' => 'no_hp',
                'name' => 'Nomor HP',
                'type' => 'number',
                'visibility' => [self::RESOURCE . '.create'],
            ],
            [

                'column' => 'last_edu',
                'name' => 'Pendidikan Terakhir',
                'type' => 'select',
                'visibility' => [self::RESOURCE . '.create'],
                'required' => true,
                'options' => $options['last_edu'] ?? []
            ],
            [

                'column' => 'birth_date',
                'name' => 'Tanggal Lahir',
                'type' => 'date',
                'visibility' => [self::RESOURCE . '.create'],
            ],
            [
                'column' => 'valid_date',
                'name' => 'Angkatan',
                'type' => 'select',
                'required' => true,
                'options' => $options['valid_date'] ?? [],
                'visibility' => [self::RESOURCE . '.index', self::RESOURCE . '.create'],
            ],
        ];
    }
}
