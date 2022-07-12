<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use DataTables;

class CategoryController extends Controller{

    function __construct(){
        $this->outputData = [];
    }

    public function index(){
        $this->outputData['pageName'] = 'Categories Manager';
        $this->outputData['dataTables'] = url('categories/datatable');
        $this->outputData['delete'] = url('categories/delete');
        $this->outputData['create'] = url('categories/create');
        $this->outputData['edit'] = url('categories/edit');
        return view('pages.category.index',$this->outputData);
    }

    public function datatable(Request $request){
        if ($request->ajax()) {
            $datas = Category::order()->get();

            return DataTables::of($datas)->toJson();
        }
    }

    public function create(Request $request){
        try {
            if($request->method() == 'POST'){
                $Input = $request->all();
                // Validation section
                $validator = Validator::make($Input, [
                    'name' => 'required|max:50|unique:categories,name',
                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                
                //--- Insert Record
                $objInsert = new Category();
                $objInsert->fill($Input)->save();

                return response()->json(['success' => trans('messages.category_add')]);
            }
            $this->outputData['pageName'] = 'New Category';
            $this->outputData['action'] = url('categories/store');
            return view('pages.category.create',$this->outputData);
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
                    'name' => 'required|max:50|unique:categories,name,'.$id,

                ]);
    
                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()]);
                }
                
                //--- Update Record
                $objUpdate = Category::find($id);
                $objUpdate->fill($Input)->save();

                return response()->json(['success' => trans('messages.category_edit')]);
            }
            $this->outputData['pageName'] = 'Edit Category';
            $this->outputData['action'] = url('categories/update/'.$id);
            $this->outputData['objData'] = Category::findOrFail($id);
            return view('pages.category.create',$this->outputData);
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
            $res = Category::find($id)->delete();   
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
