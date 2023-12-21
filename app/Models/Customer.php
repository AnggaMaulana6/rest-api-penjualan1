<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Model;
use Laravel\Sanctum\HasApiTokens;



class Customer extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = ['name','username', 'password', 'email', 'phone'];


    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
