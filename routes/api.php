<?php

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;

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


//POST /users : Create a user.
Route::post('/users', [UserController::class, 'store'])
->name('users.store');
// POST /login : Login a user.
Route::post('/login', [UserController::class, 'login'])
->name('login');


//PROTECTED ROUTES
Route::group(['middleware' => ['auth:api']], function() {

// Display following data: Number of companies in each industry, 
// Number of companies in each size range, 
// Number of companies in each year of creation
Route::get('/index/analytics/',[Company::class, 'indexByAnalytics'])
->middleware('role:admin');

// Display companies' listing ordered by size - ascending or descending.
Route::get('/index/size/{order}',[Company::class, 'indexBySize']);

// Display companies' listing ordered by foundation date - ascending or descending.
Route::get('/index/founded/{order}',[Company::class, 'indexByFounded']);

//Logout user
Route::post('/logout', [UserController::class, 'logout'])
->name('logout');

}
);