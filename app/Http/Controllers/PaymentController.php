<?php

namespace App\Http\Controllers;

use App\Models\Ipayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\IpaymentItem;
use App\Models\Currency;
use App\Models\Category;
use App\Models\Payable;
use App\Models\Payment;
use App\Models\OrderCarrier;
use DataTables;

class PaymentController extends Controller{

    function __construct(){
        $this->outputData = [];
    }

    public function index(){
        $this->outputData['pageName'] = 'All Payments';
        $this->outputData['dataTables'] = url('payments/datatable');
        $this->outputData['delete'] = url('payments/delete');
        $this->outputData['create'] = url('payments/create');
        $this->outputData['edit'] = url('payments/edit');
        return view('pages.payment.index',$this->outputData);
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $datas = Payment::select('id','invoice_payable_id','invoice_no','invoice_category','currency_id','invoice_no','invoice_date','invoice_tax_type','invoice_total','is_paid','paid_chq');
            if ($request->start_date != null) {
                $datas->whereHas('ipayment', function($q) use ($request){
                    $q->where('payment_date','>=', $request->start_date);
                });
            }
            if ($request->end_date != null) {
                $datas->whereHas('ipayment', function($q) use ($request){
                    $q->where('payment_date','<=',$request->end_date);
                });
            }
            if ($request->filter_by != null && $request->filter != null) {
                if ($request->filter_by == "payment_id") {
                    $datas->where('payment_id',$request->filter);
                }
                if ($request->filter_by == "payment_desc") {
                    $datas->where('payment_desc',$request->filter);
                }
                if ($request->filter_by == "invoice_id") {
                    $datas->where('invoice_id',$request->filter);
                }
                if ($request->filter_by == "customer") {
                    $datas->whereHas('ipayment.customer', function($q) use ($request){
                        $q->where('company', $request->filter);
                    });
                }
            }
            $datas = $datas->order()->get();
            
            $datas = $datas->map(function($query){
                return [
                    "id" => $query->id,
                    "invoice_payable" => (isset($query->payable->company)) ? $query->payable->company : '',
                    "invoice_category" => (isset($query->category->name)) ? $query->category->name : '',
                    "invoice_no" => $query->invoice_no,
                    "invoice_date" => $query->invoice_date,
                    "gst" => ($query->invoice_tax_type == 'GST') ? $query->invoice_tax : '0.00',
                    "hst" => ($query->invoice_tax_type == 'HST') ? $query->invoice_tax : '0.00',
                    "total" => $query->invoice_total,
                    "currency" => $query->currency->code,
                    "is_paid" => $query->is_paid,
                    "paid_chq" => $query->paid_chq
                ];
            });

            return DataTables::of($datas)->toJson();
        }
    }

    public function create(Request $request){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();
                // Validation section
                $validator = Validator::make($Input, [
                    'invoice_date' => 'required'
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                
                //--- Logic Section
                $Input['created_by'] = Auth::user()->id;
                $Input['created_time'] = now();
                if(isset($Input['is_paid'])){
                    $Input['paid_by'] = Auth::user()->id;
                    $Input['paid_time'] = now(); 
                }

                //--- Insert Record
                $objInsert = new Payment();
                $objInsert->fill($Input)->save();

                return response()->json(['success' => trans('messages.payment_add')]);
            }
            $this->outputData['pageName'] = 'New Payment';
            $this->outputData['action'] = url('payments/store');
            $this->outputData['currency'] = Currency::all();
            $this->outputData['category'] = Category::all();
            $this->outputData['payables'] = Payable::where('is_carrier',0)->get();
            $this->outputData['carriers'] = Payable::where('is_carrier',1)->get();
            return view('pages.payment.create',$this->outputData);
        } catch (\Throwable $e) {
            $log = [
                'file' => __FILE__,
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'msg' => $e->getMessage(),
            ];

            Log::error($log);

            return response()->json(['error' => $e->getMessage()]);
        }        
    }

    public function edit(Request $request,$id){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();
                // Validation section
                $validator = Validator::make($Input, [
                    'invoice_date' => 'required'
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                
                //--- Logic Section
                if(isset($Input['is_paid'])){
                    $Input['paid_by'] = Auth::user()->id;
                    $Input['paid_time'] = now(); 
                }

                //--- Insert Record
                $objUpdate = Payment::find($id);
                $objUpdate->fill($Input)->save();

                return response()->json(['success' => trans('messages.payment_edit')]);
            }
            $this->outputData['pageName'] = 'Edit Payment';
            $this->outputData['action'] = url('payments/update/'.$id);
            $this->outputData['currency'] = Currency::all();
            $this->outputData['category'] = Category::all();
            $this->outputData['payables'] = Payable::where('is_carrier',0)->get();
            $this->outputData['carriers'] = Payable::where('is_carrier',1)->get();
            $this->outputData['objData'] = Payment::findOrFail($id);
            return view('pages.payment.create',$this->outputData);
        } catch (\Throwable $e) {
            $log = [
                'file' => __FILE__,
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'msg' => $e->getMessage(),
            ];

            Log::error($log);

            return response()->json(['error' => $e->getMessage()]);
        }        
    }

    public function receivable(){
        $this->outputData['pageName'] = 'All Receivable Payments';
        $this->outputData['dataTables'] = url('payments/receivable/datatable');
        $this->outputData['edit'] = url('payments/receivable/edit');
        return view('pages.payment.receivable.index',$this->outputData);
    }

    public function receivableDatatable(Request $request){
        if ($request->ajax()) {
            $datas = IpaymentItem::with('ipayment');
            if ($request->start_date != null) {
                $datas->whereHas('ipayment', function($q) use ($request){
                    $q->where('payment_date','>=', $request->start_date);
                });
            }
            if ($request->end_date != null) {
                $datas->whereHas('ipayment', function($q) use ($request){
                    $q->where('payment_date','<=',$request->end_date);
                });
            }
            if ($request->filter_by != null && $request->filter != null) {
                if ($request->filter_by == "payment_id") {
                    $datas->where('payment_id',$request->filter);
                }
                if ($request->filter_by == "payment_desc") {
                    $datas->where('payment_desc',$request->filter);
                }
                if ($request->filter_by == "invoice_id") {
                    $datas->where('invoice_id',$request->filter);
                }
                if ($request->filter_by == "customer") {
                    $datas->whereHas('ipayment.customer', function($q) use ($request){
                        $q->where('company', $request->filter);
                    });
                }
            }
            $datas = $datas->order()->get();
            
            $datas = $datas->map(function($query){
                return [
                    "id" => $query->id,
                    "payment_id" => $query->payment_id,
                    "payment_date" => (isset($query->ipayment->payment_date)) ? $query->ipayment->payment_date : '',
                    "payment_type" => (isset($query->ipayment->payment_type->abbreviation)) ? $query->ipayment->payment_type->abbreviation : '',
                    "payment_desc" => (isset($query->ipayment->payment_desc)) ? $query->ipayment->payment_desc : '',
                    "paid_amount" => $query->paid_amount,
                    "paid_currency" => (isset($query->ipayment->currency->code)) ? $query->ipayment->currency->code : '',
                    "invoice_id" => $query->invoice_id,
                    "customer" => (isset($query->ipayment->customer->company)) ? $query->ipayment->customer->company : '',
                    "payment_comments" => (isset($query->ipayment->payment_comments)) ? $query->ipayment->payment_comments : '',
                ];
            });

            return DataTables::of($datas)->toJson();
        }
    }

    public function receivableEdit(Request $request,$id){
        try {
            $this->outputData['pageName'] = 'Payment # '.$id;
            $this->outputData['objData'] = IpaymentItem::findOrFail($id);
            return view('pages.payment.receivable.view',$this->outputData);
        } catch (\Throwable $e) {
            $log = [
                'file' => __FILE__,
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'msg' => $e->getMessage(),
            ];

            Log::error($log);

            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function carriers(){
        $this->outputData['pageName'] = 'All Payables Orders';
        $this->outputData['dataTables'] = url('payments/carriers/datatable');
        $this->outputData['order'] = url('orders/edit');
        $this->outputData['create'] = url('payments/carriers/create');
        $this->outputData['edit'] = url('payments/edit');
        return view('pages.payment.carrier.index',$this->outputData);
    }

    public function carrierDatatable(Request $request){
        if ($request->ajax()) {
            $datas = OrderCarrier::select('id','carrier_id','order_id','agreed_price','agreed_price_currency','payment_id');
            // if ($request->start_date != null) {
            //     $datas->whereHas('ipayment', function($q) use ($request){
            //         $q->where('payment_date','>=', $request->start_date);
            //     });
            // }
            // if ($request->end_date != null) {
            //     $datas->whereHas('ipayment', function($q) use ($request){
            //         $q->where('payment_date','<=',$request->end_date);
            //     });
            // }
            // if ($request->filter_by != null && $request->filter != null) {
            //     if ($request->filter_by == "payment_id") {
            //         $datas->where('payment_id',$request->filter);
            //     }
            //     if ($request->filter_by == "payment_desc") {
            //         $datas->where('payment_desc',$request->filter);
            //     }
            //     if ($request->filter_by == "invoice_id") {
            //         $datas->where('invoice_id',$request->filter);
            //     }
            //     if ($request->filter_by == "customer") {
            //         $datas->whereHas('ipayment.customer', function($q) use ($request){
            //             $q->where('company', $request->filter);
            //         });
            //     }
            // }
            $datas = $datas->order()->get();
            
            $datas = $datas->map(function($query){
                return [
                    "id" => $query->id,
                    "carrier" => (isset($query->carrier->company)) ? $query->carrier->company : '',
                    "order_id" => $query->order_id,
                    "pcs" => (isset($query->order->pcs)) ? $query->order->pcs : '',
                    "status" => (isset($query->order->status->name)) ? $query->order->status->name : '',
                    "delivery_date" => (isset($query->order->to_date)) ? $query->order->to_date : '',
                    "agreed_price" => $query->agreed_price,
                    "currency" => $query->currency->code,
                    "payment_id" => ($query->payment_id) ? $query->payment_id : '',
                ];
            });

            return DataTables::of($datas)->toJson();
        }
    }

    public function carrierPaymentCreate(Request $request,$id){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();
                // Validation section
                $validator = Validator::make($Input, [
                    'invoice_date' => 'required'
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                
                //--- Logic Section
                if(isset($Input['is_paid'])){
                    $Input['paid_by'] = Auth::user()->id;
                    $Input['paid_time'] = now(); 
                }

                //--- Insert Record
                $objUpdate = Payment::find($id);
                $objUpdate->fill($Input)->save();

                return response()->json(['success' => trans('messages.payment_edit')]);
            }
            $this->outputData['pageName'] = 'New Payment';
            $this->outputData['action'] = url('payments/store');
            $this->outputData['currency'] = Currency::all();
            $this->outputData['category'] = Category::all();
            $this->outputData['payables'] = Payable::all();
            $this->outputData['objData'] = OrderCarrier::findOrFail($id);
            return view('pages.payment.carrier.create',$this->outputData);
        } catch (\Throwable $e) {
            $log = [
                'file' => __FILE__,
                'line' => $e->getLine(),
                'function' => __FUNCTION__,
                'msg' => $e->getMessage(),
            ];

            Log::error($log);

            return response()->json(['error' => $e->getMessage()]);
        }        
    }
}