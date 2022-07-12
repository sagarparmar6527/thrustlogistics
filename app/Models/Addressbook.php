<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addressbook extends Model{

    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'address_name','customer_id','company','contact','phone','address','address2','city','state','postal','country_id','deleted_by'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function ScopeOrder($query){
        return $query->orderBy('id','desc');
    }

    public function customer(){
        return $this->hasOne(Customer::class,'id','customer_id');
    }

    public function country(){
        return $this->hasOne(Country::class,'id','country_id');
    }
}
