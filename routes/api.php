<?php

use App\Models\Company;
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

// Display companies' listing ordered by size - ascending or descending.
Route::get('/index/size/{order}',[Company::class, 'indexBySize']);

// Display companies' listing ordered by foundation date - ascending or descending.
Route::get('/index/founded/{order}',[Company::class, 'indexByFounded']);

// Display following data: Number of companies in each industry, 
// Number of companies in each size range, 
// Number of companies in each year of creation

Route::get('/index/analytics/',[Company::class, 'indexByAnalytics']);
