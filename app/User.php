<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
 
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'name', 'username', 'email', 'password',
    ];


    public function AvatarDefault(){

        if(!$this->avatar){
            return asset('uploads/default.png');
        }

        return asset('uploads/'.$this->avatar);

    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tagihan()
    {
         return $this->hasOne(Tagihan::class);
    }
   
    public function kelas()
    {
         return $this->hasOne(Kelas::class);
    }

     public function angkatan()
    {
         return $this->hasOne(Angkatan::class);
    }

}
