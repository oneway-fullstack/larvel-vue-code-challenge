<?php

use App\Address;
use App\Car;
use App\Owner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::get('owner', 'OwnerController@index');
Route::get('owner/aggregate', function() {
    $avgAddresses = DB::table('owners')
        ->join('addresses', 'owners.id', '=', 'addresses.owner_id')
        ->selectRaw('count(*) / count(DISTINCT owners.id) as avg_addresses')
        ->value('avg_addresses');

    $avgCars = DB::table('owners')
        ->join('cars', 'owners.id', '=', 'cars.owner_id')
        ->selectRaw('count(*) / count(DISTINCT owners.id) as avg_cars')
        ->value('avg_cars');

    return response()->json([
        'avg_addresses' => $avgAddresses,
        'avg_cars' => $avgCars
    ]);
});
Route::get('owner/{owner}', 'OwnerController@show');
Route::post('owner', 'OwnerController@store');
Route::put('owner/{owner}', 'OwnerController@update');
Route::delete('owner/{owner}', 'OwnerController@delete');

Route::get('address', 'AddressController@index');
Route::get('address/aggregate', function() {
    $avgCars = DB::table('addresses')
        ->join('cars', 'addresses.id', '=', 'cars.address_id')
        ->selectRaw('count(*) / count(DISTINCT addresses.id) as avg_cars')
        ->value('avg_cars');

    return response()->json([
        'avg_cars' => $avgCars
    ]);
});
Route::get('address/{address}', 'AddressController@show');
Route::post('address', 'AddressController@store');
Route::put('address/{address}', 'AddressController@update');
Route::delete('address/{address}', 'AddressController@delete');

Route::get('car', 'CarController@index');
Route::get('car/{car}', 'CarController@show');
Route::post('car', 'CarController@store');
Route::put('car/{car}', 'CarController@update');
Route::delete('car/{car}', 'CarController@delete');

Route::get('{any}', function () {
    return view('layouts.app');
})->where('any', '.*');
