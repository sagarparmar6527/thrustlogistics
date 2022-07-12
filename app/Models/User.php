<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'is_system',
        'permission',
        'is_block',
        'customer_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ScopeOrder($query){
        return $query->orderBy('id','desc');
    }

    public function ScopeEmployee($query){
        return $query->where('customer_id',0);
    }

    public function customer(){
        return $this->hasOne(Customer::class,'id','customer_id');
    }

    public function isEmployee(){
        return ($this->customer_id == 0) ?? 0;
    }

    public function dataEntry(){
        return (in_array('Data entry',json_decode($this->permission))) ?? 0;
    }

    public function invoicing(){
        return (in_array('Invoicing',json_decode($this->permission))) ?? 0;
    }

    public function manageUsers(){
        return (in_array('Manage Users',json_decode($this->permission))) ?? 0;
    }
}
