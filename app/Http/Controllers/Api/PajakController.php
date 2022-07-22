<?php

namespace App\Http\Controllers\Api;

use App\Http\Components\ResponseComponents;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePajakRequest;
use App\Models\Item;
use App\Models\Pajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PajakController extends Controller
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
            $getData = Pajak::select('id', 'name')->get();
            return ($getData) ? $this->response->success('Mendapatkan Data Pajak', $getData) : $this->response->error('Data Anda Kosong', $getData);
        } catch (\Throwable $th) {
            return $this->response->error('Error', $th);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StorePajakRequest $request)
    {
        DB::beginTransaction();
        try {
            $data_item = Item::find($request->item_id);
            if(empty($data_item) || is_null($data_item)) {
                return $this->response->error('Item tersebut tidak ada', null);
            }

            Pajak::create($request->all());
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePajakRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data_item = Item::find($request->item_id);

            if(empty($data_item) || is_null($data_item)) {
                return $this->response->error('Item tersebut tidak ada', null);
            }
            Pajak::updateOrCreate([
                'id' => $id,
            ], [
                'item_id' => $request->item_id,
                'name' => $request->name,
                'rate' => $request->rate
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
            $data = Pajak::find($id);
            $data->delete();
            return $this->response->success('Data berhasil dihapus', null);
        } catch (\Throwable $th) {
            return $this->response->error('Data gagal dihapus', $th);
        }
    }
}
