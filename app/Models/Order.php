<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'order_datetime','customer_id','ref_number','comments','from_company','from_contact','from_phone','from_address','from_address2','from_city','from_state','from_postal','from_country_id','from_date','to_company','to_contact','to_phone','to_address','to_address2','to_city','to_state','to_postal','to_country_id','to_date','pcs','weight','value','content','service_id','service_charge','adjustments','adjustments_charge','hst_id','hst_charge','gst_id','gst_charge','fuel_id','fuel_charge','total_charges','currency_id',
        'is_local','is_domestic','is_international','is_prepaid','is_ground','is_collect','is_air','is_thirdparty','is_insurance','is_cod','cod_amt','lading_shiperno','lading_customerno','lading_orderno','lading_noteno','lading_acsprono','lading_pcs','lading_desc','lading_weight','lading_dim','pod_info','pod_datetime','status_id','is_invoice_ready','is_invoice_rush','invoice_id','checked_out','checked_out_time','deleted_by','deleted_comments'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function ScopeOrder($query){
        return $query->orderBy('id','desc');
    }

    public function ScopeCurrentYear($query){
        return $query->whereYear('order_datetime', date('Y'));
    }

    public function ScopeDraft($query){
        return $query->where('status_id',1);
    }

    public function ScopeSubmitted($query){
        return $query->where('status_id',2);
    }

    public function ScopeDispatched($query){
        return $query->where('status_id',3);
    }

    public function ScopeDelivered($query){
        return $query->where('status_id',4);
    }

    public function ScopeInvoiced($query){
        return $query->where('status_id',5);
    }

    public function ScopeCanceled($query){
        return $query->where('status_id',6);
    }

    public function ScopeReady($query){
        return $query->where('status_id',7);
    }

    public function ScopeInvoiceReady($query){
        return $query->where('is_invoice_ready',1);
    }

    public function customer(){
        return $this->hasOne(Customer::class,'id','customer_id');
    }

    public function status(){
        return $this->hasOne(Status::class,'id','status_id');
    }

    public function service(){
        return $this->hasOne(ServiceType::class,'id','service_id');
    }

    public function from_country(){
        return $this->hasOne(Country::class,'id','from_country_id');
    }

    public function to_country(){
        return $this->hasOne(Country::class,'id','to_country_id');
    }
    
    public function currency(){
        return $this->hasOne(Currency::class,'id','currency_id');
    }

    public function isDelivered(){
        return ($this->status_id == 4) ? true : false;
    }

    public function invoice(){
        return $this->hasOne(Invoice::class,'id','invoice_id');
    }

    public function carrier(){
        return $this->hasMany(OrderCarrier::class,'order_id','id');
    }
}
