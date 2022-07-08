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
});

///////////////////
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
Route::get('/sample-courier',[SampledownloadController::class, 'courierCompaniesSample']);
Route::get('/sample-category',[SampleDownloadController::class, 'catagoreisSample']);
Route::get('/sample-for',[SampleDownloadController::class, 'forSample']);

Route::get('/edit-courier/{id}',[CourierController::class, 'editCourier']);
Route::any('edit-courier/update-data/{id}', [CourierController::class, 'updateCourier']);
Route::any('delete-courier/{id}', [CourierController::class, 'destroyCourier']); 

Route::resource('tercouriers', TercourierController::class);
