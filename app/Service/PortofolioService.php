<?php

namespace App\Service;

use App\Models\Kompetisi;
use App\Models\Mahasiswa;
use App\Models\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

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
    public function getListPortofolioView($n = 10, $p = null, $relations = [], $conditions = [], $columns = ['*'], $order = ['updated_at', 'asc'])
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

        $mhs = DB::table($this->table_mahasiswa)->get($mhsColumn);

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
        $model = DB::table($this->table_mahasiswa)
            ->join($this->table_kompetisi, $this->table_kompetisi . '.mahasiswa_id', '=', $this->table_mahasiswa . '.id')
            ->join($this->table_penghargaan, $this->table_penghargaan . '.mahasiswa_id', '=', $this->table_mahasiswa . '.id')
            ->where($this->table_kompetisi . '.approval_status', '=', Model::APPROVE)
            ->where($this->table_penghargaan . '.approval_status', '=', Model::APPROVE)
            ->where($this->table_mahasiswa . '.id', '=', $id)->get();
        return $model;
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
