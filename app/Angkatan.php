<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    protected $table = 'angkatan';
   
    protected $fillable = [
          'nama_angkatan', 'tahun'
    ];

    
}
