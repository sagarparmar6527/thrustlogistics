<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class DashboardController extends Controller{

    function __construct(){
        $this->outputData = [];
    }

    public function index(){
        if(Auth::user()->isEmployee()){
            $this->outputData['draft'] = Order::currentYear()->draft()->count();
            $this->outputData['submitted'] = Order::currentYear()->submitted()->count();
            $this->outputData['dispatched'] = Order::currentYear()->dispatched()->count();
            $this->outputData['delivered'] = Order::currentYear()->delivered()->count();
            $this->outputData['invoiced'] = Order::currentYear()->invoiced()->count();
            $this->outputData['canceled'] = Order::currentYear()->canceled()->count();
            $this->outputData['ready'] = Order::currentYear()->ready()->count();
            $this->outputData['total'] = Order::currentYear()->count();
        }
        return view('pages.dashboard',$this->outputData);
    }
}
