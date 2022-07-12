<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Addressbook;
use App\Models\Customer;
use App\Models\Country;
use DataTables;

class AddressBookController extends Controller{
    
    function __construct(){
        $this->outputData = [];
    }

    public function index(){
        $this->outputData['pageName'] = 'Addresses Manager';
        $this->outputData['dataTables'] = url('addressbooks/datatable');
        $this->outputData['delete'] = url('addressbooks/delete');
        $this->outputData['create'] = url('addressbooks/create');
        $this->outputData['edit'] = url('addressbooks/edit');
        $this->outputData['customer'] = Customer::all();
        if(Auth::user()->isEmployee()){
            $this->outputData['customer'] = Customer::all();
        }else{
            $this->outputData['customer'] = Customer::where('id',Auth::user()->customer_id)->get();
        }
        return view('pages.addressbook.index',$this->outputData);
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $datas = Addressbook::with('country');
            if(!Auth::user()->isEmployee()){
                $datas->where('customer_id',Auth::user()->customer_id);
            }
            if ($request->customer_id != null) {
                $datas->where('customer_id',$request->customer_id);
            }
            if ($request->address_name != null) {
                $datas->where('address_name',$request->address_name);
            }
            $datas = $datas->order()->get();
            return DataTables::of($datas)->toJson();
        }
    }

    public function create(Request $request){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();
                // Validation section
                $validator = Validator::make($Input, [
                    'address_name' => 'required|max:50',
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }

                //--- Insert Record
                $objInsert = new Addressbook();
                $objInsert->fill($Input)->save();

                return response()->json(['success' => trans('messages.addressbook_add')]);
            }
            $this->outputData['pageName'] = 'New Address';
            $this->outputData['action'] = url('addressbooks/store');
            $this->outputData['customer'] = Customer::all();
            $this->outputData['country'] = Country::all();
            return view('pages.addressbook.create',$this->outputData);
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
                // Validation sectionz
                $validator = Validator::make($Input, [
                    'address_name' => 'required|max:50',
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                
                //--- Update Record
                $objUpdate = Addressbook::find($id);
                $objUpdate->fill($Input)->save();

                return response()->json(['success' => trans('messages.addressbook _edit')]);
            }
            $this->outputData['pageName'] = 'Edit Address';
            $this->outputData['action'] = url('addressbooks/update/'.$id);
            $this->outputData['objData'] = Addressbook::findOrFail($id);
            $this->outputData['customer'] = Customer::all();
            $this->outputData['country'] = Country::all();
            return view('pages.addressbook.create',$this->outputData);
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
            $res = Addressbook::find($id)->delete();   
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
