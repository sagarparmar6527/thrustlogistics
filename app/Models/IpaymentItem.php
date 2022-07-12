<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpaymentItem extends Model{

    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'payment_id','invoice_id','paid_amount','paid_exch_rate','invoice_amount'
    ];

    public function ScopeOrder($query){
        return $query->orderBy('id','desc');
    }

    public function ipayment(){
        return $this->hasOne(Ipayment::class,'id','payment_id')->select('id','payment_date','payment_type_id','payment_desc','paid_currency_id','customer_id','payment_comments')->with('currency','payment_type','customer');
    }

    public function invoice(){
        return $this->hasOne(Invoice::class,'id','invoice_id');
    }
}
