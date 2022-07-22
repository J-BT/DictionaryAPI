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

Route::get('jisho_histories', [JishoHistoryController::class, 'index'])->name('jisho_histories');
Route::get('jisho/{category}/{search}', [JishoSearchController::class, 'show'])->name('jisho_search');
Route::get('jishoHome', [JishoSearchController::class, 'jishoSearchFromHome'])->name('jisho_search_home');

Route::get('wordreference/{category}/{search}', [WordreferenceSearchController::class, 'show'])->name('wordreference_search');
Route::get('wordreferenceHome', [WordreferenceSearchController::class, 'WordreferenceSearchFromHome'])->name('wordreference_search_home');

