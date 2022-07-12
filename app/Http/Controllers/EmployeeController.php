<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DataTables;

class EmployeeController extends Controller{

    function __construct(){
        $this->outputData = [];
    }

    public function index(){
        $this->outputData['pageName'] = 'Employees Manager';
        $this->outputData['dataTables'] = url('employees/datatable');
        $this->outputData['delete'] = url('employees/delete');
        $this->outputData['create'] = url('employees/create');
        $this->outputData['edit'] = url('employees/edit');
        return view('pages.employee.index',$this->outputData);
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            try {
                $datas = User::employee()->orderBy('id','desc')->get();

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

                return response()->json(['success' => trans('messages.employee_add')]);
            }
            $this->outputData['pageName'] = 'New Employee';
            $this->outputData['action'] = url('employees/store');
            return view('pages.employee.create',$this->outputData);
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

                return response()->json(['success' => trans('messages.employee_edit')]);
            }
            $this->outputData['pageName'] = 'Edit Employee';
            $this->outputData['action'] = url('employees/update/'.$id);
            $this->outputData['objData'] = User::findOrFail($id);
            return view('pages.employee.create',$this->outputData);
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
