<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCarrier extends Model{

    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'parent_id','order_id','carrier_id','carrier_contact','carrier_phone','carrier_fax','carrier_equipment','from_instructions','to_company','to_contact','to_phone','to_address','to_address2','to_city','to_state','to_postal','to_country_id','to_date','to_instructions','agreed_price','agreed_price_currency','is_all_inclusive','dispatched','dispatched_time','payment_id'
    ];

    public function ScopeOrder($query){
        return $query->orderBy('id','desc');
    }

    public function to_country(){
        return $this->hasOne(Country::class,'id','to_country_id');
    }

    public function carrier(){
        return $this->hasOne(Payable::class,'id','carrier_id');
    }

    public function currency(){
        return $this->hasOne(Currency::class,'id','agreed_price_currency');
    }

    public function order(){
        return $this->hasOne(Order::class,'id','order_id');
    }

    public function dispatch(){
        return $this->hasOne(User::class,'id','dispatched');
    }
}
