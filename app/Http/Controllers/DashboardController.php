<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Siswa;
use App\Kelas;
use App\Tagihan;
use App\Pembayaran;

class DashboardController extends Controller
{
  
    public function __construct()
    {
        //
    }

    public function dashboard(){

        $data = [
            'siswa' => Siswa::all()->count(),
            'kelas' => Kelas::all()->count(),
            'tagihan' => Tagihan::all()->sum('nominal'),
            'ctagihan' => Tagihan::all()->count(),
            'cbayar' => Pembayaran::all()->count(),
            'bayar' => Pembayaran::all()->sum('bayar'),
        ];

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
            ->paginate(5);

        return response()->json($data, 200);
    }

}
