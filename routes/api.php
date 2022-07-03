<?php
use App\Http\Controllers\API\JishoHistoryController;
use App\Http\Controllers\API\JishoSearch;
use App\Http\Controllers\API\JishoSearchController;
use App\Http\Controllers\API\WordreferenceSearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('jisho_histories', JishoHistoryController::class,);
Route::get('jisho/{category}/{search}', [JishoSearchController::class, 'show']);
Route::get('wordreference/{category}/{search}', [WordreferenceSearchController::class, 'show']);