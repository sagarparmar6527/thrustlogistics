<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Invoice;
use App\Models\PaymentType;
use App\Models\Currency;
use App\Models\Ipayment;
use App\Models\IpaymentItem;
use App\Models\Order;
use DataTables;

class InvoiceController extends Controller{

    function __construct(){
        $this->outputData = [];
    }

    public function index(){
        $this->outputData['pageName'] = 'All Invoices';
        $this->outputData['dataTables'] = url('invoices/datatable');
        $this->outputData['edit'] = url('invoices/edit');
        if(Auth::user()->isEmployee()){
            return view('pages.invoice.index',$this->outputData);
        }
        return view('pages.invoice.customer.index',$this->outputData);
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            
            try {
                $datas = Order::invoiced()->currentYear()->has('invoice');
                    if(!Auth::user()->isEmployee()){
                        $datas->where('customer_id',Auth::user()->customer_id);
                    }
                    if ($request->start_date != null) {
                        $datas->where('invoice_date','>=',$request->start_date);
                    }
                    if ($request->end_date != null) {
                        $datas->where('invoice_date','<=',$request->end_date);
                    }
                    if ($request->filter_by != null && $request->filter != null) {
                        if ($request->filter_by == "invoice_id") {
                            $datas->where('invoice_id',$request->filter);
                        }
                        if ($request->filter_by == "customer") {
                            $datas->whereHas('customer', function($q) use ($request){
                                $q->where('company', $request->filter);
                            });
                        }
                        if ($request->filter_by == "currency") {
                            $datas->whereHas('currency', function($q) use ($request){
                                $q->where('code', $request->filter);
                            });
                        }
                    }
                    if (isset($request->printed) && $request->printed != null) {
                        $datas->whereHas('invoice', function($q) use ($request){
                            $q->where('printed', $request->printed);
                        });
                    }
                    if (isset($request->withdrawn) && $request->withdrawn != null) {
                        $datas->whereHas('invoice', function($q) use ($request){
                            $q->where('withdrawn','<>',$request->withdrawn);
                        });
                    }
                $datas = $datas->order()->get();
                    
                $datas = $datas->map(function($query){
                    return [
                        "id" => $query->invoice->id,
                        "invoice_date" => $query->invoice->invoice_date,
                        "customer" => $query->customer->company,
                        "charge_gst" => $query->invoice->charge_gst,
                        "charge_hst" => $query->invoice->charge_hst,
                        "charge_fuel" => $query->invoice->charge_fuel,
                        "charge_total" => $query->invoice->charge_total,
                        "currency" => $query->currency->code,
                        "printed" => ($query->invoice->printed == 0) ? 0 : 1,
                        "is_paid" => ($query->invoice->paid_amt != null) ? 1 : 0,
                        "paid_amt" => ($query->invoice->paid_amt != null) ? $query->invoice->paid_amt : '-.--',
                        "amt_due" => ($query->invoice->paid_amt != null || $query->invoice->credit_amt != null) ? '0.00' : $query->invoice->charge_total,
                        "credit_amt" => ($query->invoice->credit_amt != null) ? $query->invoice->credit_amt : '-.--'
                    ];
                });

                return DataTables::of($datas)->toJson();
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

    public function edit(Request $request,$id){
        try {
            $this->outputData['pageName'] = 'Invoice # '.$id;
            $this->outputData['creditNote'] = url('invoices/credit-note/'.$id);
            $this->outputData['payment'] = url('invoices/payment/'.$id);
            $this->outputData['print'] = url('invoices/print/'.$id);
            $this->outputData['objData'] = Invoice::findOrFail($id);
            return view('pages.invoice.view',$this->outputData);
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

    public function creditNote($id){
        try {
            $invoice = Invoice::find($id);
            if($invoice->credit_by){
                $invoice->credit_amt = 0;
                $invoice->credit_by = 0;
                $invoice->credit_time = null;
                $message = trans('messages.invoice_remove');
            }else{
                $invoice->credit_amt = $invoice->charge_total;
                $invoice->credit_by = Auth::user()->id;
                $invoice->credit_time = now();
                $invoice->printed = 1;
                $invoice->printed_time = now();
                $message = trans('messages.invoice_credited').$invoice->charge_total;
            }
            $invoice->save();

            $result = [
                'success' => $message,
                'action' => url('invoices/edit/'.$id)
            ];
            return response()->json($result);
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

    public function payment(Request $request,$id){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();
                // Validation section
                $validator = Validator::make($Input, [
                    'paid_amt' => 'required'
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                // Logic Section
                $Input['created_by'] = Auth::user()->id;
                $Input['created_datetime'] = now();
                //--- Insert Record
                $objInsert = new Ipayment();
                $objInsert->fill($Input)->save();

                $objPayment = new IpaymentItem();
                $objPayment->payment_id = $objInsert->id;
                $objPayment->invoice_id = $id;
                $objPayment->paid_amount = $request->paid_amt;
                $objPayment->invoice_amount =  $request->paid_amt;
                $objPayment->save();

                $invoiceData = [
                    'paid_amt' => $request->paid_amt,
                    'printed' => 1,
                    'printed_time' => now(),
                ];
                $invoice = Invoice::find($id)->update($invoiceData);
                
                return response()->json(['success' => trans('messages.invoice_payment_add')]);
            }
            $this->outputData['pageName'] = 'New Payment';
            $this->outputData['action'] = url('invoices/payment/'.$id);
            $this->outputData['paymentType'] = PaymentType::all();
            $this->outputData['currency'] = Currency::all();
            $this->outputData['objData'] = Invoice::findOrFail($id);
            return view('pages.invoice.payment',$this->outputData);
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

    public function credits(Request $request){
        try {
            if ($request->ajax()) {
                $datas = Invoice::has('customer')->with('customer','credit_employee','currency')->where('credit_by','!=','');
                if ($request->start_date != null) {
                    $datas->where('invoice_date','>=', $request->start_date);
                }
                if ($request->end_date != null) {
                    $datas->where('invoice_date','<=',$request->end_date);
                }
                if ($request->filter_by != null && $request->filter != null) {
                    if ($request->filter_by == "invoice_id") {
                        $datas->where('id',$request->filter);
                    }
                    if ($request->filter_by == "customer") {
                        $datas->whereHas('customer', function($q) use ($request){
                            $q->where('company', $request->filter);
                        });
                    }
                }
                $datas = $datas->order()->get();
    
                return DataTables::of($datas)->toJson();
            }
            $this->outputData['pageName'] = 'All Credit Notes';
            $this->outputData['dataTables'] = url('invoices/credits');
            $this->outputData['edit'] = url('invoices/edit');
            return view('pages.invoice.credit',$this->outputData);
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

    public function print($id){
        $this->outputData['objData'] = Invoice::find($id);  
        return view('pages.invoice.print',$this->outputData);
    }
}