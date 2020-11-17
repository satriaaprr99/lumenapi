<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Angkatan;
use App\Siswa;

class AngkatanController extends Controller
{
    
    public function __construct()
    {
        //
    }

    public function index(){

        $data = Angkatan::all();


        return response()->json($data, 200);
    }

    public function create(Request $request){

        $data = Angkatan::create([
            'nama_angkatan' => $request->nama_angkatan,
            'tahun' => $request->tahun
        ]);

        return response()->json($data, 201);

    }

    public function show($id){

        $check_data = Angkatan::firstWhere('id', $id);

        if($check_data){
            $jml = Siswa::where('id_angkatan', $id)->count();
            return response()->json([
                'data' => Angkatan::find($id),
                'jml' => $jml
            ], 200);
        } else {
            return response([
                'status' => 'ERROR',
                'message'=> 'Data Tidak Ditemukan',
            ], 404);
        }
        

    }

    public function update(Request $request, $id){

         $check_data = Angkatan::firstWhere('id', $id);

        if($check_data){
            $data = Angkatan::find($id);
            $data->update([
                'nama_angkatan' => $request->nama_angkatan,
                'tahun' => $request->tahun
            ]);
            return response()->json($data, 200);
        }else{
            return response([
                'status' => 'ERROR',
                'message'=> 'Data Tidak Ditemukan',
            ], 404);
        }

    }

    public function destroy($id){

        $check_data = Angkatan::firstWhere('id', $id);

        if($check_data){
            $delete = Angkatan::destroy($id);
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
