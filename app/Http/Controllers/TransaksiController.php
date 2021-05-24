<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pembayaran;
use App\Siswa;

class TransaksiController extends Controller
{
    
    public function __construct()
    {
        //
    }

    public function index(){

        // $data = Pembayaran::all();
        $data = DB::table('siswa_tagihan')
            ->select('*',DB::RAW('siswa_tagihan.id as id'))
            ->join('siswa', 'siswa.nis', '=', 'siswa_tagihan.siswa_id')
            ->join('tagihan', 'tagihan.id', '=', 'siswa_tagihan.tagihan_id')
            ->join('kelas', 'kelas.id', '=', 'siswa.id_kelas')
            ->get();

        return response()->json($data, 200);
    }

    public function SiswaBayar($id){

        $data = DB::table('siswa_tagihan')
            ->select('*',DB::RAW('siswa_tagihan.id as id'))
            ->join('siswa', 'siswa.nis', '=', 'siswa_tagihan.siswa_id')
            ->join('tagihan', 'tagihan.id', '=', 'siswa_tagihan.tagihan_id')
            ->where('siswa.id', $id)
            ->get();

        return response()->json($data, 200);

    }

    public function histori(){

        // $data = Pembayaran::all();
        $data = DB::table('siswa_tagihan')
            ->select('*',DB::RAW('siswa_tagihan.id as id'), 'siswa_tagihan.updated_at as updated_at')
            ->join('siswa', 'siswa.nis', '=', 'siswa_tagihan.siswa_id')
            ->join('tagihan', 'tagihan.id', '=', 'siswa_tagihan.tagihan_id')
            ->join('kelas', 'kelas.id', '=', 'siswa.id_kelas')
            ->orderBy('siswa_tagihan.updated_at', 'DESC')
            ->get();

        return response()->json($data, 200);
    }

    public function show($id){

        $check_data = Pembayaran::firstWhere('id', $id);

        if($check_data){
            $data = DB::table('siswa_tagihan')
            ->select('*',DB::RAW('siswa_tagihan.id as id'))
            ->Join('siswa', 'siswa.nis', '=', 'siswa_tagihan.siswa_id')
            ->Join('tagihan', 'tagihan.id', '=', 'siswa_tagihan.tagihan_id')
            ->where('siswa_tagihan.id', $id)
            ->get();
            return response()->json($data, 200);
        } else {
            return response([
                'status' => 'ERROR',
                'message'=> 'Data Tidak Ditemukan',
            ], 404);
        }
        

    }

    public function create(Request $request){

        if(Siswa::where('nis',$request->siswa_id)->first() == false){
            return response([
                'status' => 'ERROR',
                'message'=> 'NIS tidak Ada di Data!',
            ], 404);   
        };

        $data = Pembayaran::create([
            'kd_bayar' => mt_rand(00000000, 99999999),
            'siswa_id' => $request->siswa_id,
            'tagihan_id' => $request->tagihan_id,
            'tgl_bayar' => $request->tgl_bayar,
            'bayar' => $request->bayar,
        ]);

        return response()->json($data, 201);

    }

    public function update(Request $request, $id){

         $check_data = Pembayaran::firstWhere('id', $id);

        if($check_data){

            $data = Pembayaran::find($id);

            if(Siswa::where('nis',$request->siswa_id)->first() == false):
                return response([
                    'status' => 'ERROR',
                    'message'=> 'NIS tidak Ada di Data!',
                ], 404);
            exit;
            endif;

            $data->update([
                'siswa_id' => $request->siswa_id,
                'tagihan_id' => $request->tagihan_id,
                'bayar' => $request->bayar,
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

        $check_data = Pembayaran::firstWhere('id', $id);

        if($check_data){
            $delete = Pembayaran::destroy($id);
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
