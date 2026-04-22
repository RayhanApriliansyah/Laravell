<?php

use App\Models\Airport;
use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VesselController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ShipperController;
use App\Http\Controllers\AirportsController;
use App\Http\Controllers\ConsigneeController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//login
Route::get('login', [AuthController::class, 'login'])->name('login');
//login proses
Route::post('login', [AuthController::class, 'loginproses'])->name('loginproses');
//Register
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/registerproses', [AuthController::class, 'registerproses'])->name('registerproses');

//logout
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['checklogin'])->group(function () {

    //dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //user
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users.create', [UserController::class, 'create'])->name('userCreate');
    Route::post('/users', [UserController::class, 'store'])->name('userStore');
    Route::get('/users.edit.{id}', [UserController::class, 'edit'])->name('userEdit');
    Route::post('/users.update.{id}', [UserController::class, 'update'])->name('userUpdate');
    Route::delete('/users.destroy.{id}', [UserController::class, 'destroy'])->name('userDestroy');
    //search
    Route::get('/users.data', [UserController::class, 'getData'])->name('users.data');


    //Country

    Route::get('countries', [CountryController::class, 'index'])->name('countries.index');
    Route::get('/countries.create', [CountryController::class, 'create'])->name('countries.create');
    Route::post('/countries.store', [CountryController::class, 'store'])->name('countries.store');
    Route::get('/countries.edit.{id}', [CountryController::class, 'edit'])->name('countries.edit');
    Route::post('/countries.update.{id}', [CountryController::class, 'update'])->name('countries.update');
    Route::put('/countries.{id}', [CountryController::class, 'update'])->name('countries.update');
    // search
    Route::get('/countries.search', [CountryController::class, 'search'])->name('countries.search');
    Route::delete('/countries.{id}', [CountryController::class, 'destroy'])->name('countries.destroy');
    Route::get('countries.data', [CountryController::class, 'getCountries'])->name('countries.data');


    //Airlanes

    Route::get('airlines', [AirlineController::class, 'index'])->name('airlines.index');
    Route::get('/airlines.create', [AirlineController::class, 'create'])->name('airlines.create');
    Route::post('/airlines.store', [AirlineController::class, 'store'])->name('airlines.store');
    Route::get('/airlines.edit.{id}', [AirlineController::class, 'edit'])->name('airlines.edit');
    Route::post('/airlines.update.{id}', [AirlineController::class, 'update'])->name('airlines.update');
    Route::delete('/airlines.{id}', [AirlineController::class, 'destroy'])->name('airlines.destroy');
    Route::put('/airlines.{id}', [AirlineController::class, 'update'])->name('airlines.update');
    Route::get('/airlines.data', [App\Http\Controllers\AirlineController::class, 'getAirlines'])->name('airlines.data');

    //Airlanes

    Route::get('airport', [AirportController::class, 'index'])->name('airport.index');
    Route::get('/airport.create', [AirportController::class, 'create'])->name('airport.create');
    Route::post('/airport.store', [AirportController::class, 'store'])->name('airport.store');
    Route::get('/airport.edit.{id}', [AirportController::class, 'edit'])->name('airport.edit');
    Route::post('/airport.update.{id}', [AirportController::class, 'update'])->name('airport.update');
    Route::delete('/airport.{id}', [AirportController::class, 'destroy'])->name('airport.destroy');
    Route::put('/airport.{id}', [AirportController::class, 'update'])->name('airport.update');
    Route::get('/airport.data', [App\Http\Controllers\AirportController::class, 'getAirports'])->name('airport.data');

    //shipper

    Route::get('shipper', [ShipperController::class, 'index'])->name('shipper.index');
    Route::get('/shipper.data', [ShipperController::class, 'data'])->name('shipper.data');
    Route::get('/shipper.create', [ShipperController::class, 'create'])->name('shipper.create');
    Route::post('/shipper.store', [ShipperController::class, 'store'])->name('shipper.store');
    Route::get('/shipper.edit.{id}', [ShipperController::class, 'edit'])->name('shipper.edit');
    Route::put('/shipper.update.{id}', [ShipperController::class, 'update'])->name('shipper.update');
    Route::delete('/shipper.delete.{id}', [ShipperController::class, 'destroy'])->name('shipper.delete');
    Route::get('/shipper.data', [App\Http\Controllers\ShipperController::class, 'data'])->name('shipper.data');

    //CONSIGNEE

    Route::get('consignee', [ConsigneeController::class, 'index'])->name('consignee.index');
    Route::get('/consignee.data', [ConsigneeController::class, 'getConsignees'])->name('consignee.data');
    Route::get('/consignee.create', [ConsigneeController::class, 'create'])->name('consignee.create');
    Route::post('/consignee.store', [ConsigneeController::class, 'store'])->name('consignee.store');
    Route::get('/consignee.edit.{id}', [ConsigneeController::class, 'edit'])->name('consignee.edit');
    Route::put('/consignee.update.{id}', [ConsigneeController::class, 'update'])->name('consignee.update');
    Route::delete('/consignee.delete.{id}', [ConsigneeController::class, 'destroy'])->name('consignee.delete');


    // VESSEL
    Route::get('vessel', [VesselController::class, 'index'])->name('vessel.index');
    Route::get('/vessel.data', [VesselController::class, 'getVessels'])->name('vessel.data');
    Route::get('/vessel.create', [VesselController::class, 'create'])->name('vessel.create');
    Route::post('/vessel.store', [VesselController::class, 'store'])->name('vessel.store');
    Route::get('/vessel.edit.{id}', [VesselController::class, 'edit'])->name('vessel.edit');
    Route::put('/vessel.update.{id}', [VesselController::class, 'update'])->name('vessel.update');
    Route::delete('/vessel.delete.{id}', [VesselController::class, 'destroy'])->name('vessel.destroy');
});
