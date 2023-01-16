<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\SenderController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\SampleDownloadController;
use App\Http\Controllers\TercourierController;
use App\Http\Controllers\PoController;
use App\Http\Controllers\InvoiceController;

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

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
// logout route
Route::get('/logout', [LoginController::class,'logout']);

Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('posts', PostController::class);

    ////////////////// 
Route::get('/import-Data', [ImportExportController::class,'ImportExcel']);
Route::get('/add-sender', [SenderController::class,'addSenderIndex']);
Route::get('/sender-table', [SenderController::class,'senderTable']);
Route::get('/create-courier', [CourierController::class,'createCourier']);
Route::get('/courier-table', [CourierController::class,'courierTable']);
Route::post('/import', [ImportExportController::class,'Import']);
Route::post('/save-sender', [SenderController::class,'addSender']);
Route::get('/edit-sender/{id}', [SenderController::class,'editSender']);
Route::post('/update-sender', [SenderController::class,'updateSender']);
Route::post('senders/delete-sender', [SenderController::class, 'deleteSender']);

Route::get('/autocomplete-search', [CourierController::class, 'autocompleteSearch']);

Route::any('/create-newCourier', [CourierController::class, 'newCourier']);

Route::get('/courier-company',  [TableController::class, 'courierCompanies']);

Route::get('catagories',  [TableController::class, 'categoryTable']);
Route::get('for-company',  [TableController::class, 'forCompany']);


Route::post('create-courierName', [TableController::class, 'createcourierCompany']);
Route::get('edit-courierName/{id}', [TableController::class, 'editcourierCompany']);
Route::put('updated-courier', [TableController::class, 'updatecourierCompany']);
Route::any('delete-courierCompany/{id}', [TableController::class, 'destroycourierCompany']);


Route::get('edit-catagories/{id}', [TableController::class, 'editCat']);
Route::put('update-catagories', [TableController::class, 'updateCatagories']);
Route::any('delete-catagories/{id}', [TableController::class, 'destroyCatagories']);

Route::post('create-company', [TableController::class, 'createforCompany']);
Route::get('edit-company/{id}', [TableController::class, 'editforCompany']);
Route::put('updated-company', [TableController::class, 'updateforCompany']);
Route::any('delete-forcompany/{id}', [TableController::class, 'destroyforCompany']);
////////
Route::get('/sample-sender',[SampleDownloadController::class, 'senderSample']);
Route::get('/sample-spine-hr-dump',[SampleDownloadController::class, 'spinehrSample']);
Route::get('/sample-courier',[SampledownloadController::class, 'courierCompaniesSample']);
Route::get('/sample-category',[SampleDownloadController::class, 'catagoreisSample']);
Route::get('/sample-for',[SampleDownloadController::class, 'forSample']);

Route::get('/edit-courier/{id}',[CourierController::class, 'editCourier']);
Route::any('edit-courier/update-data/{id}', [CourierController::class, 'updateCourier']);
Route::any('delete-courier/{id}', [CourierController::class, 'destroyCourier']); 

Route::resource('tercouriers', TercourierController::class);
Route::any('add-trrow', [TercourierController::class, 'addTrRow']);
Route::any('create-terrow', [TercourierController::class, 'createRow']); 
Route::any('get_employees', [TercourierController::class, 'getEmployees']);
Route::any('ter-bundles', [TercourierController::class, 'terBundles']);

// Dhruv routes

Route::post('change_status', [TercourierController::class, 'change_status_to_handover']);
Route::post('add_data', [TercourierController::class, 'add_details_to_DB']);
Route::post('add_multiple_data', [TercourierController::class, 'add_multi_details_to_DB']);
// Route::get('update_ter', [TercourierController::class, 'update_ter']);
Route::get('update_ter/{id}', [TercourierController::class, 'update_ter']);
Route::post('get_all_data', [TercourierController::class, 'get_all_data']);
Route::post('ter_pay_now', [TercourierController::class, 'ter_pay_now']);
Route::post('ter_pay_later', [TercourierController::class, 'ter_pay_later']);
Route::post('open_verify_ter', [TercourierController::class, 'open_verify_ter']);
Route::post('open_hr_verify_ter', [TercourierController::class, 'open_hr_verify_ter']);


Route::get('admin_update_ter/{id}', [TercourierController::class, 'admin_update_ter']);
Route::post('update_by_hr_admin', [TercourierController::class, 'update_by_hr_admin']);

