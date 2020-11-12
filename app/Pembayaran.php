<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'siswa_tagihan';
   
    protected $fillable = [
         'kd_bayar', 'tagihan_id', 'siswa_id', 'tgl_bayar', 'bayar'
    ];

    public function tagihan()
    {
         return $this->belongsTo(Tagihan::class,'tagihan_id', 'id', 'jenis_tagihan');
    }
   
    public function siswa()
    {
         return $this->belongsTo(Siswa::class,'siswa_id','id','nis');
    }

}
