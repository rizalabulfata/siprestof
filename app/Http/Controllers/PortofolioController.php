<?php

namespace App\Http\Controllers;

use App\Models\Model;
use App\Service\PortofolioService;
use Exception;
use Illuminate\Http\Request;

class PortofolioController extends Controller
{
    const RESOURCE = 'portofolio';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PortofolioService $service)
    {
        $data['title'] = 'Portofolio';
        $data['tables'] = $this->table();
        $data['resource'] = self::RESOURCE;

        $conditions = ['approval_status' => Model::APPROVE];
        $data['records'] = $service->getListPortofolioView(5, $request->p, [], $conditions);
        // dd($data['records']);

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
    public function show($id, PortofolioService $service)
    {
        try {
            $data['records'] = $service->showPortoflio($id);
            $data['resource'] = self::RESOURCE;
            return view('pages.portofolio.detail-pres', $data);
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
                'name' => 'Jumlah Portofolio',
                'visibility' => [self::RESOURCE . '.index']
            ],
        ];
    }
}
