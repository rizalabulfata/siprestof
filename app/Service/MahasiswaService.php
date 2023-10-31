<?php

namespace App\Service;

use App\Models\Mahasiswa;

class MahasiswaService
{
    /**
     * ambil seluruh data mahasiswa
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListMahasiswa($n = 10, $relations = [], $conditions = [], $columns = ['*'], $order = [])
    {
        return Mahasiswa::with($relations)->where($conditions)->paginate($n, $columns);
    }

    /**
     * ambil seluruh data mahasiswa untuk view list
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getListMahasiswaView($n = 10, $relations = [], $conditions = [], $columns = ['*'], $order = [])
    {
        $columns = ['name', 'nim', 'kelas', 'prodi'];
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