Route::get('show_pay_later_data', [TercourierController::class, 'show_pay_later_data']);
Route::get('show_full_and_final_data', [TercourierController::class, 'show_full_and_final_data']);
Route::get('show_rejected_ter', [TercourierController::class, 'show_rejected_ter']);
Route::get('show_emp_not_exist', [TercourierController::class, 'show_emp_not_exist']);
Route::get('show_settlement_deduction', [TercourierController::class, 'show_settlement_deduction']);
Route::post('pay_later_ter_now', [TercourierController::class, 'pay_later_ter_now']);
Route::post('group_pay_now', [TercourierController::class, 'group_pay_now']);


Route::get('/export_emp_table', [ImportExportController::class,'ExportSender']);
Route::get('/export_ter_user_entry', [ImportExportController::class,'ExportSavedEntry']);

Route::get('edit_ter_reception', [TercourierController::class, 'edit_ter_reception']);
Route::post('edit_tercourier', [TercourierController::class, 'edit_tercourier']);

Route::get('payment_sheet', [TercourierController::class, 'payment_sheet']);
Route::post('/get_emp_data', [SenderController::class,'get_emp_data']);

Route::get('/employee_detail_passbook/{emp_id}', [SenderController::class, 'emp_passbook_view']);
Route::post('/add_advance_payment', [SenderController::class,'add_advance_payment']);
Route::post('/get_employee_passbook', [SenderController::class,'get_employee_passbook']);

Route::get('unprosessed-ter-widgets', [HomeController::class, 'unprocessedTerWidgets']);
Route::get('daily-work-performance', [HomeController::class, 'dailyworkPerformance']);
Route::get('hand_shake_report', [TercourierController::class, 'hand_shake_report']);
Route::get('download_ter_list', [TercourierController::class, 'download_ter_list']);
Route::get('download_status_wise_ter/{status}', [TercourierController::class, 'download_status_wise_ter']);
Route::post('/get_searched_data', [TercourierController::class,'get_searched_data']);
Route::post('/get_file_name', [TercourierController::class,'get_file_name']);
Route::get('download_ter_full_list', [TercourierController::class, 'download_ter_full_list']);
Route::get('download_handshake_report', [TercourierController::class, 'download_handshake_report']);
Route::get('download_reception_list', [TercourierController::class, 'download_reception_list']);
Route::post('/cancel_ter', [TercourierController::class,'cancel_ter']);
Route::post('/check_deduction', [TercourierController::class,'check_deduction']);
Route::post('/update_ter_deduction', [TercourierController::class,'update_ter_deduction']);
Route::post('/update_rejected_ter', [TercourierController::class,'update_rejected_ter']);
Route::post('/status_change_to_handover', [TercourierController::class,'status_change_to_handover']);
Route::post('/get_emp_list', [TercourierController::class,'get_emp_list']);
Route::post('/update_emp_details', [TercourierController::class,'update_emp_details']);
Route::post('/get_rejected_details', [TercourierController::class,'get_rejected_details']);
Route::post('/partially_paid_details', [TercourierController::class,'partially_paid_details']);
Route::post('/submit_hr_remarks', [TercourierController::class,'submit_hr_remarks']);
Route::get('/document_list', [TercourierController::class,'received_docs']);
Route::post('/accept_handover', [TercourierController::class,'accept_handover']);
Route::post('/reject_handover', [TercourierController::class,'reject_handover']);


Route::view('/reports','pages/export-data');

Route::get('download_report/{type}',[ImportExportController::class,'download_report']);

Route::get('/get-locations', [UserController::class, 'getLocation']);
Route::get('/get_departments', [UserController::class, 'getDepartment']);

Route::resource('pos', PoController::class);
Route::resource('invoices', InvoiceController::class);
Route::get('/get-po', [InvoiceController::class, 'getPo']);

});

Route::get('/forgot-session', [HomeController::class, 'ForgotSession']);

Route::get('/check_paid_status', [TercourierController::class,'check_paid_status']);
Route::get('/check_deduction_paid_status', [TercourierController::class,'check_deduction_paid_status']);
Route::get('/check_finfect_status', [TercourierController::class,'check_finfect_status']);

// Route::post('/change_status','App\Http\Controllers\TercourierController@change_status_to_handover');