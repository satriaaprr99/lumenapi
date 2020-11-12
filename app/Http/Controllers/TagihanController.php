<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tagihan;

class TagihanController extends Controller
{
    
    public function __construct()
    {
        //
    }

    public function index(){

        $data = Tagihan::all();

        return response()->json($data, 200);
    }

    public function create(Request $request){

        $data = Tagihan::create([
            'kd_tagihan' => $request->kd_tagihan,
            'jenis_tagihan' => $request->jenis_tagihan,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'nominal' => $request->nominal
        ]);

        return response()->json($data, 201);

    }

    public function show($id){

        $check_data = Tagihan::firstWhere('id', $id);

        if($check_data){
            return response()->json(Tagihan::find($id), 200);
        } else {
            return response([
                'status' => 'ERROR',
                'message'=> 'Data Tidak Ditemukan',
            ], 404);
        }
        

    }

    public function update(Request $request, $id){

         $check_data = Tagihan::firstWhere('id', $id);

        if($check_data){
            $data = Tagihan::find($id);
            $data->update($request->all());
            return response()->json($data, 200);
        }else{
            return response([
                'status' => 'ERROR',
                'message'=> 'Data Tidak Ditemukan',
            ], 404);
        }

    }

    public function destroy($id){

        $check_data = Tagihan::firstWhere('id', $id);

        if($check_data){
            $delete = Tagihan::destroy($id);
            return response([
                'status' => 'OK',
                'message'=> 'Data Telah Dihapus',
            ], 200);
        }else{
            return response([
                'status' => 'ERROR',
                'message'=> 'Data Tidak Ditemukan',
            ], 404);
        }

    }
}
