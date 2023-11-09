<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const SUCCESS = 'success';
    const ERROR = 'error';

    /**
     * Ambil auth user_id
     */
    protected function getAuthUserId()
    {
        return auth()->user()->id;
    }

    /**
     * Ambil auth action_id (mahasiswa / dosen)
     */
    protected function getAuthActionId()
    {
        $id = auth()->user()->mahasiswa->id;
        if (!$id) {
            $id = auth()->user()->pegawai->id;
        }
        return $id;
    }
}
