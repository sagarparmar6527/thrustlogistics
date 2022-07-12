<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model{

    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'company','contact','phone','phone_other','fax','email','comments','address','address2','city','state','postal','country_id','bill_sameasmailing','bill_address','bill_address2','bill_city','bill_state','bill_postal','bill_country_id','charge_hst_id','charge_gst_id','charge_fuel_id','currency_id','terms'
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

    public function country(){
        return $this->hasOne(Country::class,'id','country_id');
    }

    public function invoice(){
        return $this->hasOne(Invoice::class,'customer_id','id')->select('customer_id','printed','paid_amt','credit_by');
    }
}
