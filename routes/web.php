<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WebAccessController;
use App\Http\Controllers\AddressBookController;
use App\Http\Controllers\PayableController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear-cache', function() {
	$exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('config:clear');
	$exitCode = Artisan::call('view:clear');
	$exitCode = Artisan::call('route:clear');
	return 'DONE'; //Return anything
});

Route::redirect('/','login');

Route::group(['middleware' => 'auth'],function(){
	Route::get('/dashboard',[DashboardController::class, 'index']);

	Route::prefix('employees')->group(function () {
		Route::get('/',[EmployeeController::class, 'index']);
		Route::get('/datatable',[EmployeeController::class, 'datatable']);
		Route::get('/create',[EmployeeController::class, 'create']);
		Route::post('/store',[EmployeeController::class, 'create']);
		Route::get('/edit/{id}',[EmployeeController::class, 'edit']);
		Route::post('/update/{id}',[EmployeeController::class, 'edit']);
		Route::get('/delete/{id}',[EmployeeController::class, 'destroy']);
	});

	Route::prefix('customers')->group(function () {
		Route::get('/',[CustomerController::class, 'index']);
		Route::get('/datatable',[CustomerController::class, 'datatable']);
		Route::get('/create',[CustomerController::class, 'create']);
		Route::post('/store',[CustomerController::class, 'create']);
		Route::get('/edit/{id}',[CustomerController::class, 'edit']);
		Route::post('/update/{id}',[CustomerController::class, 'edit']);
		Route::get('/delete/{id}',[CustomerController::class, 'destroy']);
	});

	Route::prefix('web-access')->group(function () {
		Route::get('/',[WebAccessController::class, 'index']);
		Route::get('/datatable',[WebAccessController::class, 'datatable']);
		Route::get('/create',[WebAccessController::class, 'create']);
		Route::post('/store',[WebAccessController::class, 'create']);
		Route::get('/edit/{id}',[WebAccessController::class, 'edit']);
		Route::post('/update/{id}',[WebAccessController::class, 'edit']);
		Route::get('/delete/{id}',[WebAccessController::class, 'destroy']);
	});

	Route::prefix('addressbooks')->group(function () {
		Route::get('/',[AddressBookController::class, 'index']);
		Route::get('/datatable',[AddressBookController::class, 'datatable']);
		Route::get('/create',[AddressBookController::class, 'create']);
		Route::post('/store',[AddressBookController::class, 'create']);
		Route::get('/edit/{id}',[AddressBookController::class, 'edit']);
		Route::post('/update/{id}',[AddressBookController::class, 'edit']);
		Route::get('/delete/{id}',[AddressBookController::class, 'destroy']);
	});

	Route::prefix('payables')->group(function () {
		Route::get('/',[PayableController::class, 'index']);
		Route::get('/datatable',[PayableController::class, 'datatable']);
		Route::get('/create',[PayableController::class, 'create']);
		Route::post('/store',[PayableController::class, 'create']);
		Route::get('/edit/{id}',[PayableController::class, 'edit']);
		Route::post('/update/{id}',[PayableController::class, 'edit']);
		Route::get('/delete/{id}',[PayableController::class, 'destroy']);
	});

	Route::prefix('categories')->group(function () {
		Route::get('/',[CategoryController::class, 'index']);
		Route::get('/datatable',[CategoryController::class, 'datatable']);
		Route::get('/create',[CategoryController::class, 'create']);
		Route::post('/store',[CategoryController::class, 'create']);
		Route::get('/edit/{id}',[CategoryController::class, 'edit']);
		Route::post('/update/{id}',[CategoryController::class, 'edit']);
		Route::get('/delete/{id}',[CategoryController::class, 'destroy']);
	});

	Route::prefix('orders')->group(function () {
		Route::get('/',[OrderController::class, 'index']);
		Route::post('/',[OrderController::class, 'index']);
		Route::get('/datatable',[OrderController::class, 'datatable']);
		Route::get('/create',[OrderController::class, 'create']);
		Route::post('/store',[OrderController::class, 'create']);
		Route::get('/edit/{id}',[OrderController::class, 'edit']);
		Route::post('/update/{id}',[OrderController::class, 'edit']);
		Route::get('/delete/{id}',[OrderController::class, 'destroy']);
		Route::get('/print/{id}',[OrderController::class, 'print']);
		Route::get('/bill-print/{id}',[OrderController::class, 'billPrint']);
		Route::get('/get-address/{id}',[OrderController::class, 'getAddress']);

		Route::prefix('carrier')->group(function () {
			Route::get('/create/{orderId}',[OrderController::class, 'createCarrier']);
			Route::post('/store',[OrderController::class, 'createCarrier']);
			Route::get('/edit/{id}',[OrderController::class, 'editCarrier']);
			Route::post('/update/{id}',[OrderController::class, 'editCarrier']);
			Route::get('/delete/{id}',[OrderController::class, 'destroyCarrier']);
			Route::get('/print/{id}',[OrderController::class, 'printCarrier']);
		});
		// Not Invoiced Order
		Route::get('/delivered',[OrderController::class, 'delivered']);
		// Invoicing Orders
		Route::get('/invoicing',[OrderController::class, 'invoicing']);

		//Trash Orders
		Route::prefix('trash')->group(function () {
			Route::get('/',[OrderController::class, 'trash']);
			Route::get('/datatable',[OrderController::class, 'trashDatatable']);
			Route::get('/permanent-delete/{id}',[OrderController::class, 'permanentDelete']);
			Route::get('/restore/{id}',[OrderController::class, 'restore']);
		});	
	});
	
	Route::prefix('invoices')->group(function () {
		Route::get('/',[InvoiceController::class, 'index']);
		Route::get('/datatable',[InvoiceController::class, 'datatable']);
		Route::get('/edit/{id}',[InvoiceController::class, 'edit']);
		Route::get('/credit-note/{id}',[InvoiceController::class, 'creditNote']);
		Route::get('/payment/{id}',[InvoiceController::class, 'payment']);
		Route::post('/payment/{id}',[InvoiceController::class, 'payment']);
		Route::get('/credits',[InvoiceController::class, 'credits']);
		Route::get('/print/{id}',[InvoiceController::class, 'print']);
	});

	Route::prefix('payments')->group(function () {
		Route::get('/',[PaymentController::class, 'index']);
		Route::get('/datatable',[PaymentController::class, 'datatable']);
		Route::get('/create',[PaymentController::class, 'create']);
		Route::post('/store',[PaymentController::class, 'create']);
		Route::get('/edit/{id}',[PaymentController::class, 'edit']);
		Route::post('/update/{id}',[PaymentController::class, 'edit']);

		Route::prefix('receivable')->group(function () {
			Route::get('/',[PaymentController::class, 'receivable']);
			Route::get('/datatable',[PaymentController::class, 'receivableDatatable']);
			Route::get('/edit/{id}',[PaymentController::class, 'receivableEdit']);
		});

		Route::prefix('carriers')->group(function () {
			Route::get('/',[PaymentController::class, 'carriers']);
			Route::get('/datatable',[PaymentController::class, 'carrierDatatable']);
			Route::get('/create/{id}',[PaymentController::class, 'carrierPaymentCreate']);
		});
	});

	Route::prefix('reports')->group(function () {
		Route::get('/outstanding',[ReportController::class, 'outstanding']);
		Route::post('/outstanding',[ReportController::class, 'outstanding']);

		Route::get('/load-manifest',[ReportController::class, 'loadManifest']);
		Route::post('/load-manifest',[ReportController::class, 'loadManifest']);

		Route::get('/sales',[ReportController::class, 'sales']);
		Route::post('/sales',[ReportController::class, 'sales']);

		Route::get('/expense',[ReportController::class, 'expense']);
		Route::post('/expense',[ReportController::class, 'expense']);
		
		Route::get('/receivable-aging',[ReportController::class, 'receivableAging']);

		Route::get('/payable-outstanding',[ReportController::class, 'payableOutstanding']);
	});
});

require __DIR__.'/auth.php';
