<?php

namespace App\Http\Controllers\Api;

use App\Http\Components\ResponseComponents;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    public $response;

    public function __construct(ResponseComponents $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            $getData = Item::select('id', 'name')->with('pajak')->get();
            foreach($getData as $data) {
                foreach($data->pajak as $dataPajak) {
                    $dataPajak->rate = round($dataPajak->rate, 2) . '%';
                }
            }

            return ($getData) ? $this->response->success('Mendapatkan Data item', $getData) : $this->response->error('Data Anda Kosong', $getData);
        } catch (\Throwable $th) {
            return $this->response->error('error', $th);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreItemRequest $request)
    {
        DB::beginTransaction();
        try {
            Item::create($request->all());
            DB::commit();
            return $this->response->success('Data berhasil disimpan', null);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            return $this->response->error('Error', $th);
        }
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreItemRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            Item::updateOrCreate([
                'id' => $id,
            ], [
                'name' => $request->name,
            ]);

            DB::commit();
            return $this->response->success('Data berhasil dihapus', null);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            return $this->response->error('Error', $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Item::find($id);
            $data->delete();
            return $this->response->success('Data berhasil dihapus', null);
        } catch (\Throwable $th) {
            return $this->response->error('Data gagal dihapus', $th);
        }
    }
}
