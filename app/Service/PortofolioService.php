<?php

namespace App\Service;

use App\Models\Kompetisi;
use App\Models\Mahasiswa;
use App\Models\Model;
use Illuminate\Pagination\LengthAwarePaginator;
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
    public function getListPortofolioView($n = 10, $relations = [], $conditions = [], $columns = ['*'], $order = ['updated_at', 'asc'])
    {

        $columns = [
            $this->table_mahasiswa . '.nim',
            $this->table_mahasiswa . '.name',
            DB::raw('count(*) as total'),
        ];
        $model = DB::table($this->table_mahasiswa)
            ->join($this->table_kompetisi, $this->table_kompetisi . '.mahasiswa_id', '=', $this->table_mahasiswa . '.id')
            ->join($this->table_penghargaan, $this->table_penghargaan . '.mahasiswa_id', '=', $this->table_mahasiswa . '.id')
            ->where($this->table_kompetisi . '.approval_status', '=', Model::APPROVE)
            ->where($this->table_penghargaan . '.approval_status', '=', Model::APPROVE)
            ->groupBy($this->table_mahasiswa . '.nim', $this->table_mahasiswa . '.name', $this->table_mahasiswa . '.updated_at')
            ->orderBy($this->table_mahasiswa . '.updated_at', 'desc');
        $records = $model->get($columns);

        return new LengthAwarePaginator($records, $model->count(), $n, null);
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
}
