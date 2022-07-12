<?php

namespace App\Http\Controllers;

use App\Models\Addressbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use App\Models\ServiceType;
use App\Models\Country;
use App\Models\ChargesFuel;
use App\Models\ChargesHst;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Payable;
use App\Models\User;
use App\Models\OrderCarrier;
use DataTables;

class OrderController extends Controller{

    function __construct(){
        $this->outputData = [];
        $this->invoice = 5;
    }

    public function index(Request $request){
        $this->outputData['dataTables'] = url('orders/datatable');
        $this->outputData['delete'] = url('orders/delete');
        $this->outputData['create'] = url('orders/create');
        $this->outputData['edit'] = url('orders/edit');
        if(Auth::user()->isEmployee()){
            $this->outputData['pageName'] = 'All Orders';
            return view('pages.order.index',$this->outputData);
        }
        $this->outputData['pageName'] = 'Orders Manager';
        if($request->method() == 'POST'){
            $this->outputData['posts'] = $request->all();
        }
        return view('pages.order.customer.index',$this->outputData);
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            try {
                $datas = Order::has('customer');
                if(!Auth::user()->isEmployee()){
                    $datas->where('customer_id',Auth::user()->customer_id);
                }
                if ($request->start_date != null) {
                    $datas->where('to_date','>=',$request->start_date);
                }
                if ($request->end_date != null) {
                    $datas->where('to_date','<=',$request->end_date);
                }
                if ($request->filter_by != null && $request->filter != null) {
                    if ($request->filter_by == "order_id") {
                        $datas->where('id',$request->filter);
                    }
                    if ($request->filter_by == "customer") {
                        $datas->whereHas('customer', function($q) use ($request){
                            $q->where('company', $request->filter);
                        });
                    }
                    if ($request->filter_by == "ref_number") {
                        $datas->where('ref_number',$request->filter);
                    }
                    if ($request->filter_by == "currency") {
                        $datas->whereHas('currency', function($q) use ($request){
                            $q->where('code', $request->filter);
                        });
                    }
                }
                if ($request->status_id != "[]") {
                    $datas->whereIn('status_id',json_decode($request->status_id));
                }
                if (isset($request->is_invoice_ready) &&  $request->is_invoice_ready != null) {
                    $datas->where('is_invoice_ready',$request->is_invoice_ready);
                }

                if (isset($request->is_invoice_rush) &&  $request->is_invoice_rush != null) {
                    $datas->where('is_invoice_rush',$request->is_invoice_rush);
                }
                $datas = $datas->currentYear()->order()->get();

                if(Auth::user()->isEmployee()){
                    $datas = $datas->map(function($query){
                        return [
                            "id" => $query->id,
                            "to_date" => $query->to_date,
                            "customer" => [
                                "company" => $query->customer->company,
                                "contact" => $query->customer->contact,
                                "phone" => $query->customer->phone,
                                "fax" => $query->customer->fax
                            ],
                            "address" => [
                                "to_city" => $query->to_city,
                                "to_state" => $query->to_state,
                                "to_country" => $query->to_country->name,
                                "from_city" => $query->from_city,
                                "from_state" => $query->from_state,
                                "from_country" => $query->from_country->name,
                            ],
                            "ref_number" => $query->ref_number,
                            "pcs" => $query->pcs,
                            "status" => $query->status->name,
                            "service" => $query->service->abbreviation,
                            "total_charges" => $query->total_charges,
                            "is_invoice_ready" => $query->is_invoice_ready,
                            "from_date" => $query->from_date,
                            "pcs" => $query->pcs,
                            "service_charge" => $query->service_charge,
                            "adjustments_charge" => $query->adjustments_charge,
                            "gst_charge" => $query->gst_charge,
                            "hst_charge" => $query->hst_charge,
                            "fuel_charge" => $query->fuel_charge,
                            "currency" => (isset($query->currency->code)) ? $query->currency->code : ''
                        ];
                    });
                }else{
                    $datas = $datas->map(function($query){
                        return [
                            "id" => $query->id,
                            "to_date" => $query->to_date,
                            "service" => $query->service->abbreviation,
                            "consignor" => $query->service->abbreviation,
                            "consignee" => $query->service->abbreviation,
                            "ref_number" => $query->ref_number,
                            "pcs" => $query->pcs,
                            "status" => $query->status->name
                        ];
                    }); 
                }

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

    public function create(Request $request){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();

                // Validation section
                $validator = Validator::make($Input, [
                    'customer_id' => 'required',
                    'service_id' => 'required',
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }

                if($Input['status_id'] == 'carrier'){
                    $Input['status_id'] = 1;
                }
                //--- Insert Record
                $objInsert = new Order();
                $objInsert->fill($Input)->save();
                
                if($request->status_id == 'carrier'){
                    return redirect('orders/carrier/create/'.$objInsert->id);
                }
                return response()->json(['success' => trans('messages.order_add')]);
            }
            $this->outputData['pageName'] = 'New Order';
            $this->outputData['action'] = url('orders/store');
            $this->outputData['serviceType'] = ServiceType::all();
            $this->outputData['country'] = Country::all();
            $this->outputData['chargesFuel'] = ChargesFuel::all();
            $this->outputData['chargesHst'] = ChargesHst::all();
            $this->outputData['currency'] = Currency::all();
            if(Auth::user()->isEmployee()){
                $this->outputData['customer'] = Customer::all();
                return view('pages.order.create',$this->outputData);
            }
            $this->outputData['customer'] = Customer::where('id',Auth::user()->customer_id)->get();
            return view('pages.order.customer.create',$this->outputData);
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
                    'customer_id' => 'required',
                    'service_id' => 'required',
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                
                //--- Update Record
                $objUpdate = Order::find($id);
                $objUpdate->fill($Input)->save();

                return response()->json(['success' => trans('messages.order_edit')]);
            }
            $this->outputData['pageName'] = 'Edit Order';
            $this->outputData['action'] = url('orders/update/'.$id);
            $this->outputData['createCarrier'] = url('orders/carrier/create');
            $this->outputData['editCarrier'] = url('orders/carrier/edit');
            $this->outputData['deleteCarrier'] = url('orders/carrier/delete');
            $this->outputData['print'] = url('orders/print/'.$id);
            $this->outputData['carrierPrint'] = url('orders/carrier/print');
            $this->outputData['billPrint'] = url('orders/bill-print/'.$id);
            $this->outputData['serviceType'] = ServiceType::all();
            $this->outputData['country'] = Country::all();
            $this->outputData['chargesFuel'] = ChargesFuel::all();
            $this->outputData['chargesHst'] = ChargesHst::all();
            $this->outputData['currency'] = Currency::all();
            $this->outputData['objData'] = Order::findOrFail($id);
            if((isset($request->is_carrier) && $request->is_carrier == 'Yes')){
                $this->outputData['is_carrier'] = true;
            }
            if(Auth::user()->isEmployee()){
                $this->outputData['customer'] = Customer::all();
                return view('pages.order.create',$this->outputData);
            }
            $this->outputData['customer'] = Customer::where('id',Auth::user()->customer_id)->get();
            return view('pages.order.customer.create',$this->outputData);
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

    public function destroy($id){
        try {
            $res = Order::find($id)->delete();   
            return response()->json(true);
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

    public function delivered(){
        $this->outputData['pageName'] = 'All Delivered Orders';
        $this->outputData['dataTables'] = url('orders/datatable');
        $this->outputData['invoice'] = url('orders/invoicing');
        $this->outputData['edit'] = url('orders/edit');
        return view('pages.order.delivered',$this->outputData);

    }

    public function invoicing(){
        try {
            $orders = Order::delivered()->invoiceReady()->get();
            if($orders->isNOtEmpty()){
                
                foreach ($orders as $key => $value) {
                    
                    $Input = [
                        'invoice_date' => date('Y-m-d'),
                        'customer_id' => $value->customer_id,
                        'currency_id' => $value->currency_id,
                        'charge_hst' => $value->hst_charge,
                        'charge_gst' => $value->gst_charge,
                        'charge_fuel' => $value->fuel_charge,
                        'charge_total' => $value->total_charges,
                        'terms' => $value->customer->terms
                    ];

                    // Create Invoice
                    $invoice = new Invoice();
                    $invoice->fill($Input)->save();
                    
                    $updateOrder = Order::find($value->id)->update(['invoice_id' => $invoice->id,'status_id' => $this->invoice]);
                }
                return response()->json(['success' => url('invoices')]);
            }
            return response()->json(['error' => trans('messages.order_no_invoiced')]);
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

    public function createCarrier(Request $request,$orderId=""){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();

                // Validation section
                $validator = Validator::make($Input, [
                    'carrier_id' => 'required'
                ]);

                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                if(!isset($Input['is_all_inclusive'])){
                    $Input['is_all_inclusive'] = 0;
                }
                //--- Insert Record
                $objInsert = new OrderCarrier();
                $objInsert->fill($Input)->save();
                
                $id = $Input['order_id'];
                return redirect('orders/edit/'.$id.'?is_carrier=Yes');
            }
            $this->outputData['pageName'] = 'Assign Carrier';
            $this->outputData['action'] = url('orders/carrier/store');
            $this->outputData['goBack'] = url('orders/edit/'.$orderId.'?is_carrier=Yes');
            $this->outputData['carrier'] = Payable::where('is_carrier',1)->get();
            $this->outputData['dispatcher'] = User::employee()->get();
            $this->outputData['serviceType'] = ServiceType::all();
            $this->outputData['country'] = Country::all();
            $this->outputData['chargesFuel'] = ChargesFuel::all();
            $this->outputData['chargesHst'] = ChargesHst::all();
            $this->outputData['currency'] = Currency::all();
            $this->outputData['objOrder'] = Order::findOrFail($orderId);
            return view('pages.order.create-carrier',$this->outputData);
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

    public function editCarrier(Request $request,$id){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();

                // Validation section
                $validator = Validator::make($Input, [
                    'carrier_id' => 'required'
                ]);

                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                if(!isset($Input['is_all_inclusive'])){
                    $Input['is_all_inclusive'] = 0;
                }
                //--- Insert Record
                $objUpdate = OrderCarrier::find($id);
                $objUpdate->fill($Input)->save();
                
                $id = $Input['order_id'];
                return redirect('orders/edit/'.$id.'?is_carrier=Yes');
            }
            $this->outputData['objData'] = OrderCarrier::findOrFail($id);
            $orderId = $this->outputData['objData']->order_id;
            $this->outputData['pageName'] = 'Assign Carrier';
            $this->outputData['action'] = url('orders/carrier/update/'.$id);
            $this->outputData['goBack'] = url('orders/edit/'.$orderId.'?is_carrier=Yes');
            $this->outputData['carrier'] = Payable::where('is_carrier',1)->get();
            $this->outputData['dispatcher'] = User::employee()->get();
            $this->outputData['serviceType'] = ServiceType::all();
            $this->outputData['country'] = Country::all();
            $this->outputData['chargesFuel'] = ChargesFuel::all();
            $this->outputData['chargesHst'] = ChargesHst::all();
            $this->outputData['currency'] = Currency::all();
            $this->outputData['objOrder'] = Order::findOrFail($orderId);
            return view('pages.order.create-carrier',$this->outputData);
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

    public function destroyCarrier($id){
        try {
            $res = OrderCarrier::find($id);
            $orderId = $res->order_id;
            $res->delete(); 
            return redirect('orders/edit/'.$orderId.'?is_carrier=Yes');
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

    public function trash(){
        $this->outputData['pageName'] = 'Trash Manager';
        $this->outputData['dataTables'] = url('orders/trash/datatable');
        $this->outputData['permanentDelete'] = url('orders/trash/permanent-delete');
        $this->outputData['restore'] = url('orders/trash/restore');
        return view('pages.order.trash',$this->outputData);
    }

    public function trashDatatable(Request $request){
        if ($request->ajax()) {
            try {
                $datas = Order::has('customer')->onlyTrashed();

                if ($request->order_id != null) {
                    $datas->where('id','>=',$request->order_id);
                }
                $datas = $datas->order()->get();

                $datas = $datas->map(function($query){
                    return [
                        "id" => $query->id,
                        "deleted_at" => $query->deleted_at->format('Y-m-d H:i:s'),
                        "deleted_by" => (isset($query->user->name)) ? $query->user->name : '',
                        "deleted_comments" => $query->deleted_comments,
                        "customer" => $query->customer->company,
                        "service" => $query->service->abbreviation,
                        "status" => $query->status->name
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

    public function permanentDelete($id){
        try {
            $res = Order::onlyTrashed()->find($id)->forceDelete();   
            return response()->json(true);
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

    public function restore($id){
        try {
            $res = Order::onlyTrashed()->find($id)->restore();
            return response()->json(true);
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
        $this->outputData['objData'] = Order::find($id);
        return view('pages.order.print',$this->outputData);
    }

    public function billPrint($id){
        $this->outputData['objData'] = Order::find($id);
        return view('pages.order.bill-print',$this->outputData);
    }

    public function printCarrier($id){
        $this->outputData['objData'] = OrderCarrier::find($id);
        return view('pages.order.print-carrier',$this->outputData);
    }

    public function getAddress($id){
        try {
            $address = Addressbook::where('customer_id',$id)->get();
            return response()->json($address);
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
