<?php

namespace App\Service;

use App\Models\Kompetisi;
use App\Models\Mahasiswa;
use App\Models\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class PrestasiService extends Service
{
    /**
     * ambil seluruh data kompetisi mahasiswa
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListPrestasi($n = 10, $relations = [], $conditions = [], $columns = ['*'], $order = ['updated_at', 'asc'])
    {
        return Kompetisi::with($relations)->where($conditions)->orderBy($order[0], $order[1])->paginate($n, $columns);
    }

    /**
     * ambil seluruh data portofolio mahasiswa
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListPrestasiView($n = 10, $p = null, $conditions = [], $search_filters = [], $columns = ['*'], $order = ['updated_at', 'asc'])
    {
        $p = $p ?: (Paginator::resolveCurrentPage() ?: 1);
        $n = $n <= 0 ? -1 : $n;

        $columns = [
            $this->table_mahasiswa . '.id',
            $this->table_mahasiswa . '.nim',
            $this->table_mahasiswa . '.name',
            DB::raw('count(*) as total'),
        ];
        $records = DB::table($this->table_mahasiswa)
            ->join($this->table_kompetisi, $this->table_kompetisi . '.mahasiswa_id', '=', $this->table_mahasiswa . '.id')
            ->join($this->table_penghargaan, $this->table_penghargaan . '.mahasiswa_id', '=', $this->table_mahasiswa . '.id')
            ->where($this->table_kompetisi . '.approval_status', '=', Model::APPROVE)
            ->where($this->table_penghargaan . '.approval_status', '=', Model::APPROVE)
            ->where(function ($q) use ($search_filters) {
                foreach ($search_filters as $col => $value) {
                    $q->orWhere($col, 'like', '%' . $value . '%');
                }
            })
            ->groupBy($this->table_mahasiswa . '.id', $this->table_mahasiswa . '.nim', $this->table_mahasiswa . '.name', $this->table_mahasiswa . '.updated_at')
            ->orderBy($this->table_mahasiswa . '.updated_at', 'desc')
            ->get($columns);

        return new LengthAwarePaginator($records->forPage($p, $n), $records->count(), $n, $p, [
            'path' => route('prestasi.index'),
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
     * Tampilkan list prestasi belum di approve
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPendingPrestasi()
    {
        $columns = [
            $this->table_mahasiswa . '.id',
            $this->table_mahasiswa . '.nim',
            $this->table_mahasiswa . '.name'
        ];

        $komp_kolom = $columns;
        $komp_kolom[] = $this->table_kompetisi . '.name as event';
        $komp_kolom[] = $this->table_kompetisi . '.created_at';
        $kompetisi = DB::table($this->table_mahasiswa)
            ->join($this->table_kompetisi, $this->table_kompetisi . '.mahasiswa_id', '=', $this->table_mahasiswa . '.id')
            ->where($this->table_kompetisi . '.approval_status', '=', Model::PENDING)
            ->get($komp_kolom);
        $kompetisi->each(function ($item) {
            $item->type = 'kompetisi';
        });

        $peng_kolom = $columns;
        $peng_kolom[] = $this->table_penghargaan . '.name as event';
        $peng_kolom[] = $this->table_penghargaan . '.created_at';
        $penghargaan = DB::table($this->table_mahasiswa)
            ->join($this->table_penghargaan, $this->table_penghargaan . '.mahasiswa_id', '=', $this->table_mahasiswa . '.id')
            ->where($this->table_penghargaan . '.approval_status', '=', Model::PENDING)
            ->get($peng_kolom);
        $penghargaan->each(function ($item) {
            $item->type = 'penghargaan';
        });

        $records = collect(array_merge($kompetisi->toArray(), $penghargaan->toArray()))->sortBy('created_at', SORT_REGULAR, true);
        return $records;
    }
}
