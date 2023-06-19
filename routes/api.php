<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplianceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/appliances', [ApplianceController::class, 'index'])->name('appliances.index');
Route::post('/appliances', [ApplianceController::class, 'store'])->name('appliances.store');
Route::get('/appliances/{id}', [ApplianceController::class, 'show'])->name('appliances.show');
Route::put('/appliances/{id}', [ApplianceController::class, 'update'])->name('appliances.update');
Route::delete('/appliances/{id}', [ApplianceController::class, 'destroy'])->name('appliances.destroy');

Route::get('/docs/api-docs.json', function () {
    return file_get_contents(public_path('docs/api-docs.json'));
});
