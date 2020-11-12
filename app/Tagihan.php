<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
	protected $table = 'tagihan';

	protected $fillable = [
		'kd_tagihan', 'jenis_tagihan', 'tahun', 'bulan', 'nominal'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	public function siswa()
	{
		return  $this->belongsToMany(Siswa::class)->withPivot(['kd_bayar', 'bayar', 'created_at']);
	}

	public function tgl(){
    	return $this->created_at;
    }

    public function nominalFormat(){
    	return number_format($this->nominal);
    }

}
