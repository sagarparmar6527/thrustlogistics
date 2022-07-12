<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model{

    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'invoice_date','invoice_user','customer_id','currency_id','tax_type','charge_hst','charge_gst','charge_fuel','charge_total','terms','printed','printed_time','paid_amt','credit_amt','credit_by','credit_time','withdrawn','withdrawn_comments','withdrawn_by','withdrawn_time','deleted_at'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function ScopeOrder($query){
        return $query->orderBy('id','desc');
    }

    public function ScopeCurrentYear($query){
        return $query->whereYear('invoice_date', date('Y'));
    }

    public function customer(){
        return $this->hasOne(Customer::class,'id','customer_id');
    }

    public function currency(){
        return $this->hasOne(Currency::class,'id','currency_id');
    }

    public function order(){
        return $this->hasOne(Order::class,'invoice_id','id');
    }

    public function credit_employee(){
        return $this->hasOne(User::class,'id','credit_by');
    }

    public function ipayment_item(){
        return $this->hasOne(IpaymentItem::class,'invoice_id','id');
    }
}
