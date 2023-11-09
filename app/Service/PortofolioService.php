<?php

namespace App\Service;

use App\Models\Kompetisi;
use App\Models\Mahasiswa;
use App\Models\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PortofolioService extends Service
{
    /**
     * ambil seluruh data kompetisi mahasiswa
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListKompetisi($n = 10, $relations = [], $conditions = [], $columns = ['*'], $order = ['updated_at', 'asc'])
    {
        return Kompetisi::with($relations)->where($conditions)->orderBy($order[0], $order[1])->paginate($n, $columns);
    }

    /**
     * ambil seluruh data portofolio mahasiswa
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListPortofolioView($n = 10, $p = null, $checkAuth = false, $relations = [], $conditions = [], $columns = ['*'], $order = ['updated_at', 'asc'])
    {
        $p = $p ?: (Paginator::resolveCurrentPage() ?: 1);
        $n = $n <= 0 ? -1 : $n;

        $tables = [
            $this->table_hkaplikom => 'bentuk_aplikom',
            $this->table_hkartikel => 'name',
            $this->table_hkbuku => 'name',
            $this->table_hkdesainproduk => 'bentuk_desain',
            $this->table_hkfilm => 'name',
            $this->table_organisasi => 'name'
        ];

        $mhsColumn = [
            $this->table_mahasiswa . '.id',
            $this->table_mahasiswa . '.nim',
            $this->table_mahasiswa . '.name'
        ];

        $mhs = DB::table($this->table_mahasiswa);
        if ($checkAuth) {
            $user = auth()->user();
            if ($user->mahasiswa) {
                $mhs->where('id', '=', $user->mahasiswa->id);
            }
        }
        $mhs = $mhs->get($mhsColumn);

        $result = [];
        foreach ($mhs as $m) {
            $result[$m->id] = json_decode(json_encode($m), true);
            $result[$m->id]['data'] = [];
            $result[$m->id]['total'] = 0;
            foreach ($tables as $table => $name) {
                $records = DB::table($table)->where([
                    ['mahasiswa_id', $m->id],
                    ['approval_status', Model::APPROVE],
                ])->get(['id as event_id', $name . ' as event_name'])->each(function ($item) use ($table) {
                    $item->type = str_replace('hk_', '', $table);
                })->toArray();
                if ($records) {
                    $result[$m->id]['data'] = array_merge(
                        $result[$m->id]['data'],
                        json_decode(json_encode($records), true)
                    );
                }
            }
            $result[$m->id]['total'] = count($result[$m->id]['data']);
        }

        // jika user ambil data saja
        if ($checkAuth && Gate::allows('isMahasiswa')) {
            foreach ($result as $value) {
                $result = $value['data'];
            }
        }

        $result = collect($result);

        return new LengthAwarePaginator($result->forPage($p, $n), $result->count(), $n, $p, [
            'path' => route('portofolio.index'),
            'pageName' => 'p'
        ]);
    }

    /**
     * Tampilkan portoflio mahasiswa
     * @param int $id
     * @return \App\Models\Mahasiswa
     */
    public function showPortoflio($id)
    {
        $table_kodifikasi = $this->table_kodifikasi;
        $tables = [
            'aplikom' => $this->table_hkaplikom,
            'artikel' => $this->table_hkartikel,
            'buku' => $this->table_hkbuku,
            'desain_produk' => $this->table_hkdesainproduk,
            'film' => $this->table_hkfilm,
            'organisasi' => $this->table_organisasi
        ];

        $result = [];
        foreach ($tables as $key => $table) {
            $records = DB::table($this->table_mahasiswa)
                ->join($table, $table . '.mahasiswa_id', '=', $this->table_mahasiswa . '.id')
                ->join($table_kodifikasi, $table_kodifikasi . '.id', '=', $table . '.kodifikasi_id')
                ->where($table . '.approval_status', '=', Model::APPROVE)
                ->where($this->table_mahasiswa . '.id', '=', $id)
                ->get([
                    $this->table_kodifikasi . '.code as kod_code',
                    $this->table_kodifikasi . '.second_name as kod_second_name',
                    $this->table_kodifikasi . '.kategori as kod_kategori',
                    $this->table_mahasiswa . '.nim as mhs_nim',
                    $this->table_mahasiswa . '.name as mhs_name',
                    $table . '.*'
                ])->each(function ($item) use ($key) {
                    $item->table_type = $key;
                    $item->kod_code = $item->kod_code . str_pad($item->id, 5, 0, STR_PAD_LEFT);
                });
            if (!$records->isEmpty()) {
                foreach ($records->toArray() as $data) {
                    $result[] = (object)[
                        'code' => $data->kod_code,
                        'type' => $data->table_type,
                        'details' => $data
                    ];
                }
            }
        }

        return $result;
    }

    /**
     * Tampilkan list portofolio belum di approve
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPendingPortofolio()
    {
        $karya = [
            $this->table_hkaplikom, $this->table_hkartikel, $this->table_hkbuku,
            $this->table_hkdesainproduk, $this->table_hkfilm, $this->table_organisasi
        ];
        $data = [];
        foreach ($karya as $table) {
            $records = DB::table($table)
                ->join($this->table_mahasiswa, $this->table_mahasiswa . '.id', '=', $table . '.mahasiswa_id')
                ->where('approval_status', '=', Model::PENDING)
                ->get([
                    $this->table_mahasiswa . '.id',
                    $this->table_mahasiswa . '.nim',
                    $this->table_mahasiswa . '.name as mhs_name',
                    $table . '.*'
                ])
                ->each(function ($item) use ($table, &$data) {
                    $item->type = str_replace('hk_', '', $table);
                    $item->event_id = $item->id;
                    $item->event = $item->name ??  $item->bentuk_aplikom ?? $item->bentuk_desain;
                    $item->name = $item->mhs_name;
                })->toArray();

            $data = array_merge($data, $records);
        }

        $records = collect($data)->sortBy('created_at', SORT_REGULAR, true);
        return $records;
    }
}
