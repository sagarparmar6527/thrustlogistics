<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Currency;
use App\Models\Country;
use App\Models\Payable;
use DataTables;

class PayableController extends Controller{

    function __construct(){
        $this->outputData = [];
    }

    public function index(){
        $this->outputData['pageName'] = 'Payables Manager';
        $this->outputData['dataTables'] = url('payables/datatable');
        $this->outputData['delete'] = url('payables/delete');
        $this->outputData['create'] = url('payables/create');
        $this->outputData['edit'] = url('payables/edit');
        return view('pages.payable.index',$this->outputData);
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $datas = Payable::with('currency');
            if ($request->is_carrier != null) {
                $datas->where('is_carrier',$request->is_carrier);
            }
            if ($request->filter_by != null && $request->name != null) {
                $datas->where($request->filter_by,$request->name);
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
                    'company' => 'required|max:50',
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                
                //--- Insert Record
                $objInsert = new Payable();
                $objInsert->fill($Input)->save();

                return response()->json(['success' => trans('messages.payable_add')]);
            }
            $this->outputData['pageName'] = 'New Payable';
            $this->outputData['action'] = url('payables/store');
            $this->outputData['currency'] = Currency::all();
            $this->outputData['country'] = Country::all();
            return view('pages.payable.create',$this->outputData);
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
                    'company' => 'required|max:50',
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                
                //--- Update Record
                $objUpdate = Payable::find($id);
                $objUpdate->fill($Input)->save();

                return response()->json(['success' => trans('messages.payable_edit')]);
            }
            $this->outputData['pageName'] = 'Edit Payable';
            $this->outputData['action'] = url('payables/update/'.$id);
            $this->outputData['objData'] = Payable::findOrFail($id);
            $this->outputData['currency'] = Currency::all();
            $this->outputData['country'] = Country::all();
            return view('pages.payable.create',$this->outputData);
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
            $res = Payable::find($id)->delete();   
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
