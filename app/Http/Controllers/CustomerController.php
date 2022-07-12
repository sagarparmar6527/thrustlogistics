<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use App\Models\ChargesHst;
use App\Models\ChargesFuel;
use App\Models\Currency;
use App\Models\Country;
use DataTables;

class CustomerController extends Controller{
    
    function __construct(){
        $this->outputData = [];
    }

    public function index(){
        $this->outputData['pageName'] = 'Customers Manager';
        $this->outputData['dataTables'] = url('customers/datatable');
        $this->outputData['delete'] = url('customers/delete');
        $this->outputData['create'] = url('customers/create');
        $this->outputData['edit'] = url('customers/edit');
        return view('pages.customer.index',$this->outputData);
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $datas = Customer::with('currency')->order()->get();

            return DataTables::of($datas)->toJson();
        }
    }

    public function create(Request $request){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();
                // Validation section
                $validator = Validator::make($Input, [
                    'company' => 'required|max:50',
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
    
                //--- Insert Record
                $objInsert = new Customer();
                $objInsert->fill($Input)->save();
    
                return response()->json(['success' => trans('messages.customer_add')]);
            }
            $this->outputData['pageName'] = 'New Customer';
            $this->outputData['action'] = url('customers/store');
            $this->outputData['chargesHst'] = ChargesHst::all();
            $this->outputData['chargesFuel'] = ChargesFuel::all();
            $this->outputData['currency'] = Currency::all();
            $this->outputData['country'] = Country::all();
            return view('pages.customer.create',$this->outputData);
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
                    'company' => 'required|max:50',
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                
                //--- Update Record
                $objUpdate = Customer::find($id);
                $objUpdate->fill($Input)->save();

                return response()->json(['success' => trans('messages.customer_edit')]);
            }
            $this->outputData['pageName'] = 'Edit Customer';
            $this->outputData['action'] = url('customers/update/'.$id);
            $this->outputData['chargesHst'] = ChargesHst::all();
            $this->outputData['chargesFuel'] = ChargesFuel::all();
            $this->outputData['currency'] = Currency::all();
            $this->outputData['country'] = Country::all();
            $this->outputData['objData'] = Customer::findOrFail($id);
            return view('pages.customer.create',$this->outputData);
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
            $res = Customer::find($id)->delete();   
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
}
