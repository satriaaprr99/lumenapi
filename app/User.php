<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
 
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    protected $table = 'users';

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

    public function getJWTIdentifier()  
    {  
        return $this->getKey();  
    }  
    
    public function getJWTCustomClaims()  
    {  
        return [];  
    }  


}
