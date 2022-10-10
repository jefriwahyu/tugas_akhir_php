<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Biodata;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/getData', [Biodata::class, 'getData']);
Route::post('/simpan', [Biodata::class, 'store']);
Route::post('/ubah', [Biodata::class, 'update']);
Route::get('/hapus/{id}', [Biodata::class, 'hapus']);
Route::get('/baca/{id}', [Biodata::class, 'baca']);

