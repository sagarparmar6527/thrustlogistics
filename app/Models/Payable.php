<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Payable extends Model{

    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'is_carrier','company','contact','phone','phone_other','fax','email','comments','address','address2','city','state','postal','country_id','bill_sameasmailing','bill_address','bill_address2','bill_city','bill_state','bill_postal','bill_country_id','currency_id','deleted_by'
    ];

    protected $hidden = [
        'deleted_at'
    ];   
    
    public function ScopeOrder($query){
        return $query->orderBy('id','desc');
    }

    public function currency(){
        return $this->hasOne(Currency::class,'id','currency_id');
    }
}
