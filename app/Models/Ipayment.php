<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Ipayment extends Model{

    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'created_by','created_datetime','payment_type_id','payment_date','payment_desc','payment_comments','customer_id','paid_currency_id','paid_amt'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function payment_type(){
        return $this->hasOne(PaymentType::class,'id','payment_type_id')->select('id','abbreviation');
    }

    public function currency(){
        return $this->hasOne(Currency::class,'id','paid_currency_id')->select('id','code');
    }

    public function customer(){
        return $this->hasOne(Customer::class,'id','customer_id')->select('id','company');
    }
}
