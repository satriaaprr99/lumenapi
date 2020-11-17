<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Siswa;
use App\Kelas;
use App\Angkatan;
use App\Tagihan;
use App\Pembayaran;

class SiswaController extends Controller
{
    
    public function __construct()
    {
        //
    }

    public function index(){
                
        $data = DB::table('siswa')
                ->select('*',DB::RAW('siswa.id as id'))
                ->join('kelas', 'kelas.id', '=', 'siswa.id_kelas')
                ->join('angkatan', 'angkatan.id', '=', 'siswa.id_angkatan')
                ->get();
            
        return response()->json($data, 200);
    }

    public function create(Request $request){

        $this->validate($request, [
                'nis' => 'required|min:10|max:11|unique:siswa',
                'nama' => 'required|string|max:255',
                'id_kelas' => 'required',
                'id_angkatan' => 'required',
                'nohp' => 'required|max:15',
                'alamat' => 'required'
            ]);

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

    public function createTransaksi(Request $request, $id){

        $data = Siswa::find($id);

        if($data->tagihan()->where('tagihan_id', $request->tagihan_id)->first() == true){
            return response()->json([
                'status' => 'ERROR',
                'message' => 'Data Tagihan sudah ada di tabel siswa'
            ], 404);
        }else{
            $create = Pembayaran::create([
                'kd_bayar' => mt_rand(00000000, 99999999),
                'siswa_id' => $data->nis,
                'tagihan_id' => $request->tagihan_id,
                'tgl_bayar' => $request->tgl_bayar,
                'bayar' => $request->bayar,
            ]);

        return response()->json($create, 201);
        }

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

         $this->validate($request, [
                'nis' => 'required|min:10|max:11',
                'nama' => 'required|string|max:255',
                'id_kelas' => 'required',
                'id_angkatan' => 'required',
                'nohp' => 'required|max:15',
                'alamat' => 'required'
            ]);


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
            if ($request->hasFile('avatar')) {
                $request->file('avatar')->move('uploads/', $request->file('avatar')->getClientOriginalName());
                $data->avatar = $request->file('avatar')->getClientOriginalName();
                $data->update();
            };
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
            $data = Siswa::find($id);
            $delete = Siswa::destroy($id);
            $delete = Pembayaran::where('siswa_id', $data->nis)->delete();
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
