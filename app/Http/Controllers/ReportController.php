<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payable;
use App\Models\Category;
use App\Models\Payment;
use DataTables;

class ReportController extends Controller{

    function __construct(){
        $this->outputData = [];
    }

    public function outstanding(Request $request){
        if($request->method() == 'POST'){
            $receivable = Invoice::currentYear()->Where('printed','<>',0)->whereNull('paid_amt')->whereNull('credit_by');
            if($request->customer_id){
                $receivable->where('customer_id',$request->customer_id);
            }
            $receivable = $receivable->order()->get();
            $arrReceivable = [];
            foreach ($receivable as $key => $value) {
                $json = json_encode([
                    'customer_id' => $value->customer_id,
                    'invoice_date' => $value->invoice_date,
                    'company' => $value->customer->company,
                    'phone' => $value->customer->phone,
                    'fax' => $value->customer->fax,
                ]);

                $datediff = round((time() - strtotime($value->invoice_date)) / (60 * 60 * 24));

                $arrReceivable[$json][] = [
                    'id' => $value->id,
                    'invoice_date' => $value->invoice_date,
                    'days' => $datediff,
                    'amount' => $value->charge_total,
                    'currency' => $value->currency->code,
                ];
            }
            $this->outputData['receivable'] = $arrReceivable;
            return view('pages.reports.outstanding.view',$this->outputData);
        }
        $this->outputData['pageName'] = 'Outstanding Report';
        $this->outputData['generate'] = url('reports/outstanding');
        $this->outputData['customer'] = Invoice::currentYear()->Where('printed','<>',0)->whereNull('paid_amt')->whereNull('credit_by')->order()->get()->map(function($query){
                        return [
                            "id" => $query->customer->id,
                            "company" => $query->customer->company
                        ];
                    });

        return view('pages.reports.outstanding.index',$this->outputData);
    }

    public function loadManifest(Request $request){
        if($request->method() == 'POST'){
            $loadManifest = Order::where('ref_number',$request->ref_number)->order()->get();
            
            $this->outputData['loadManifest'] = $loadManifest;
            $this->outputData['ref_number'] = $request->ref_number;
            $this->outputData['drop1'] = Payable::find($request->carrier_id1);
            $this->outputData['drop2'] = Payable::find($request->carrier_id2);
            return view('pages.reports.load-manifest.view',$this->outputData);
        }
        $this->outputData['pageName'] = 'Load Manifest';
        $this->outputData['generate'] = url('reports/load-manifest');
        $this->outputData['carrier'] = Payable::where('is_carrier',1)->order()->get();
        return view('pages.reports.load-manifest.index',$this->outputData);
    }

    public function sales(Request $request){
        if($request->method() == 'POST'){
            $sales = Invoice::currentYear();
            if($request->customer_id){
                $sales->where('customer_id',$request->customer_id);
            }
            if ($request->from_date != null) {
                $sales->where('invoice_date','>=',$request->from_date);
            }
            if ($request->to_date != null) {
                $sales->where('invoice_date','<=',$request->to_date);
            }
            $sales = $sales->order()->get();
            
            $this->outputData['sales'] = $sales;
            $this->outputData['from_date'] = $request->from_date;
            $this->outputData['to_date'] = $request->to_date;
            return view('pages.reports.sales.view',$this->outputData);
        }
        $this->outputData['pageName'] = 'Sales Report';
        $this->outputData['generate'] = url('reports/sales');
        $this->outputData['customer'] = Customer::order()->get();
        return view('pages.reports.sales.index',$this->outputData);
    }

    public function expense(Request $request){
        if($request->method() == 'POST'){
            $expense = Payment::has('payable');
            if($request->invoice_category != null){
                $expense->where('invoice_category',$request->invoice_category);
            }
            if ($request->from_date != null) {
                $expense->where('invoice_date','>=',$request->from_date);
            }
            if ($request->to_date != null) {
                $expense->where('invoice_date','<=',$request->to_date);
            }
            $expense = $expense->get();
            
            $this->outputData['expense'] = $expense;
            $this->outputData['from_date'] = $request->from_date;
            $this->outputData['to_date'] = $request->to_date;
            return view('pages.reports.expense.view',$this->outputData);
        }
        $this->outputData['pageName'] = 'Expense Report';
        $this->outputData['generate'] = url('reports/expense');
        $this->outputData['categories'] = Category::order()->get();
        return view('pages.reports.expense.index',$this->outputData);
    }

    public function receivableAging(Request $request){
        $receivable = Invoice::selectRaw('sum(charge_total) as charge_total,customer_id')->currentYear()->whereNull('paid_amt')->whereNull('credit_by')->groupBy('customer_id')->get();

        $receivable = $receivable->map(function($query){
            return [
                "id" => $query->id,
                "customer" => $query->customer->company,
                "charge_total" => $query->charge_total
            ];
        });

        $this->outputData['receivable'] = $receivable;
        return view('pages.reports.receivable.view',$this->outputData);
    }

    public function payableOutstanding(Request $request){
        $payable = Payment::where('is_paid',0)->order()->get();

        $arrPayable = [];
        foreach ($payable as $key => $value) {
            $payableName = $value->payable->company;

            $arrPayable[$payableName][] = [
                'invoice_date' => $value->invoice_date,
                'invoice_no' => $value->invoice_no,
                'category' => $value->category->name,
                'currency' => $value->currency->code,
                'invoice_total' => $value->invoice_total
            ];
        }
        
        $this->outputData['payable'] = $arrPayable;
        return view('pages.reports.outstanding.payable',$this->outputData);
    }
}
