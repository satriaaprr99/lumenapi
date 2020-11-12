<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Siswa;
use App\Kelas;
use App\Angkatan;

class SiswaController extends Controller
{
    
    public function __construct()
    {
        //
    }

    public function index(){
        
        // $data = Siswa::orderBy('created_at', 'DESC')->with(['kelas'])->get();
        $data = DB::table('siswa')
                ->select('*',DB::RAW('siswa.id as id'))
                ->leftJoin('kelas', 'kelas.id', '=', 'siswa.id_kelas')
                ->leftJoin('angkatan', 'angkatan.id', '=', 'siswa.id_angkatan')
                ->get();
            
        return response()->json($data, 200);
    }

    public function create(Request $request){

        $data = Siswa::create([
                   'avatar' => $request->file('avatar'),
                   'nis' => $request->nis,
                   'nama' => $request->nama,
                   'id_kelas' => $request->id_kelas,
                   'id_angkatan' => $request->id_angkatan,
                   'nohp' => $request->nohp,
                   'alamat' => $request->alamat,
                ]);

        if ($request->hasFile('avatar')) {
            $request->file('avatar')->move('uploads/', $request->file('avatar')->getClientOriginalName());
            $data->avatar = $request->file('avatar')->getClientOriginalName();
            $data->save();
        };

        return response()->json([
            "status" => "Created",
            "message" => "success",
            "data" => $data
        ], 201);
    }

    public function show($id){

        $check_data = Siswa::firstWhere('id', $id);

        if($check_data){
            $data = DB::table('siswa')
                    ->select('*',DB::RAW('siswa.id as id'))
                    ->join('kelas', 'kelas.id', '=', 'siswa.id_kelas')
                    ->join('angkatan', 'angkatan.id', '=', 'siswa.id_angkatan')
                    ->where('siswa.id', $id)
                    ->get();
            return response()->json($data, 200);
        } else {
            return response([
                'status' => 'ERROR',
                'message'=> 'Data Tidak Ditemukan',
            ], 404);
        }
        

    }

    public function update(Request $request, $id){

         $check_data = Siswa::firstWhere('id', $id);

        if($check_data){
            $data = Siswa::find($id);
            $data->update([
                   'avatar' => $request->file('avatar'),
                   'nis' => $request->nis,
                   'nama' => $request->nama,
                   'id_kelas' => $request->id_kelas,
                   'id_angkatan' => $request->id_angkatan,
                   'nohp' => $request->nohp,
                   'alamat' => $request->alamat,
                ]);
            return response([
                'status' => 'OK',
                'message'=> 'Data Telah Diupdate',
                'data' => $data
            ], 200);
        }else{
            return response([
                'status' => 'ERROR',
                'message'=> 'Data Tidak Ditemukan',
            ], 404);
        }

    }

    public function destroy($id){

        $check_data = Siswa::firstWhere('id', $id);

        if($check_data){
            $delete = Siswa::destroy($id);
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
