<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model{

    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'created_by','created_time','currency_id','invoice_no','invoice_date','invoice_category','invoice_payable_id','invoice_carrier_id','invoice_orders','invoice_tax_type','invoice_tax','invoice_total','invoice_comments','is_paid','paid_by','paid_time','paid_chq','paid_chq_date','paid_comments','deleted_by'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function ScopeOrder($query){
        return $query->orderBy('id','desc');
    }

    public function payable(){
        return $this->hasOne(Payable::class,'id','invoice_payable_id')->select('id','company');
    }

    public function category(){
        return $this->hasOne(Category::class,'id','invoice_category');
    }

    public function currency(){
        return $this->hasOne(Currency::class,'id','currency_id');
    }
}
