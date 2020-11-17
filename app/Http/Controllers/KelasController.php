<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use App\Siswa;

class KelasController extends Controller
{
    
    public function __construct()
    {
        //
    }

    public function index(){

        $data = Kelas::all();

        return response()->json($data, 200);
    }

    public function create(Request $request){

        $data = Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'kompetensi_keahlian' => $request->kompetensi_keahlian
        ]);

        return response()->json($data, 201);

    }

    public function show($id){

        $check_data = Kelas::firstWhere('id', $id);

        if($check_data){
            $jml = Siswa::where('id_kelas', $id)->count();
            return response()->json([
                'data' => Kelas::find($id),
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

         $check_data = Kelas::firstWhere('id', $id);

        if($check_data){
            $data = Kelas::find($id);
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

        $check_data = Kelas::firstWhere('id', $id);

        if($check_data){
            $delete = Kelas::destroy($id);
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
