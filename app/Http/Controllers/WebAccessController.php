<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use DataTables;

class WebAccessController extends Controller{

    function __construct(){
        $this->outputData = [];
    }

    public function index(){
        $this->outputData['pageName'] = 'Customers: Web Access Manager';
        $this->outputData['dataTables'] = url('web-access/datatable');
        $this->outputData['delete'] = url('web-access/delete');
        $this->outputData['create'] = url('web-access/create');
        $this->outputData['edit'] = url('web-access/edit');
        
        if(Auth::user()->isEmployee()){
            $this->outputData['customer'] = Customer::all();
            return view('pages.web-access.index',$this->outputData);
        }
        $this->outputData['customer'] = Customer::where('id',Auth::user()->customer_id)->get();
        return view('pages.web-access.customer.index',$this->outputData);
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $datas = User::has('customer')->with('customer')->where('customer_id','!=',0);
            if(!Auth::user()->isEmployee()){
                $datas->where('customer_id',Auth::user()->customer_id);
            }
            if ($request->customer_id != null) {
                $datas->where('customer_id',$request->customer_id);
            }
            if ($request->name != null) {
                $datas->where('name',$request->name);
            }
            $datas = $datas->order()->get();

            return DataTables::of($datas)
                                ->addColumn('data_entry',function(User $data){
                                    return (in_array('Data entry',json_decode($data->permission)));
                                })
                                ->addColumn('invoicing',function(User $data){
                                    return (in_array('Invoicing',json_decode($data->permission)));
                                })
                                ->addColumn('manage_users',function(User $data){
                                    return (in_array('Manage Users',json_decode($data->permission)));
                                })
                                ->rawColumns(['data_entry','invoicing','manage_users'])
                                ->toJson();
        }
    }

    public function create(Request $request){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();
                // Validation section
                $validator = Validator::make($Input, [
                    'name' => 'required|max:50',
                    'username' => 'required|max:25|unique:users,username',
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                
                //--- Logic Section
                $Input['permission'] = [];
                if(isset($request->permission)){
                    $Input['permission'] = json_encode($request->permission);
                }
                if($request->password != null){
                    $Input['password'] = Hash::make($request->password);
                }

                //--- Insert Record
                $objInsert = new User();
                $objInsert->fill($Input)->save();

                return response()->json(['success' => trans('messages.webaccess_add')]);
            }
            $this->outputData['pageName'] = 'New Web User (Customer)';
            $this->outputData['action'] = url('web-access/store');
            if(Auth::user()->isEmployee()){
                $this->outputData['customer'] = Customer::all();
            }else{
                $this->outputData['customer'] = Customer::where('id',Auth::user()->customer_id)->get();
            }
            return view('pages.web-access.create',$this->outputData);
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
                    'name' => 'required|max:50',
                    'username' => 'required|max:25|unique:users,username,'.$id,

                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                
                //--- Logic Section
                $Input['permission'] = [];
                if(isset($request->permission)){
                    $Input['permission'] = json_encode($request->permission);
                }
                if($request->password != null){
                    $Input['password'] = Hash::make($request->password);
                }else{
                    unset($Input['password']);
                }

                //--- Update Record
                $objUpdate = User::find($id);
                $objUpdate->fill($Input)->save();

                return response()->json(['success' => trans('messages.webaccess_edit')]);
            }
            $this->outputData['pageName'] = 'Edit Web User (Customer)';
            $this->outputData['action'] = url('web-access/update/'.$id);
            $this->outputData['objData'] = User::findOrFail($id);
            if(Auth::user()->isEmployee()){
                $this->outputData['customer'] = Customer::all();
            }else{
                $this->outputData['customer'] = Customer::where('id',Auth::user()->customer_id)->get();
            }
            return view('pages.web-access.create',$this->outputData);
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
            $res = User::find($id)->delete();   
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
