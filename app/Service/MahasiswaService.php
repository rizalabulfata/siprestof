<?php

namespace App\Service;

use App\Models\Mahasiswa;
use Illuminate\Pagination\LengthAwarePaginator;

class MahasiswaService
{
    /**
     * ambil seluruh data mahasiswa
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListMahasiswa($n = 10, $relations = [], $conditions = [], $columns = ['*'], $order = ['updated_at', 'asc'])
    {
        return Mahasiswa::with($relations)->where($conditions)->orderBy($order[0], $order[1])->paginate($n, $columns);
    }

    /**
     * ambil seluruh data mahasiswa untuk view list
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListMahasiswaView($n = 10, $relations = [], $conditions = [], $columns = ['*'], $order = ['updated_at', 'asc'])
    {
        $records = $this->getListMahasiswa($n, $relations, $conditions, ['*'], $order)->each(function ($item) use (&$relations) {
            $upperKelas = 0;
            foreach ($item->kelas as $kelas) {
                if ($upperKelas == 0) {
                    $item->setAttribute('active_kelas', $kelas->kelas);
                    $item->setAttribute('active_kelas_periode', $kelas->periode);
                }
            }
            $item->setAttribute('unit_name', $item->unit->name);
        });

        if (count($columns) > 0 && $columns[0] != '*') {
            $records = $records->map->only($columns);
        }
        if (count($columns) == 1 && $columns[0] != '*') {
            $records = $records->map->only($columns);
        }

        return new LengthAwarePaginator($records, $records->count(), $n, null);
    }

    /**
     * Tampilkan data mahasiswa
     * @param int $id
     * @return \App\Models\Mahasiswa
     */
    public function showMahasiswa($id)
    {
        return Mahasiswa::findOrFail($id);
    }

    /**
     * Simpan/update data mahasiswa
     * @param array $data
     * @param int|null $id
     * @return \App\Models\Mahasiswa
     */
    public function saveMahasiswa($data, $id = null)
    {
        $model = new Mahasiswa();
        if ($id) {
            $model = Mahasiswa::findOrFail($id);
        }

        $model->fill($data);
        $model->save();
        return $model;
    }

    /**
     * Soft-delete data mahasiswa
     * @param int $id
     * @return bool
     */
    public function deleteMahasiswa($id)
    {
        $data = $this->showMahasiswa($id);
        return $data->delete();
    }
}
